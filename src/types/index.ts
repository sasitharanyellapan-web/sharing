export type UserRole = 'admin' | 'parent';

export interface Profile {
  id: string;
  full_name: string;
  role: UserRole;
  created_at: string;
  email?: string;
}

export interface Classroom {
  id: string;
  name: string;
  school: string;
  course: string;
  batch: string;
  status: 'active' | 'inactive' | 'scheduled';
  monthly_fee: number;
  classes_per_month: number;
  attendance_rule: string;
  max_capacity: number;
  teacher: string;
  schedule: string;
  location: string;
  image_url: string;
  notes: string;
  created_at: string;
  student_count?: { count: number }[] | number;
}

export interface Student {
  id: string;
  parent_id: string | null;
  classroom_id: string | null;
  full_name: string;
  date_of_birth: string | null;
  gender: string | null;
  school: string;
  year_of_study: string;
  identification_number: string;
  notes: string;
  created_at: string;
  parent_name?: string;
  parent_email?: string;
  classroom_name?: string;
  parent?: { full_name: string } | null;
  classroom?: { name: string; id: string; monthly_fee: number } | null;
}

export interface AttendanceDate {
  id: string;
  classroom_id: string;
  session_date: string;
  label: string;
  created_at: string;
}

export interface AttendanceRecord {
  id: string;
  student_id: string;
  classroom_id: string;
  session_date: string;
  status: 'present' | 'absent' | 'excused';
  remarks: string;
  created_at: string;
  student_name?: string;
  student?: { full_name: string } | null;
}

export interface FeeRecord {
  id: string;
  student_id: string;
  classroom_id: string | null;
  parent_id: string | null;
  billing_month: string;
  amount: number;
  status: 'paid' | 'outstanding' | 'overdue';
  payment_method: string;
  reference_no: string;
  receipt_url: string;
  paid_at: string | null;
  notes: string;
  created_at: string;
  student_name?: string;
  classroom_name?: string;
  parent_name?: string;
  student?: { full_name: string } | null;
  classroom?: { name: string } | null;
  parent?: { full_name: string } | null;
}

export interface FormField {
  id: string;
  type: 'text' | 'email' | 'phone' | 'number' | 'radio' | 'checkbox' | 'date' | 'upload' | 'textarea' | 'select';
  label: string;
  placeholder: string;
  required: boolean;
  options?: string[];
  section: string;
}

export interface RegistrationForm {
  id: string;
  slug: string;
  title: string;
  description: string;
  fields: FormField[];
  banner_url: string;
  accent_color: string;
  is_published: boolean;
  created_at: string;
  updated_at: string;
  submission_count?: { count: number }[] | number;
}

export interface RegistrationSubmission {
  id: string;
  form_id: string;
  student_name: string;
  student_email: string;
  student_id_number: string;
  year_of_study: string;
  school: string;
  guardian_name: string;
  guardian_phone: string;
  parent_consent: string;
  payment_date: string | null;
  payment_proof_url: string;
  payment_method: string;
  form_data: Record<string, unknown>;
  status: 'pending' | 'approved' | 'rejected' | 'waitlisted';
  created_at: string;
  form_title?: string;
  form_slug?: string;
  form?: { id: string; title: string; slug: string } | null;
}
