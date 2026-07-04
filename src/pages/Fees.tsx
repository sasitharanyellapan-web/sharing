import { useEffect, useState, useMemo } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import StatusBadge from '../components/ui/StatusBadge';
import Modal from '../components/ui/Modal';
import { supabase } from '../lib/supabase';
import type { FeeRecord, Student, Classroom } from '../types';

export default function Fees() {
  const [fees, setFees] = useState<FeeRecord[]>([]);
  const [students, setStudents] = useState<Student[]>([]);
  const [classrooms, setClassrooms] = useState<Classroom[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');
  const [filterClass, setFilterClass] = useState('all');
  const [showGenerate, setShowGenerate] = useState(false);
  const [genMonth, setGenMonth] = useState(new Date().toISOString().slice(0, 7));
  const [generating, setGenerating] = useState(false);
  const [genMsg, setGenMsg] = useState<string | null>(null);

  useEffect(() => {
    fetchData();
  }, []);

  async function fetchData() {
    const [feeRes, stuRes, clsRes] = await Promise.all([
      supabase
        .from('fee_records')
        .select('*, student:students(full_name), classroom:classrooms(name), parent:profiles(full_name)')
        .order('billing_month', { ascending: false })
        .order('created_at', { ascending: false }),
      supabase.from('students').select('*, classroom:classrooms(id, name, monthly_fee)').order('full_name'),
      supabase.from('classrooms').select('*').order('name'),
    ]);
    setFees((feeRes.data || []) as unknown as FeeRecord[]);
    setStudents((stuRes.data || []) as unknown as Student[]);
    setClassrooms((clsRes.data || []) as Classroom[]);
    setLoading(false);
  }

  const filtered = useMemo(() => {
    return fees.filter((f) => {
      if (filterStatus !== 'all' && f.status !== filterStatus) return false;
      if (filterClass !== 'all' && f.classroom_id !== filterClass) return false;
      if (search) {
        const q = search.toLowerCase();
        return f.student?.full_name?.toLowerCase().includes(q) || false;
      }
      return true;
    });
  }, [fees, filterStatus, filterClass, search]);

  async function markPaid(id: string) {
    const { error } = await supabase
      .from('fee_records')
      .update({ status: 'paid', paid_at: new Date().toISOString() })
      .eq('id', id);
    if (!error) {
      setFees(fees.map((f) => (f.id === id ? { ...f, status: 'paid', paid_at: new Date().toISOString() } : f)));
    }
  }

  async function generateFees() {
    setGenerating(true);
    setGenMsg(null);
    let created = 0;
    let skipped = 0;
    for (const s of students) {
      if (!s.classroom_id) continue;
      const classroom = classrooms.find((c) => c.id === s.classroom_id);
      if (!classroom || classroom.monthly_fee <= 0) continue;
      const { error } = await supabase.from('fee_records').upsert(
        {
          student_id: s.id,
          classroom_id: s.classroom_id,
          parent_id: s.parent_id,
          billing_month: genMonth,
          amount: classroom.monthly_fee,
          status: 'outstanding',
        },
        { onConflict: 'student_id,billing_month' }
      );
      if (error) skipped++;
      else created++;
    }
    setGenerating(false);
    setGenMsg(`Generated ${created} fee record(s) for ${genMonth}. ${skipped} skipped.`);
    await fetchData();
  }

  const stats = {
    totalRevenue: fees.filter((f) => f.status === 'paid').reduce((sum, f) => sum + Number(f.amount), 0),
    outstanding: fees.filter((f) => f.status !== 'paid').reduce((sum, f) => sum + Number(f.amount), 0),
    collectionRate: fees.length > 0 ? Math.round((fees.filter((f) => f.status === 'paid').length / fees.length) * 100) : 0,
    paidCount: fees.filter((f) => f.status === 'paid').length,
  };

  return (
    <AdminLayout
      title="Fee Management"
      description="Track monthly fees, outstanding balances, and payment status across all students."
      breadcrumb={[{ label: 'Management' }, { label: 'Fees' }]}
      actions={
        <>
          <button className="btn-secondary">
            <span className="material-symbols-outlined">download</span>
            Export CSV
          </button>
          <button onClick={() => { setGenMsg(null); setShowGenerate(true); }} className="btn-primary">
            <span className="material-symbols-outlined">receipt_long</span>
            Generate Monthly Fees
          </button>
        </>
      }
    >
      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Revenue', value: `RM ${stats.totalRevenue.toLocaleString('en-MY', { minimumFractionDigits: 0 })}`, icon: 'payments', bg: 'bg-secondary/10 text-secondary' },
          { label: 'Outstanding Fees', value: `RM ${stats.outstanding.toLocaleString('en-MY', { minimumFractionDigits: 0 })}`, icon: 'error', bg: 'bg-error/10 text-error' },
          { label: 'Collection Rate', value: `${stats.collectionRate}%`, icon: 'trending_up', bg: 'bg-primary/10 text-primary' },
          { label: 'Receipts Issued', value: `${stats.paidCount}/${fees.length}`, icon: 'receipt_long', bg: 'bg-vibrant-green/10 text-vibrant-green' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px] mb-2 inline-block`}>{s.icon}</span>
            <p className="text-[24px] font-bold text-primary leading-none">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Filter Bar */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Search Student</label>
          <input type="text" value={search} onChange={(e) => setSearch(e.target.value)} placeholder="Student name..." className="input-field" />
        </div>
        <div className="flex-1 min-w-[150px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Classroom</label>
          <select value={filterClass} onChange={(e) => setFilterClass(e.target.value)} className="input-field">
            <option value="all">All Classes</option>
            {classrooms.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
          </select>
        </div>
        <div className="flex-1 min-w-[150px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Status</label>
          <select value={filterStatus} onChange={(e) => setFilterStatus(e.target.value)} className="input-field">
            <option value="all">All Status</option>
            <option value="paid">Paid</option>
            <option value="outstanding">Outstanding</option>
            <option value="overdue">Overdue</option>
          </select>
        </div>
      </div>

      {/* Table */}
      <div className="glass-card rounded-2xl overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="bg-primary/5">
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Student</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">Class</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Month</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Amount</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Status</th>
                <th className="text-right font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody>
              {loading && <tr><td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">Loading...</td></tr>}
              {!loading && filtered.length === 0 && <tr><td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">No fee records found.</td></tr>}
              {filtered.map((f) => (
                <tr key={f.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                  <td className="px-stack-md py-stack-md">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm shrink-0">
                        {f.student?.full_name?.charAt(0).toUpperCase() || '?'}
                      </div>
                      <div>
                        <p className="font-bold text-primary">{f.student?.full_name || 'Unknown'}</p>
                        {f.parent?.full_name && <p className="text-label-sm text-on-surface-variant">{f.parent.full_name}</p>}
                      </div>
                    </div>
                  </td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell text-body-md text-on-surface">{f.classroom?.name || '—'}</td>
                  <td className="px-stack-md py-stack-md text-body-md text-on-surface">
                    {new Date(f.billing_month + '-01').toLocaleDateString('en-MY', { month: 'long', year: 'numeric' })}
                  </td>
                  <td className="px-stack-md py-stack-md font-bold text-primary">RM {Number(f.amount).toFixed(2)}</td>
                  <td className="px-stack-md py-stack-md"><StatusBadge status={f.status} /></td>
                  <td className="px-stack-md py-stack-md text-right">
                    {f.status !== 'paid' ? (
                      <button onClick={() => markPaid(f.id)} className="btn-secondary text-label-sm px-4 py-1.5">
                        <span className="material-symbols-outlined text-[16px]">check_circle</span>
                        Mark Paid
                      </button>
                    ) : (
                      <span className="text-label-sm text-on-surface-variant">
                        {f.paid_at ? `Paid ${new Date(f.paid_at).toLocaleDateString('en-MY')}` : 'Paid'}
                      </span>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Generate Fees Modal */}
      <Modal
        open={showGenerate}
        onClose={() => setShowGenerate(false)}
        title="Generate Monthly Fee Records"
        maxWidth="max-w-md"
        footer={
          <>
            <button onClick={() => setShowGenerate(false)} className="btn-secondary">Close</button>
            <button onClick={generateFees} disabled={generating} className="btn-primary disabled:opacity-50">
              {generating ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">receipt_long</span>}
              Generate
            </button>
          </>
        }
      >
        <div className="space-y-4">
          <p className="text-body-md text-on-surface-variant">
            This will create outstanding fee records for all students assigned to a classroom, based on the classroom's monthly fee.
          </p>
          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-1">Billing Month</label>
            <input type="month" value={genMonth} onChange={(e) => setGenMonth(e.target.value)} className="input-field" />
          </div>
          {genMsg && (
            <div className="bg-secondary-container/20 text-secondary px-4 py-3 rounded-xl flex items-center gap-2">
              <span className="material-symbols-outlined">check_circle</span>
              <span className="text-body-md">{genMsg}</span>
            </div>
          )}
        </div>
      </Modal>
    </AdminLayout>
  );
}
