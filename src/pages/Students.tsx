import { useEffect, useState, useMemo } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import Modal from '../components/ui/Modal';
import { supabase } from '../lib/supabase';
import type { Student, Classroom, Profile } from '../types';

export default function Students() {
  const [students, setStudents] = useState<Student[]>([]);
  const [classrooms, setClassrooms] = useState<Classroom[]>([]);
  const [profiles, setProfiles] = useState<Profile[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [filterClass, setFilterClass] = useState('all');
  const [showAdd, setShowAdd] = useState(false);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const emptyForm = { full_name: '', date_of_birth: '', gender: '', school: '', year_of_study: '', identification_number: '', classroom_id: '', parent_id: '', notes: '' };
  const [form, setForm] = useState(emptyForm);

  useEffect(() => {
    fetchData();
  }, []);

  async function fetchData() {
    const [stuRes, clsRes, profRes] = await Promise.all([
      supabase
        .from('students')
        .select('*, parent:profiles(full_name), classroom:classrooms(name)')
        .order('created_at', { ascending: false }),
      supabase.from('classrooms').select('*').order('name'),
      supabase.from('profiles').select('id, full_name, role, created_at').eq('role', 'parent').order('full_name'),
    ]);
    setStudents((stuRes.data || []) as unknown as Student[]);
    setClassrooms((clsRes.data || []) as Classroom[]);
    setProfiles((profRes.data || []) as Profile[]);
    setLoading(false);
  }

  const filtered = useMemo(() => {
    return students.filter((s) => {
      if (filterClass !== 'all' && s.classroom_id !== filterClass) return false;
      if (search) {
        const q = search.toLowerCase();
        return (
          s.full_name?.toLowerCase().includes(q) ||
          s.school?.toLowerCase().includes(q) ||
          s.parent?.full_name?.toLowerCase().includes(q)
        );
      }
      return true;
    });
  }, [students, filterClass, search]);

  async function handleAdd(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    setError(null);
    const { error } = await supabase.from('students').insert({
      ...form,
      parent_id: form.parent_id || null,
      classroom_id: form.classroom_id || null,
      date_of_birth: form.date_of_birth || null,
    });
    setSaving(false);
    if (error) {
      setError(error.message);
    } else {
      setShowAdd(false);
      setForm(emptyForm);
      await fetchData();
    }
  }

  return (
    <AdminLayout
      title="Student Management"
      description="View and manage all students across classrooms."
      breadcrumb={[{ label: 'Management' }, { label: 'Students' }]}
      actions={
        <button onClick={() => { setForm(emptyForm); setError(null); setShowAdd(true); }} className="btn-primary">
          <span className="material-symbols-outlined">person_add</span>
          Add Student
        </button>
      }
    >
      {/* Filter Bar */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Search</label>
          <input type="text" value={search} onChange={(e) => setSearch(e.target.value)} placeholder="Name, school, parent..." className="input-field" />
        </div>
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Classroom</label>
          <select value={filterClass} onChange={(e) => setFilterClass(e.target.value)} className="input-field">
            <option value="all">All Classrooms</option>
            {classrooms.map((c) => (
              <option key={c.id} value={c.id}>{c.name}</option>
            ))}
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
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">School</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Year</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">Classroom</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Parent</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Joined</th>
              </tr>
            </thead>
            <tbody>
              {loading && <tr><td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">Loading...</td></tr>}
              {!loading && filtered.length === 0 && <tr><td colSpan={6} className="text-center py-stack-lg text-on-surface-variant">No students found.</td></tr>}
              {filtered.map((s) => (
                <tr key={s.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                  <td className="px-stack-md py-stack-md">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm shrink-0">
                        {s.full_name?.charAt(0).toUpperCase() || '?'}
                      </div>
                      <div>
                        <p className="font-bold text-primary">{s.full_name}</p>
                        {s.identification_number && <p className="text-label-sm text-on-surface-variant">ID: {s.identification_number}</p>}
                      </div>
                    </div>
                  </td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell text-body-md text-on-surface">{s.school || '—'}</td>
                  <td className="px-stack-md py-stack-md hidden lg:table-cell text-body-md text-on-surface">{s.year_of_study || '—'}</td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell">
                    {s.classroom?.name ? (
                      <span className="px-3 py-1 bg-primary/10 text-primary rounded-full text-label-sm font-label-bold">{s.classroom.name}</span>
                    ) : (
                      <span className="text-label-sm text-on-surface-variant">Unassigned</span>
                    )}
                  </td>
                  <td className="px-stack-md py-stack-md hidden lg:table-cell text-body-md text-on-surface">{s.parent?.full_name || '—'}</td>
                  <td className="px-stack-md py-stack-md hidden lg:table-cell text-label-sm text-on-surface-variant">
                    {new Date(s.created_at).toLocaleDateString('en-MY', { day: '2-digit', month: 'short', year: 'numeric' })}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Add Student Modal */}
      <Modal
        open={showAdd}
        onClose={() => setShowAdd(false)}
        title="Add Student"
        maxWidth="max-w-2xl"
        footer={
          <>
            <button onClick={() => setShowAdd(false)} className="btn-secondary">Cancel</button>
            <button onClick={handleAdd} disabled={saving || !form.full_name} className="btn-primary disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">save</span>}
              Save Student
            </button>
          </>
        }
      >
        <form onSubmit={handleAdd} className="space-y-4">
          {error && (
            <div className="bg-error-container/60 text-error px-4 py-3 rounded-xl flex items-center gap-2">
              <span className="material-symbols-outlined">error</span>
              <span>{error}</span>
            </div>
          )}
          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-1">Full Name *</label>
            <input type="text" required value={form.full_name} onChange={(e) => setForm({ ...form, full_name: e.target.value })} className="input-field" />
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Date of Birth</label>
              <input type="date" value={form.date_of_birth} onChange={(e) => setForm({ ...form, date_of_birth: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Gender</label>
              <select value={form.gender} onChange={(e) => setForm({ ...form, gender: e.target.value })} className="input-field">
                <option value="">Select...</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">School</label>
              <input type="text" value={form.school} onChange={(e) => setForm({ ...form, school: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Year of Study</label>
              <input type="text" value={form.year_of_study} onChange={(e) => setForm({ ...form, year_of_study: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">ID Number</label>
              <input type="text" value={form.identification_number} onChange={(e) => setForm({ ...form, identification_number: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Classroom</label>
              <select value={form.classroom_id} onChange={(e) => setForm({ ...form, classroom_id: e.target.value })} className="input-field">
                <option value="">Unassigned</option>
                {classrooms.map((c) => (
                  <option key={c.id} value={c.id}>{c.name}</option>
                ))}
              </select>
            </div>
            <div className="md:col-span-2">
              <label className="block font-label-bold text-label-bold text-primary mb-1">Parent Account</label>
              <select value={form.parent_id} onChange={(e) => setForm({ ...form, parent_id: e.target.value })} className="input-field">
                <option value="">Select parent...</option>
                {profiles.map((p) => (
                  <option key={p.id} value={p.id}>{p.full_name}</option>
                ))}
              </select>
            </div>
          </div>
          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-1">Notes</label>
            <textarea value={form.notes} onChange={(e) => setForm({ ...form, notes: e.target.value })} rows={2} className="input-field" />
          </div>
        </form>
      </Modal>
    </AdminLayout>
  );
}
