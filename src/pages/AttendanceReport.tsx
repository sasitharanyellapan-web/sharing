import { useEffect, useState, useMemo } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import { supabase } from '../lib/supabase';
import type { Classroom, Student, AttendanceRecord } from '../types';

interface StudentReport {
  student: Student;
  total: number;
  present: number;
  absent: number;
  excused: number;
  rate: number;
}

export default function AttendanceReport() {
  const [classrooms, setClassrooms] = useState<Classroom[]>([]);
  const [selectedClass, setSelectedClass] = useState('all');
  const [reports, setReports] = useState<StudentReport[]>([]);
  const [loading, setLoading] = useState(true);
  const [sortBy, setSortBy] = useState<'name' | 'rate'>('name');

  useEffect(() => {
    supabase.from('classrooms').select('*').order('name').then(({ data }) => {
      setClassrooms((data || []) as Classroom[]);
    });
  }, []);

  useEffect(() => {
    async function fetchReport() {
      setLoading(true);
      let studentQuery = supabase
        .from('students')
        .select('*, classroom:classrooms(name)')
        .order('full_name');
      if (selectedClass !== 'all') {
        studentQuery = studentQuery.eq('classroom_id', selectedClass);
      }
      const { data: stuData } = await studentQuery;
      const allStudents = (stuData || []) as unknown as Student[];

      let attQuery = supabase.from('attendance').select('*');
      if (selectedClass !== 'all') {
        attQuery = attQuery.eq('classroom_id', selectedClass);
      }
      const { data: attData } = await attQuery;
      const allAtt = (attData || []) as AttendanceRecord[];

      const reportData: StudentReport[] = allStudents.map((s) => {
        const studentAtt = allAtt.filter((a) => a.student_id === s.id);
        const total = studentAtt.length;
        const present = studentAtt.filter((a) => a.status === 'present').length;
        const absent = studentAtt.filter((a) => a.status === 'absent').length;
        const excused = studentAtt.filter((a) => a.status === 'excused').length;
        const rate = total > 0 ? Math.round((present / total) * 100) : 0;
        return { student: s, total, present, absent, excused, rate };
      });

      setReports(reportData);
      setLoading(false);
    }
    fetchReport();
  }, [selectedClass]);

  const sorted = useMemo(() => {
    const sortedReports = [...reports];
    if (sortBy === 'name') {
      sortedReports.sort((a, b) => a.student.full_name.localeCompare(b.student.full_name));
    } else {
      sortedReports.sort((a, b) => a.rate - b.rate);
    }
    return sortedReports;
  }, [reports, sortBy]);

  const summary = useMemo(() => {
    const totalSessions = reports.reduce((sum, r) => sum + r.total, 0);
    const totalPresent = reports.reduce((sum, r) => sum + r.present, 0);
    const overallRate = totalSessions > 0 ? Math.round((totalPresent / totalSessions) * 100) : 0;
    const below75 = reports.filter((r) => r.rate < 75 && r.total > 0).length;
    const className = classrooms.find((c) => c.id === selectedClass)?.name;
    return { totalSessions, overallRate, below75, className };
  }, [reports, classrooms, selectedClass]);

  function rateColor(rate: number) {
    if (rate >= 90) return 'bg-secondary-container/40 text-secondary';
    if (rate >= 75) return 'bg-tertiary-fixed/40 text-energetic-orange';
    return 'bg-error-container/60 text-error';
  }

  return (
    <AdminLayout
      title="Attendance Report"
      description="View attendance summary across classrooms. Filter and sort to identify students needing attention."
      breadcrumb={[{ label: 'Management' }, { label: 'Attendance Report' }]}
      actions={
        <button className="btn-secondary">
          <span className="material-symbols-outlined">picture_as_pdf</span>
          Download PDF
        </button>
      }
    >
      {/* Summary Cards */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Sessions', value: summary.totalSessions, icon: 'event_repeat', bg: 'bg-primary/10 text-primary', subtext: 'conducted' },
          { label: 'Overall Rate', value: `${summary.overallRate}%`, icon: 'check_circle', bg: 'bg-secondary/10 text-secondary', subtext: 'attendance' },
          { label: 'Top Class', value: summary.className || 'All', icon: 'emoji_events', bg: 'bg-vibrant-green/10 text-vibrant-green', subtext: 'highest rate' },
          { label: 'Below 75%', value: summary.below75, icon: 'warning', bg: 'bg-error/10 text-error', subtext: 'action needed' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px] mb-2 inline-block`}>{s.icon}</span>
            <p className="text-[24px] font-bold text-primary leading-none truncate">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
            <p className="text-[10px] text-on-surface-variant/70">{s.subtext}</p>
          </div>
        ))}
      </div>

      {/* Filter Bar */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Classroom</label>
          <select value={selectedClass} onChange={(e) => setSelectedClass(e.target.value)} className="input-field">
            <option value="all">All Classrooms</option>
            {classrooms.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
          </select>
        </div>
        <div className="flex-1 min-w-[150px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Sort By</label>
          <select value={sortBy} onChange={(e) => setSortBy(e.target.value as 'name' | 'rate')} className="input-field">
            <option value="name">Name (A-Z)</option>
            <option value="rate">Attendance Rate (Low to High)</option>
          </select>
        </div>
      </div>

      {/* Report Table */}
      <div className="glass-card rounded-2xl overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="bg-primary/5">
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Student</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">Classroom</th>
                <th className="text-center font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Sessions</th>
                <th className="text-center font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Present</th>
                <th className="text-center font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Absent</th>
                <th className="text-center font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden lg:table-cell">Excused</th>
                <th className="text-center font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Rate</th>
              </tr>
            </thead>
            <tbody>
              {loading && <tr><td colSpan={7} className="text-center py-stack-lg text-on-surface-variant">Loading...</td></tr>}
              {!loading && sorted.length === 0 && <tr><td colSpan={7} className="text-center py-stack-lg text-on-surface-variant">No students found.</td></tr>}
              {sorted.map((r) => (
                <tr key={r.student.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                  <td className="px-stack-md py-stack-md">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm shrink-0">
                        {r.student.full_name?.charAt(0).toUpperCase() || '?'}
                      </div>
                      <div>
                        <p className="font-bold text-primary">{r.student.full_name}</p>
                        <p className="text-label-sm text-on-surface-variant">{r.student.school || '—'}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell text-body-md text-on-surface">
                    {r.student.classroom?.name || 'Unassigned'}
                  </td>
                  <td className="px-stack-md py-stack-md text-center text-body-md text-on-surface">{r.total}</td>
                  <td className="px-stack-md py-stack-md text-center text-body-md text-secondary font-bold">{r.present}</td>
                  <td className="px-stack-md py-stack-md text-center text-body-md text-error font-bold">{r.absent}</td>
                  <td className="px-stack-md py-stack-md text-center text-body-md text-energetic-orange font-bold hidden lg:table-cell">{r.excused}</td>
                  <td className="px-stack-md py-stack-md text-center">
                    <span className={`status-badge ${rateColor(r.rate)}`}>
                      {r.total > 0 ? `${r.rate}%` : '—'}
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  );
}
