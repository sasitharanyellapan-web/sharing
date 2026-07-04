import { useEffect, useState, useMemo } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import StatusBadge from '../components/ui/StatusBadge';
import Modal from '../components/ui/Modal';
import { supabase } from '../lib/supabase';
import type { RegistrationSubmission, RegistrationForm } from '../types';

export default function Registrations() {
  const [submissions, setSubmissions] = useState<RegistrationSubmission[]>([]);
  const [forms, setForms] = useState<RegistrationForm[]>([]);
  const [loading, setLoading] = useState(true);
  const [filterForm, setFilterForm] = useState('all');
  const [filterStatus, setFilterStatus] = useState('all');
  const [search, setSearch] = useState('');
  const [selected, setSelected] = useState<RegistrationSubmission | null>(null);

  useEffect(() => {
    async function fetchData() {
      const [subRes, formRes] = await Promise.all([
        supabase
          .from('registration_submissions')
          .select('*, form:registration_forms(id, title, slug)')
          .order('created_at', { ascending: false }),
        supabase.from('registration_forms').select('*').order('created_at', { ascending: false }),
      ]);
      setSubmissions((subRes.data || []) as unknown as RegistrationSubmission[]);
      setForms((formRes.data || []) as RegistrationForm[]);
      setLoading(false);
    }
    fetchData();
  }, []);

  const filtered = useMemo(() => {
    return submissions.filter((s) => {
      if (filterForm !== 'all' && s.form_id !== filterForm) return false;
      if (filterStatus !== 'all' && s.status !== filterStatus) return false;
      if (search) {
        const q = search.toLowerCase();
        return (
          s.student_name?.toLowerCase().includes(q) ||
          s.student_email?.toLowerCase().includes(q) ||
          s.guardian_name?.toLowerCase().includes(q)
        );
      }
      return true;
    });
  }, [submissions, filterForm, filterStatus, search]);

  const updateStatus = async (id: string, status: RegistrationSubmission['status']) => {
    const { error } = await supabase.from('registration_submissions').update({ status }).eq('id', id);
    if (!error) {
      setSubmissions((prev) => prev.map((s) => (s.id === id ? { ...s, status } : s)));
      if (selected?.id === id) setSelected({ ...selected, status });
    }
  };

  const stats = useMemo(() => {
    const today = new Date().toDateString();
    return {
      total: submissions.length,
      today: submissions.filter((s) => new Date(s.created_at).toDateString() === today).length,
      pending: submissions.filter((s) => s.status === 'pending').length,
      approved: submissions.filter((s) => s.status === 'approved').length,
    };
  }, [submissions]);

  return (
    <AdminLayout
      title="New Student Registration"
      description="Review and manage submissions from public registration forms."
      breadcrumb={[{ label: 'Registration' }, { label: 'Submissions' }]}
      actions={
        <button className="btn-secondary">
          <span className="material-symbols-outlined">download</span>
          Export CSV
        </button>
      }
    >
      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Submissions', value: stats.total, icon: 'inbox', bg: 'bg-primary/10 text-primary' },
          { label: 'Today', value: stats.today, icon: 'today', bg: 'bg-vibrant-green/10 text-vibrant-green' },
          { label: 'Pending Review', value: stats.pending, icon: 'pending_actions', bg: 'bg-energetic-orange/10 text-energetic-orange' },
          { label: 'Approved', value: stats.approved, icon: 'check_circle', bg: 'bg-secondary/10 text-secondary' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <div className="flex items-center gap-2 mb-2">
              <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px]`}>{s.icon}</span>
            </div>
            <p className="text-[28px] font-bold text-primary leading-none">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Filter Bar */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Form Name</label>
          <select
            value={filterForm}
            onChange={(e) => setFilterForm(e.target.value)}
            className="input-field"
          >
            <option value="all">All Forms</option>
            {forms.map((f) => (
              <option key={f.id} value={f.id}>
                {f.title} ({f.slug})
              </option>
            ))}
          </select>
        </div>
        <div className="flex-1 min-w-[150px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Status</label>
          <select
            value={filterStatus}
            onChange={(e) => setFilterStatus(e.target.value)}
            className="input-field"
          >
            <option value="all">All Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="waitlisted">Waitlisted</option>
          </select>
        </div>
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Search</label>
          <input
            type="text"
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            placeholder="Name, email, guardian..."
            className="input-field"
          />
        </div>
      </div>

      {/* Table */}
      <div className="glass-card rounded-2xl overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="bg-primary/5">
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Student Name</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">Form</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Guardian</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Submitted</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Status</th>
                <th className="text-right font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody>
              {loading && (
                <tr>
                  <td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">Loading...</td>
                </tr>
              )}
              {!loading && filtered.length === 0 && (
                <tr>
                  <td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">No submissions found.</td>
                </tr>
              )}
              {filtered.map((s) => (
                <tr key={s.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                  <td className="px-stack-md py-stack-md">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm shrink-0">
                        {s.student_name?.charAt(0).toUpperCase() || '?'}
                      </div>
                      <div>
                        <p className="font-bold text-primary">{s.student_name || 'Unknown'}</p>
                        <p className="text-label-sm text-on-surface-variant">{s.student_email || '—'}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell">
                    <p className="text-body-md text-on-surface">{s.form?.title || '—'}</p>
                    <p className="text-label-sm text-on-surface-variant">{s.form?.slug || ''}</p>
                  </td>
                  <td className="px-stack-md py-stack-md hidden lg:table-cell">
                    <p className="text-body-md text-on-surface">{s.guardian_name || '—'}</p>
                    <p className="text-label-sm text-on-surface-variant">{s.guardian_phone || ''}</p>
                  </td>
                  <td className="px-stack-md py-stack-md hidden lg:table-cell text-label-sm text-on-surface-variant">
                    {new Date(s.created_at).toLocaleDateString('en-MY', { day: '2-digit', month: 'short', year: 'numeric' })}
                  </td>
                  <td className="px-stack-md py-stack-md">
                    <StatusBadge status={s.status} />
                  </td>
                  <td className="px-stack-md py-stack-md text-right">
                    <button
                      onClick={() => setSelected(s)}
                      className="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"
                    >
                      <span className="material-symbols-outlined">visibility</span>
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Detail Modal */}
      <Modal
        open={!!selected}
        onClose={() => setSelected(null)}
        title="Submission Details"
        maxWidth="max-w-3xl"
        footer={
          selected && (
            <>
              {selected.status === 'pending' && (
                <>
                  <button
                    onClick={() => updateStatus(selected.id, 'rejected')}
                    className="btn-danger"
                  >
                    <span className="material-symbols-outlined">cancel</span>
                    Reject
                  </button>
                  <button
                    onClick={() => updateStatus(selected.id, 'approved')}
                    className="btn-primary"
                  >
                    <span className="material-symbols-outlined">check_circle</span>
                    Approve
                  </button>
                </>
              )}
              {selected.status !== 'pending' && (
                <button
                  onClick={() => updateStatus(selected.id, 'pending')}
                  className="btn-secondary"
                >
                  <span className="material-symbols-outlined">undo</span>
                  Reset to Pending
                </button>
              )}
            </>
          )
        }
      >
        {selected && (
          <div className="space-y-6">
            <div className="flex items-center justify-between">
              <div className="flex items-center gap-3">
                <div className="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold">
                  {selected.student_name?.charAt(0).toUpperCase() || '?'}
                </div>
                <div>
                  <h3 className="font-headline-sm text-headline-sm text-primary">{selected.student_name}</h3>
                  <p className="text-label-sm text-on-surface-variant">{selected.form?.title} — {selected.form?.slug}</p>
                </div>
              </div>
              <StatusBadge status={selected.status} />
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              {[
                { label: 'Student Email', value: selected.student_email },
                { label: 'ID Number', value: selected.student_id_number },
                { label: 'Year of Study', value: selected.year_of_study },
                { label: 'School', value: selected.school },
                { label: 'Guardian Name', value: selected.guardian_name },
                { label: 'Guardian Phone', value: selected.guardian_phone },
                { label: 'Parent Consent', value: selected.parent_consent },
                { label: 'Payment Method', value: selected.payment_method },
                { label: 'Payment Date', value: selected.payment_date ? new Date(selected.payment_date).toLocaleDateString('en-MY') : '—' },
                { label: 'Submitted At', value: new Date(selected.created_at).toLocaleString('en-MY') },
              ].map((f) => (
                <div key={f.label}>
                  <p className="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">{f.label}</p>
                  <p className="text-body-md text-on-surface font-medium">{f.value || '—'}</p>
                </div>
              ))}
            </div>

            {selected.payment_proof_url && (
              <div>
                <p className="text-label-sm text-on-surface-variant uppercase tracking-wider mb-2">Payment Proof</p>
                <a
                  href={selected.payment_proof_url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-primary hover:underline"
                >
                  <span className="material-symbols-outlined">receipt_long</span>
                  View Payment Proof
                </a>
              </div>
            )}

            {Object.keys(selected.form_data || {}).length > 0 && (
              <div>
                <p className="text-label-sm text-on-surface-variant uppercase tracking-wider mb-2">Additional Form Data</p>
                <div className="bg-surface-container-low rounded-xl p-4 space-y-2">
                  {Object.entries(selected.form_data).map(([key, value]) => (
                    <div key={key} className="flex justify-between">
                      <span className="text-label-sm text-on-surface-variant capitalize">{key.replace(/_/g, ' ')}:</span>
                      <span className="text-body-md text-on-surface font-medium">{String(value)}</span>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        )}
      </Modal>
    </AdminLayout>
  );
}
