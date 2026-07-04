import { useEffect, useState } from 'react';
import { supabase } from '../lib/supabase';

export interface DashboardStats {
  totalStudents: number;
  totalClassrooms: number;
  pendingSubmissions: number;
  outstandingFees: number;
  totalRevenue: number;
  attendanceRate: number;
  activeClassrooms: number;
}

export interface ActivityItem {
  id: string;
  type: 'enrollment' | 'payment' | 'registration' | 'classroom';
  message: string;
  subtext: string;
  icon: string;
  color: string;
  timestamp: string;
}

export function useDashboardStats() {
  const [stats, setStats] = useState<DashboardStats>({
    totalStudents: 0,
    totalClassrooms: 0,
    pendingSubmissions: 0,
    outstandingFees: 0,
    totalRevenue: 0,
    attendanceRate: 0,
    activeClassrooms: 0,
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchStats() {
      const [students, classrooms, submissions, fees, attendance] = await Promise.all([
        supabase.from('students').select('id', { count: 'exact', head: true }),
        supabase.from('classrooms').select('id, status'),
        supabase
          .from('registration_submissions')
          .select('id', { count: 'exact', head: true })
          .eq('status', 'pending'),
        supabase.from('fee_records').select('amount, status'),
        supabase.from('attendance').select('status'),
      ]);

      const allClassrooms = classrooms.data || [];
      const feeData = fees.data || [];
      const attData = attendance.data || [];
      const present = attData.filter((a) => a.status === 'present').length;

      setStats({
        totalStudents: students.count || 0,
        totalClassrooms: allClassrooms.length,
        pendingSubmissions: submissions.count || 0,
        outstandingFees: feeData
          .filter((f) => f.status !== 'paid')
          .reduce((sum, f) => sum + Number(f.amount), 0),
        totalRevenue: feeData
          .filter((f) => f.status === 'paid')
          .reduce((sum, f) => sum + Number(f.amount), 0),
        attendanceRate: attData.length > 0 ? Math.round((present / attData.length) * 100) : 0,
        activeClassrooms: allClassrooms.filter((c) => c.status === 'active').length,
      });
      setLoading(false);
    }
    fetchStats();
  }, []);

  return { stats, loading };
}

export function useRecentActivity() {
  const [activities, setActivities] = useState<ActivityItem[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchActivity() {
      const [recentStudents, recentFees, recentSubmissions, recentClassrooms] = await Promise.all([
        supabase
          .from('students')
          .select('id, full_name, created_at, classroom_name:classrooms(name)')
          .order('created_at', { ascending: false })
          .limit(5),
        supabase
          .from('fee_records')
          .select('id, amount, status, billing_month, student:students(full_name), created_at')
          .order('created_at', { ascending: false })
          .limit(5),
        supabase
          .from('registration_submissions')
          .select('id, student_name, status, created_at, form:registration_forms(title)')
          .order('created_at', { ascending: false })
          .limit(5),
        supabase
          .from('classrooms')
          .select('id, name, created_at')
          .order('created_at', { ascending: false })
          .limit(3),
      ]);

      const items: ActivityItem[] = [];

      (recentStudents.data || []).forEach((s: any) => {
        items.push({
          id: `student-${s.id}`,
          type: 'enrollment',
          message: `${s.full_name} enrolled`,
          subtext: s.classroom_name?.name ? `in ${s.classroom_name.name}` : 'New student',
          icon: 'person_add',
          color: 'vibrant-green',
          timestamp: s.created_at,
        });
      });

      (recentFees.data || []).forEach((f: any) => {
        items.push({
          id: `fee-${f.id}`,
          type: 'payment',
          message: `Payment ${f.status === 'paid' ? 'received' : 'submitted'} from ${f.student?.full_name || 'Unknown'}`,
          subtext: `RM ${Number(f.amount).toFixed(2)} — ${f.billing_month}`,
          icon: 'payments',
          color: 'primary',
          timestamp: f.created_at,
        });
      });

      (recentSubmissions.data || []).forEach((s: any) => {
        items.push({
          id: `sub-${s.id}`,
          type: 'registration',
          message: `New registration: ${s.student_name}`,
          subtext: s.form?.title || 'Registration form',
          icon: 'dynamic_form',
          color: 'energetic-orange',
          timestamp: s.created_at,
        });
      });

      (recentClassrooms.data || []).forEach((c) => {
        items.push({
          id: `class-${c.id}`,
          type: 'classroom',
          message: `Classroom ${c.name} created`,
          subtext: 'New classroom',
          icon: 'meeting_room',
          color: 'deep-navy',
          timestamp: c.created_at,
        });
      });

      items.sort((a, b) => new Date(b.timestamp).getTime() - new Date(a.timestamp).getTime());
      setActivities(items.slice(0, 8));
      setLoading(false);
    }
    fetchActivity();
  }, []);

  return { activities, loading };
}
