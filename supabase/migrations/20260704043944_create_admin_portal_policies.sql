/*
# Code Geek Academy — Admin Portal Schema (Part 2: RLS Policies)

Adds all RLS policies referencing the is_admin() helper function.
- profiles: users read/update own; admins manage all
- classrooms: all authenticated can read; admins write
- students: parents manage own; admins manage all
- attendance_dates: all authenticated can read; admins write
- attendance: parents read own children's; admins manage all
- fee_records: parents manage own; admins manage all
- registration_forms: all authenticated can read; admins write
- registration_submissions: admins only
*/

-- ============================================================
-- profiles policies
-- ============================================================
DROP POLICY IF EXISTS "profiles_select_own_or_admin" ON public.profiles;
CREATE POLICY "profiles_select_own_or_admin" ON public.profiles
  FOR SELECT TO authenticated USING (auth.uid() = id OR public.is_admin());

DROP POLICY IF EXISTS "profiles_update_own" ON public.profiles;
CREATE POLICY "profiles_update_own" ON public.profiles
  FOR UPDATE TO authenticated USING (auth.uid() = id) WITH CHECK (auth.uid() = id);

DROP POLICY IF EXISTS "profiles_admin_update" ON public.profiles;
CREATE POLICY "profiles_admin_update" ON public.profiles
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "profiles_admin_insert" ON public.profiles;
CREATE POLICY "profiles_admin_insert" ON public.profiles
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "profiles_admin_delete" ON public.profiles;
CREATE POLICY "profiles_admin_delete" ON public.profiles
  FOR DELETE TO authenticated USING (public.is_admin());

-- ============================================================
-- classrooms policies
-- ============================================================
DROP POLICY IF EXISTS "classrooms_select" ON public.classrooms;
CREATE POLICY "classrooms_select" ON public.classrooms
  FOR SELECT TO authenticated USING (true);

DROP POLICY IF EXISTS "classrooms_admin_insert" ON public.classrooms;
CREATE POLICY "classrooms_admin_insert" ON public.classrooms
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "classrooms_admin_update" ON public.classrooms;
CREATE POLICY "classrooms_admin_update" ON public.classrooms
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "classrooms_admin_delete" ON public.classrooms;
CREATE POLICY "classrooms_admin_delete" ON public.classrooms
  FOR DELETE TO authenticated USING (public.is_admin());

-- ============================================================
-- students policies
-- ============================================================
DROP POLICY IF EXISTS "students_select_own_or_admin" ON public.students;
CREATE POLICY "students_select_own_or_admin" ON public.students
  FOR SELECT TO authenticated USING (parent_id = auth.uid() OR public.is_admin());

DROP POLICY IF EXISTS "students_insert_own_or_admin" ON public.students;
CREATE POLICY "students_insert_own_or_admin" ON public.students
  FOR INSERT TO authenticated WITH CHECK (parent_id = auth.uid() OR public.is_admin());

DROP POLICY IF EXISTS "students_update_own_or_admin" ON public.students;
CREATE POLICY "students_update_own_or_admin" ON public.students
  FOR UPDATE TO authenticated USING (parent_id = auth.uid() OR public.is_admin())
  WITH CHECK (parent_id = auth.uid() OR public.is_admin());

DROP POLICY IF EXISTS "students_delete_own_or_admin" ON public.students;
CREATE POLICY "students_delete_own_or_admin" ON public.students
  FOR DELETE TO authenticated USING (parent_id = auth.uid() OR public.is_admin());

-- ============================================================
-- attendance_dates policies
-- ============================================================
DROP POLICY IF EXISTS "att_dates_select" ON public.attendance_dates;
CREATE POLICY "att_dates_select" ON public.attendance_dates
  FOR SELECT TO authenticated USING (true);

DROP POLICY IF EXISTS "att_dates_admin_insert" ON public.attendance_dates;
CREATE POLICY "att_dates_admin_insert" ON public.attendance_dates
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "att_dates_admin_update" ON public.attendance_dates;
CREATE POLICY "att_dates_admin_update" ON public.attendance_dates
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "att_dates_admin_delete" ON public.attendance_dates;
CREATE POLICY "att_dates_admin_delete" ON public.attendance_dates
  FOR DELETE TO authenticated USING (public.is_admin());

-- ============================================================
-- attendance policies
-- ============================================================
DROP POLICY IF EXISTS "attendance_select_own_or_admin" ON public.attendance;
CREATE POLICY "attendance_select_own_or_admin" ON public.attendance
  FOR SELECT TO authenticated USING (
    public.is_admin() OR EXISTS (
      SELECT 1 FROM public.students s
      WHERE s.id = attendance.student_id AND s.parent_id = auth.uid()
    )
  );

DROP POLICY IF EXISTS "attendance_admin_insert" ON public.attendance;
CREATE POLICY "attendance_admin_insert" ON public.attendance
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "attendance_admin_update" ON public.attendance;
CREATE POLICY "attendance_admin_update" ON public.attendance
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "attendance_admin_delete" ON public.attendance;
CREATE POLICY "attendance_admin_delete" ON public.attendance
  FOR DELETE TO authenticated USING (public.is_admin());

-- ============================================================
-- fee_records policies
-- ============================================================
DROP POLICY IF EXISTS "fees_select_own_or_admin" ON public.fee_records;
CREATE POLICY "fees_select_own_or_admin" ON public.fee_records
  FOR SELECT TO authenticated USING (
    public.is_admin() OR parent_id = auth.uid()
  );

DROP POLICY IF EXISTS "fees_insert_own_or_admin" ON public.fee_records;
CREATE POLICY "fees_insert_own_or_admin" ON public.fee_records
  FOR INSERT TO authenticated WITH CHECK (parent_id = auth.uid() OR public.is_admin());

DROP POLICY IF EXISTS "fees_update_own_or_admin" ON public.fee_records;
CREATE POLICY "fees_update_own_or_admin" ON public.fee_records
  FOR UPDATE TO authenticated USING (parent_id = auth.uid() OR public.is_admin())
  WITH CHECK (parent_id = auth.uid() OR public.is_admin());

DROP POLICY IF EXISTS "fees_delete_own_or_admin" ON public.fee_records;
CREATE POLICY "fees_delete_own_or_admin" ON public.fee_records
  FOR DELETE TO authenticated USING (parent_id = auth.uid() OR public.is_admin());

-- ============================================================
-- registration_forms policies
-- ============================================================
DROP POLICY IF EXISTS "reg_forms_select" ON public.registration_forms;
CREATE POLICY "reg_forms_select" ON public.registration_forms
  FOR SELECT TO authenticated USING (true);

DROP POLICY IF EXISTS "reg_forms_admin_insert" ON public.registration_forms;
CREATE POLICY "reg_forms_admin_insert" ON public.registration_forms
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "reg_forms_admin_update" ON public.registration_forms;
CREATE POLICY "reg_forms_admin_update" ON public.registration_forms
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "reg_forms_admin_delete" ON public.registration_forms;
CREATE POLICY "reg_forms_admin_delete" ON public.registration_forms
  FOR DELETE TO authenticated USING (public.is_admin());

-- ============================================================
-- registration_submissions policies
-- ============================================================
DROP POLICY IF EXISTS "reg_submissions_select" ON public.registration_submissions;
CREATE POLICY "reg_submissions_select" ON public.registration_submissions
  FOR SELECT TO authenticated USING (public.is_admin());

DROP POLICY IF EXISTS "reg_submissions_admin_insert" ON public.registration_submissions;
CREATE POLICY "reg_submissions_admin_insert" ON public.registration_submissions
  FOR INSERT TO authenticated WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "reg_submissions_admin_update" ON public.registration_submissions;
CREATE POLICY "reg_submissions_admin_update" ON public.registration_submissions
  FOR UPDATE TO authenticated USING (public.is_admin()) WITH CHECK (public.is_admin());

DROP POLICY IF EXISTS "reg_submissions_admin_delete" ON public.registration_submissions;
CREATE POLICY "reg_submissions_admin_delete" ON public.registration_submissions
  FOR DELETE TO authenticated USING (public.is_admin());
