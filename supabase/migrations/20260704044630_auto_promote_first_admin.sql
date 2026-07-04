/*
# Auto-promote first user to admin

Creates a trigger that sets the first registered user's role to 'admin'
so the admin portal can be accessed after initial signup.
Subsequent users remain 'parent' by default.
*/

CREATE OR REPLACE FUNCTION public.set_first_user_admin()
RETURNS trigger
LANGUAGE plpgsql
SECURITY DEFINER
AS $$
DECLARE
  user_count int;
BEGIN
  SELECT COUNT(*) INTO user_count FROM public.profiles;
  IF user_count = 0 THEN
    NEW.role = 'admin';
  END IF;
  RETURN NEW;
END;
$$;

DROP TRIGGER IF EXISTS on_profile_created ON public.profiles;
CREATE TRIGGER on_profile_created
  BEFORE INSERT ON public.profiles
  FOR EACH ROW EXECUTE FUNCTION public.set_first_user_admin();
