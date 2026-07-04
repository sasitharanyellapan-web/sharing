/*
# Code Geek Academy — Admin Portal Schema (Part 1: Tables + Functions)

Creates all tables and the is_admin() helper function.
RLS policies are added in a second migration so they can reference is_admin().
*/

-- ============================================================
-- 1. profiles
-- ============================================================
CREATE TABLE IF NOT EXISTS public.profiles (
  id uuid PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
  full_name text NOT NULL DEFAULT '',
  role text NOT NULL DEFAULT 'parent' CHECK (role IN ('admin', 'parent')),
  created_at timestamptz NOT NULL DEFAULT now()
);

-- Helper function to check if current user is an admin
CREATE OR REPLACE FUNCTION public.is_admin()
RETURNS boolean
LANGUAGE sql
SECURITY DEFINER
STABLE
AS $$
  SELECT EXISTS (
    SELECT 1 FROM public.profiles
    WHERE id = auth.uid() AND role = 'admin'
  );
$$;

-- Auto-create profile on signup
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS trigger
LANGUAGE plpgsql
SECURITY DEFINER
AS $$
BEGIN
  INSERT INTO public.profiles (id, full_name, role)
  VALUES (NEW.id, COALESCE(NEW.raw_user_meta_data->>'full_name', ''), 'parent')
  ON CONFLICT (id) DO NOTHING;
  RETURN NEW;
END;
$$;

DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
CREATE TRIGGER on_auth_user_created
  AFTER INSERT ON auth.users
  FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();

-- ============================================================
-- 2. classrooms
-- ============================================================
CREATE TABLE IF NOT EXISTS public.classrooms (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  school text DEFAULT '',
  course text DEFAULT '',
  batch text DEFAULT '',
  status text NOT NULL DEFAULT 'active' CHECK (status IN ('active', 'inactive', 'scheduled')),
  monthly_fee numeric(10,2) NOT NULL DEFAULT 0,
  classes_per_month int NOT NULL DEFAULT 4,
  attendance_rule text DEFAULT '',
  max_capacity int NOT NULL DEFAULT 20,
  teacher text DEFAULT '',
  schedule text DEFAULT '',
  location text DEFAULT '',
  image_url text DEFAULT '',
  notes text DEFAULT '',
  created_at timestamptz NOT NULL DEFAULT now()
);

-- ============================================================
-- 3. students
-- ============================================================
CREATE TABLE IF NOT EXISTS public.students (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  parent_id uuid REFERENCES public.profiles(id) ON DELETE CASCADE,
  classroom_id uuid REFERENCES public.classrooms(id) ON DELETE SET NULL,
  full_name text NOT NULL,
  date_of_birth date,
  gender text,
  school text DEFAULT '',
  year_of_study text DEFAULT '',
  identification_number text DEFAULT '',
  notes text DEFAULT '',
  created_at timestamptz NOT NULL DEFAULT now()
);

-- ============================================================
-- 4. attendance_dates
-- ============================================================
CREATE TABLE IF NOT EXISTS public.attendance_dates (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  classroom_id uuid NOT NULL REFERENCES public.classrooms(id) ON DELETE CASCADE,
  session_date date NOT NULL,
  label text DEFAULT '',
  created_at timestamptz NOT NULL DEFAULT now(),
  UNIQUE (classroom_id, session_date)
);

-- ============================================================
-- 5. attendance
-- ============================================================
CREATE TABLE IF NOT EXISTS public.attendance (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  student_id uuid NOT NULL REFERENCES public.students(id) ON DELETE CASCADE,
  classroom_id uuid NOT NULL REFERENCES public.classrooms(id) ON DELETE CASCADE,
  session_date date NOT NULL,
  status text NOT NULL DEFAULT 'present' CHECK (status IN ('present', 'absent', 'excused')),
  remarks text DEFAULT '',
  created_at timestamptz NOT NULL DEFAULT now(),
  UNIQUE (student_id, classroom_id, session_date)
);

-- ============================================================
-- 6. fee_records
-- ============================================================
CREATE TABLE IF NOT EXISTS public.fee_records (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  student_id uuid NOT NULL REFERENCES public.students(id) ON DELETE CASCADE,
  classroom_id uuid REFERENCES public.classrooms(id) ON DELETE SET NULL,
  parent_id uuid REFERENCES public.profiles(id) ON DELETE CASCADE,
  billing_month text NOT NULL,
  amount numeric(10,2) NOT NULL DEFAULT 0,
  status text NOT NULL DEFAULT 'outstanding' CHECK (status IN ('paid', 'outstanding', 'overdue')),
  payment_method text DEFAULT '',
  reference_no text DEFAULT '',
  receipt_url text DEFAULT '',
  paid_at timestamptz,
  notes text DEFAULT '',
  created_at timestamptz NOT NULL DEFAULT now(),
  UNIQUE (student_id, billing_month)
);

-- ============================================================
-- 7. registration_forms
-- ============================================================
CREATE TABLE IF NOT EXISTS public.registration_forms (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  slug text UNIQUE NOT NULL,
  title text NOT NULL,
  description text DEFAULT '',
  fields jsonb NOT NULL DEFAULT '[]'::jsonb,
  banner_url text DEFAULT '',
  accent_color text DEFAULT 'vibrant-green',
  is_published boolean NOT NULL DEFAULT false,
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now()
);

-- ============================================================
-- 8. registration_submissions
-- ============================================================
CREATE TABLE IF NOT EXISTS public.registration_submissions (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  form_id uuid NOT NULL REFERENCES public.registration_forms(id) ON DELETE CASCADE,
  student_name text DEFAULT '',
  student_email text DEFAULT '',
  student_id_number text DEFAULT '',
  year_of_study text DEFAULT '',
  school text DEFAULT '',
  guardian_name text DEFAULT '',
  guardian_phone text DEFAULT '',
  parent_consent text DEFAULT '',
  payment_date date,
  payment_proof_url text DEFAULT '',
  payment_method text DEFAULT '',
  form_data jsonb NOT NULL DEFAULT '{}'::jsonb,
  status text NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected', 'waitlisted')),
  created_at timestamptz NOT NULL DEFAULT now()
);

-- ============================================================
-- Enable RLS on all tables
-- ============================================================
ALTER TABLE public.profiles ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.classrooms ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.students ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.attendance_dates ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.attendance ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.fee_records ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.registration_forms ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.registration_submissions ENABLE ROW LEVEL SECURITY;

-- ============================================================
-- Indexes
-- ============================================================
CREATE INDEX IF NOT EXISTS idx_students_parent ON public.students(parent_id);
CREATE INDEX IF NOT EXISTS idx_students_classroom ON public.students(classroom_id);
CREATE INDEX IF NOT EXISTS idx_attendance_student ON public.attendance(student_id);
CREATE INDEX IF NOT EXISTS idx_attendance_classroom ON public.attendance(classroom_id);
CREATE INDEX IF NOT EXISTS idx_fee_records_student ON public.fee_records(student_id);
CREATE INDEX IF NOT EXISTS idx_fee_records_parent ON public.fee_records(parent_id);
CREATE INDEX IF NOT EXISTS idx_att_dates_classroom ON public.attendance_dates(classroom_id);
CREATE INDEX IF NOT EXISTS idx_reg_submissions_form ON public.registration_submissions(form_id);
CREATE INDEX IF NOT EXISTS idx_reg_forms_slug ON public.registration_forms(slug);
