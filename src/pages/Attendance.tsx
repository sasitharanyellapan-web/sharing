import { useEffect, useState } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import { supabase } from '../lib/supabase';
import type { Classroom, Student, AttendanceDate, AttendanceRecord } from '../types';

type AttStatus = 'present' | 'absent' | 'excused';

const statusOrder: AttStatus[] = ['present', 'absent', 'excused'];
const statusSymbol: Record<AttStatus, string> = { present: '/', absent: 'X', excused: 'R' };
const statusColor: Record<AttStatus, string> = {
  present: 'bg-secondary-container text-on-secondary-container',
  absent: 'bg-error-container text-error',
  excused: 'bg-tertiary-fixed text-energetic-orange',
};
const statusEmpty = 'bg-surface-container text-on-surface-variant/40 hover:bg-surface-container-high';

export default function Attendance() {
  const [classrooms, setClassrooms] = useState<Classroom[]>([]);
  const [selectedClass, setSelectedClass] = useState('');
  const [students, setStudents] = useState<Student[]>([]);
  const [dates, setDates] = useState<AttendanceDate[]>([]);
  const [attendance, setAttendance] = useState<Record<string, AttStatus>>({});
  const [loading, setLoading] = useState(true);
  const [showAddDate, setShowAddDate] = useState(false);
  const [newDate, setNewDate] = useState(new Date().toISOString().slice(0, 10));

  useEffect(() => {
    supabase.from('classrooms').select('*').order('name').then(({ data }) => {
      setClassrooms((data || []) as Classroom[]);
      setLoading(false);
    });
  }, []);

  useEffect(() => {
    if (!selectedClass) return;
    setLoading(true);
    Promise.all([
      supabase.from('students').select('*').eq('classroom_id', selectedClass).order('full_name'),
      supabase.from('attendance_dates').select('*').eq('classroom_id', selectedClass).order('session_date'),
      supabase.from('attendance').select('*').eq('classroom_id', selectedClass),
    ]).then(([stuRes, dateRes, attRes]) => {
      setStudents((stuRes.data || []) as Student[]);
      setDates((dateRes.data || []) as AttendanceDate[]);
      const attMap: Record<string, AttStatus> = {};
      (attRes.data || []).forEach((a: AttendanceRecord) => {
        attMap[`${a.student_id}_${a.session_date}`] = a.status as AttStatus;
      });
      setAttendance(attMap);
      setLoading(false);
    });
  }, [selectedClass]);

  async function addDate() {
    if (!selectedClass || !newDate) return;
    const { data, error } = await supabase
      .from('attendance_dates')
      .insert({ classroom_id: selectedClass, session_date: newDate })
      .select()
      .single();
    if (!error && data) {
      setDates([...dates, data as AttendanceDate].sort((a, b) => a.session_date.localeCompare(b.session_date)));
      setShowAddDate(false);
    }
  }

  async function toggleCell(studentId: string, dateStr: string) {
    const key = `${studentId}_${dateStr}`;
    const current = attendance[key];
    let nextStatus: AttStatus | null;
    if (!current) nextStatus = 'present';
    else if (current === 'present') nextStatus = 'absent';
    else if (current === 'absent') nextStatus = 'excused';
    else nextStatus = null;

    if (nextStatus) {
      const { error } = await supabase.from('attendance').upsert(
        { student_id: studentId, classroom_id: selectedClass, session_date: dateStr, status: nextStatus },
        { onConflict: 'student_id,classroom_id,session_date' }
      );
      if (!error) setAttendance({ ...attendance, [key]: nextStatus });
    } else {
      const { error } = await supabase
        .from('attendance')
        .delete()
        .eq('student_id', studentId)
        .eq('classroom_id', selectedClass)
        .eq('session_date', dateStr);
      if (!error) {
        const next = { ...attendance };
        delete next[key];
        setAttendance(next);
      }
    }
  }

  const stats = {
    total: students.length,
    present: Object.values(attendance).filter((s) => s === 'present').length,
    absent: Object.values(attendance).filter((s) => s === 'absent').length,
    excused: Object.values(attendance).filter((s) => s === 'excused').length,
  };

  return (
    <AdminLayout
      title="Attendance"
      description="Take attendance per classroom. Toggle each cell: / (Present), X (Absent), R (Excused)."
      breadcrumb={[{ label: 'Management' }, { label: 'Attendance' }]}
      actions={
        <>
          <a href="/attendance-report" className="btn-secondary">
            <span className="material-symbols-outlined">summarize</span>
            View Report
          </a>
          {selectedClass && (
            <button onClick={() => setShowAddDate(true)} className="btn-primary">
              <span className="material-symbols-outlined">calendar_add_on</span>
              Add Date
            </button>
          )}
        </>
      }
    >
      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Students', value: stats.total, icon: 'group', bg: 'bg-primary/10 text-primary' },
          { label: 'Present', value: stats.present, icon: 'check_circle', bg: 'bg-secondary/10 text-secondary' },
          { label: 'Reasoned Absences', value: stats.excused, icon: 'info', bg: 'bg-energetic-orange/10 text-energetic-orange' },
          { label: 'Critical Absences', value: stats.absent, icon: 'cancel', bg: 'bg-error/10 text-error' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px] mb-2 inline-block`}>{s.icon}</span>
            <p className="text-[28px] font-bold text-primary leading-none">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Classroom Selector */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[250px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Select Classroom</label>
          <select value={selectedClass} onChange={(e) => setSelectedClass(e.target.value)} className="input-field">
            <option value="">Choose a classroom...</option>
            {classrooms.map((c) => (
              <option key={c.id} value={c.id}>{c.name} — {c.batch}</option>
            ))}
          </select>
        </div>
      </div>

      {!selectedClass && !loading && (
        <div className="glass-card p-stack-lg rounded-2xl text-center">
          <span className="material-symbols-outlined text-[48px] text-on-surface-variant mb-4 block">fact_check</span>
          <p className="text-body-lg text-on-surface-variant">Select a classroom to take attendance.</p>
        </div>
      )}

      {/* Legend */}
      {selectedClass && !loading && (
        <div className="flex items-center gap-4 mb-4 text-label-sm">
          <span className="font-label-bold text-on-surface-variant">Legend:</span>
          {statusOrder.map((s) => (
            <span key={s} className="flex items-center gap-1">
              <span className={`w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm ${statusColor[s]}`}>
                {statusSymbol[s]}
              </span>
              <span className="text-on-surface-variant capitalize">{s}</span>
            </span>
          ))}
          <span className="flex items-center gap-1">
            <span className={`w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm ${statusEmpty}`}>—</span>
            <span className="text-on-surface-variant">Not marked</span>
          </span>
        </div>
      )}

      {/* Attendance Grid */}
      {selectedClass && !loading && (
        <div className="glass-card rounded-2xl overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="bg-primary/5">
                  <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider sticky left-0 bg-surface-container-lowest/90 backdrop-blur z-20 min-w-[200px]">
                    Student
                  </th>
                  {dates.map((d) => {
                    const date = new Date(d.session_date);
                    const isToday = d.session_date === new Date().toISOString().slice(0, 10);
                    return (
                      <th
                        key={d.id}
                        className={`text-center font-label-bold text-label-bold px-2 py-stack-md uppercase tracking-wider min-w-[80px] ${
                          isToday ? 'bg-secondary-container/10' : ''
                        }`}
                      >
                        <div className="text-label-sm">{date.toLocaleDateString('en-MY', { day: '2-digit', month: 'short' })}</div>
                        <div className="text-[10px] text-on-surface-variant">{date.toLocaleDateString('en-MY', { weekday: 'short' })}</div>
                      </th>
                    );
                  })}
                </tr>
              </thead>
              <tbody>
                {students.length === 0 && (
                  <tr>
                    <td colSpan={dates.length + 1} className="text-center py-stack-lg text-on-surface-variant">
                      No students in this classroom.
                    </td>
                  </tr>
                )}
                {students.map((s) => (
                  <tr key={s.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                    <td className="px-stack-md py-stack-md sticky left-0 bg-surface-container-lowest/90 backdrop-blur z-20">
                      <div className="flex items-center gap-2">
                        <div className="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-xs shrink-0">
                          {s.full_name?.charAt(0).toUpperCase() || '?'}
                        </div>
                        <div>
                          <p className="font-bold text-primary text-body-md">{s.full_name}</p>
                          <p className="text-[10px] text-on-surface-variant">{s.identification_number || 'No ID'}</p>
                        </div>
                      </div>
                    </td>
                    {dates.map((d) => {
                      const key = `${s.id}_${d.session_date}`;
                      const status = attendance[key];
                      return (
                        <td key={d.id} className="text-center px-2 py-2">
                          <button
                            onClick={() => toggleCell(s.id, d.session_date)}
                            className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all hover:scale-110 ${
                              status ? statusColor[status] : statusEmpty
                            }`}
                          >
                            {status ? statusSymbol[status] : '·'}
                          </button>
                        </td>
                      );
                    })}
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {selectedClass && !loading && dates.length === 0 && students.length > 0 && (
        <div className="glass-card p-stack-md rounded-2xl mt-4 flex items-center gap-3 bg-tertiary-fixed/20">
          <span className="material-symbols-outlined text-energetic-orange">info</span>
          <p className="text-body-md text-on-surface">No class dates yet. Click "Add Date" to create a session column.</p>
        </div>
      )}

      {/* Add Date Modal */}
      {showAddDate && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-primary/40 backdrop-blur-sm" onClick={() => setShowAddDate(false)}>
          <div className="glass-card max-w-sm w-full rounded-3xl p-gutter" style={{ background: 'rgba(255,255,255,0.95)' }} onClick={(e) => e.stopPropagation()}>
            <h3 className="font-headline-sm text-headline-sm text-primary mb-4">Add Class Date</h3>
            <label className="block font-label-bold text-label-bold text-primary mb-1">Session Date</label>
            <input type="date" value={newDate} onChange={(e) => setNewDate(e.target.value)} className="input-field mb-4" />
            <div className="flex justify-end gap-2">
              <button onClick={() => setShowAddDate(false)} className="btn-secondary">Cancel</button>
              <button onClick={addDate} className="btn-primary">
                <span className="material-symbols-outlined">add</span>
                Add Date
              </button>
            </div>
          </div>
        </div>
      )}
    </AdminLayout>
  );
}
