import { useEffect, useState, type FormEvent } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import Modal from '../components/ui/Modal';
import StatusBadge from '../components/ui/StatusBadge';
import { supabase } from '../lib/supabase';
import type { Classroom } from '../types';

export default function Classrooms() {
  const [classrooms, setClassrooms] = useState<Classroom[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const emptyForm = {
    name: '', school: '', course: '', batch: '', status: 'active' as Classroom['status'],
    monthly_fee: 0, classes_per_month: 4, attendance_rule: '', max_capacity: 20,
    teacher: '', schedule: '', location: '', notes: '',
  };
  const [form, setForm] = useState(emptyForm);

  useEffect(() => {
    fetchClassrooms();
  }, []);

  async function fetchClassrooms() {
    const { data } = await supabase
      .from('classrooms')
      .select('*, student_count:students(count)')
      .order('created_at', { ascending: false });
    setClassrooms((data || []) as unknown as Classroom[]);
    setLoading(false);
  }

  function openNew() {
    setForm(emptyForm);
    setError(null);
    setShowModal(true);
  }

  async function handleSave(e: FormEvent) {
    e.preventDefault();
    setSaving(true);
    setError(null);
    const { error } = await supabase.from('classrooms').insert({
      ...form,
      monthly_fee: Number(form.monthly_fee),
      classes_per_month: Number(form.classes_per_month),
      max_capacity: Number(form.max_capacity),
    });
    setSaving(false);
    if (error) {
      setError(error.message);
    } else {
      setShowModal(false);
      await fetchClassrooms();
    }
  }

  const stats = {
    total: classrooms.length,
    active: classrooms.filter((c) => c.status === 'active').length,
    teachers: new Set(classrooms.map((c) => c.teacher).filter(Boolean)).size,
    nearCapacity: classrooms.filter((c) => {
      const count = Array.isArray(c.student_count) ? c.student_count[0]?.count || 0 : 0;
      return c.max_capacity > 0 && count / c.max_capacity >= 0.8;
    }).length,
  };

  return (
    <AdminLayout
      title="Classroom Management"
      description="Manage classrooms, courses, and batch schedules."
      breadcrumb={[{ label: 'Management' }, { label: 'Classrooms' }]}
      actions={
        <button onClick={openNew} className="btn-primary">
          <span className="material-symbols-outlined">add_circle</span>
          New Classroom
        </button>
      }
    >
      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Rooms', value: stats.total, icon: 'meeting_room', bg: 'bg-primary/10 text-primary' },
          { label: 'Active Classes', value: stats.active, icon: 'group', bg: 'bg-secondary/10 text-secondary' },
          { label: 'Teachers', value: stats.teachers, icon: 'person_celebrate', bg: 'bg-vibrant-green/10 text-vibrant-green' },
          { label: 'Near Capacity', value: stats.nearCapacity, icon: 'bolt', bg: 'bg-energetic-orange/10 text-energetic-orange' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px] mb-2 inline-block`}>{s.icon}</span>
            <p className="text-[28px] font-bold text-primary leading-none">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Classroom Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-gutter">
        {loading && <p className="text-on-surface-variant">Loading classrooms...</p>}
        {!loading && classrooms.length === 0 && (
          <div className="col-span-full glass-card p-stack-lg rounded-2xl text-center border-2 border-dashed border-glass-border">
            <span className="material-symbols-outlined text-[48px] text-on-surface-variant mb-4 block">meeting_room</span>
            <p className="text-body-lg text-on-surface-variant mb-4">No classrooms yet.</p>
            <button onClick={openNew} className="btn-primary">
              <span className="material-symbols-outlined">add_circle</span>
              Create First Classroom
            </button>
          </div>
        )}
        {classrooms.map((c) => {
          const enrolled = Array.isArray(c.student_count) ? c.student_count[0]?.count || 0 : 0;
          const pct = c.max_capacity > 0 ? Math.min(100, (enrolled / c.max_capacity) * 100) : 0;
          const barColor = pct >= 80 ? 'bg-energetic-orange' : pct >= 50 ? 'bg-primary' : 'bg-vibrant-green';
          return (
            <div key={c.id} className="glass-card kinetic-hover rounded-2xl overflow-hidden flex flex-col md:flex-row">
              <div className="md:w-1/3 h-48 md:h-auto bg-gradient-to-tr from-primary to-deep-navy flex items-center justify-center relative">
                {c.image_url ? (
                  <img src={c.image_url} alt={c.name} className="w-full h-full object-cover" />
                ) : (
                  <span className="material-symbols-outlined text-[64px] text-on-primary/30">groups</span>
                )}
                <div className="absolute top-3 left-3">
                  <StatusBadge status={c.status} />
                </div>
              </div>
              <div className="md:w-2/3 p-stack-lg flex flex-col">
                <h3 className="font-headline-sm text-headline-sm text-primary mb-1">{c.name}</h3>
                <p className="text-label-sm text-on-surface-variant mb-3">{c.course} · {c.batch}</p>
                <div className="space-y-2 mb-4 flex-1">
                  {c.teacher && (
                    <div className="flex items-center gap-2 text-body-md text-on-surface-variant">
                      <span className="material-symbols-outlined text-[18px]">person</span>
                      {c.teacher}
                    </div>
                  )}
                  {c.schedule && (
                    <div className="flex items-center gap-2 text-body-md text-on-surface-variant">
                      <span className="material-symbols-outlined text-[18px]">schedule</span>
                      {c.schedule}
                    </div>
                  )}
                  {c.location && (
                    <div className="flex items-center gap-2 text-body-md text-on-surface-variant">
                      <span className="material-symbols-outlined text-[18px]">location_on</span>
                      {c.location}
                    </div>
                  )}
                </div>
                <div>
                  <div className="flex justify-between text-label-sm mb-1">
                    <span className="text-on-surface-variant">Capacity</span>
                    <span className="font-label-bold text-primary">{enrolled}/{c.max_capacity}</span>
                  </div>
                  <div className="w-full bg-surface-container rounded-full h-1.5">
                    <div className={`h-full rounded-full ${barColor}`} style={{ width: `${pct}%` }} />
                  </div>
                </div>
                <div className="flex items-center justify-between mt-4 pt-3 border-t border-glass-border">
                  <span className="text-body-md font-bold text-primary">RM {Number(c.monthly_fee).toFixed(0)}/month</span>
                  <span className="text-label-sm text-on-surface-variant">{c.classes_per_month} classes/mo</span>
                </div>
              </div>
            </div>
          );
        })}
      </div>

      {/* New Classroom Modal */}
      <Modal
        open={showModal}
        onClose={() => setShowModal(false)}
        title="New Classroom Registration"
        maxWidth="max-w-3xl"
        footer={
          <>
            <button onClick={() => setShowModal(false)} className="btn-secondary">Cancel</button>
            <button onClick={handleSave} disabled={saving || !form.name} className="btn-primary disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">check_circle</span>}
              Initialize Classroom
            </button>
          </>
        }
      >
        <form onSubmit={handleSave} className="space-y-4">
          {error && (
            <div className="bg-error-container/60 text-error px-4 py-3 rounded-xl flex items-center gap-2">
              <span className="material-symbols-outlined">error</span>
              <span>{error}</span>
            </div>
          )}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="md:col-span-2">
              <label className="block font-label-bold text-label-bold text-primary mb-1">Classroom Name *</label>
              <input
                type="text" required value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
                placeholder="e.g. Microbit Robotics Batch A"
                className="input-field"
              />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">School</label>
              <input type="text" value={form.school} onChange={(e) => setForm({ ...form, school: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Course</label>
              <input type="text" value={form.course} onChange={(e) => setForm({ ...form, course: e.target.value })} placeholder="e.g. Python, Web Dev" className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Batch</label>
              <input type="text" value={form.batch} onChange={(e) => setForm({ ...form, batch: e.target.value })} placeholder="e.g. 2026-A" className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Status</label>
              <select value={form.status} onChange={(e) => setForm({ ...form, status: e.target.value as Classroom['status'] })} className="input-field">
                <option value="active">Active</option>
                <option value="scheduled">Scheduled</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Assigned Teacher</label>
              <input type="text" value={form.teacher} onChange={(e) => setForm({ ...form, teacher: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Schedule</label>
              <input type="text" value={form.schedule} onChange={(e) => setForm({ ...form, schedule: e.target.value })} placeholder="e.g. Sat 9-11am" className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Location / Room</label>
              <input type="text" value={form.location} onChange={(e) => setForm({ ...form, location: e.target.value })} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Max Capacity</label>
              <input type="number" value={form.max_capacity} onChange={(e) => setForm({ ...form, max_capacity: Number(e.target.value) })} className="input-field" />
            </div>
          </div>

          {/* Billing Settings */}
          <div className="bg-surface-container-low/50 rounded-2xl p-4 border border-glass-border relative overflow-hidden">
            <span className="material-symbols-outlined absolute -right-2 -bottom-2 text-[80px] text-primary/5">payments</span>
            <h4 className="font-label-bold text-label-bold text-primary mb-3 flex items-center gap-2">
              <span className="material-symbols-outlined">payments</span>
              Billing Settings
            </h4>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 relative">
              <div>
                <label className="block font-label-bold text-label-bold text-primary mb-1">Monthly Fee (RM)</label>
                <input type="number" step="0.01" value={form.monthly_fee} onChange={(e) => setForm({ ...form, monthly_fee: Number(e.target.value) })} className="input-field" />
              </div>
              <div>
                <label className="block font-label-bold text-label-bold text-primary mb-1">Classes Per Month</label>
                <input type="number" value={form.classes_per_month} onChange={(e) => setForm({ ...form, classes_per_month: Number(e.target.value) })} className="input-field" />
              </div>
              <div>
                <label className="block font-label-bold text-label-bold text-primary mb-1">Attendance Rule</label>
                <select value={form.attendance_rule} onChange={(e) => setForm({ ...form, attendance_rule: e.target.value })} className="input-field">
                  <option value="">Select rule...</option>
                  <option value="excused_deducts_one">Excused deducts one class fee</option>
                  <option value="no_refund">No refund for absences</option>
                  <option value="makeup_credit">Automatic make-up credit</option>
                </select>
              </div>
            </div>
          </div>

          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-1">Notes</label>
            <textarea value={form.notes} onChange={(e) => setForm({ ...form, notes: e.target.value })} rows={3} className="input-field" />
          </div>
        </form>
      </Modal>
    </AdminLayout>
  );
}
