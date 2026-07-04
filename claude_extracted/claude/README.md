# Code Geek Academy — /claude/ site package

This is a ready-to-upload website built from your Google Stitch designs.
It's plain PHP + HTML + Tailwind (via CDN) — no build step, no Node/Composer
needed. It's meant to be uploaded as-is to your hosting's `public_html/claude/`
folder (or wherever you want it under codegeekacademy.com.my).

## 1. Upload

Upload the ENTIRE contents of this folder (not the folder itself) into:
`public_html/claude/` in your hosting File Manager (or via FTP).

So the result on the server should look like:
```
public_html/claude/index.php
public_html/claude/about.php
public_html/claude/parent/...
public_html/claude/admin/...
public_html/claude/includes/...
```

## 2. Create the database (required for login/signup to work)

1. In cPanel, go to **MySQL Databases** and create a new database (e.g. `codegeek_claude`)
   and a database user with a password, and add that user to the database with
   ALL PRIVILEGES.
2. Go to **phpMyAdmin**, select your new database, click **Import**, and upload
   `sql/schema.sql` from this package. This creates the `users` table used for
   both parent and admin accounts.
3. Open `includes/config.php` and fill in:
   - `DB_HOST` (usually `localhost`)
   - `DB_NAME` (the database you created)
   - `DB_USER` / `DB_PASS` (the database user you created)
   - `SITE_URL` (e.g. `https://codegeekacademy.com.my/claude`)
   - `ADMIN_SIGNUP_CODE` — change this to a private code. Anyone who has this
     code can create an admin account at `/admin/signup.php`. Keep it secret,
     and consider deleting/renaming `admin/signup.php` once your staff
     accounts are created.

That's it — no other setup is required. PHP and MySQL are standard on almost
all shared hosting (cPanel) plans, so this should work without contacting support.

## 3. Site map

**Public site**
- `/` → `index.php` (Home)
- `about.php`, `programs.php`, `contact.php`

**Parent Portal** (`/parent/`)
- `login.php`, `signup.php`
- `dashboard.php`, `schedule.php`, `progress.php`, `payments.php`, `settings.php`
- `logout.php`

**Admin Panel** (`/admin/`)
- `login.php`, `signup.php` (requires the invite code from config.php)
- `dashboard.php`, `users.php`, `user-detail.php`, `content.php`,
  `course-editor.php`, `reports.php`
- `logout.php`

Parent and admin pages are protected — visiting them directly without logging
in redirects you to the matching login page.

## 4. Notes / what's still a demo

- The stats, charts, student names, tables, etc. on the dashboards are the
  original static design content from Stitch — they are NOT wired to a real
  database yet. Only the **login/signup/logout accounts system** is fully
  functional. Wiring the actual course/student/payment data to the database
  is a bigger next step — happy to help with that once you tell me what data
  you need to store.
- A handful of decorative images (avatars, some card photos) still point to
  Google's temporary Stitch preview image links. They'll display for now, but
  for a permanent site you'll want to replace them with your own photos in
  `assets/images/`.
- Some minor footer links (Privacy Policy, Terms of Service, social icons)
  are placeholders (`#`) since there's no dedicated page for them yet.
- To create your first admin account, the easiest path is to go to
  `/admin/signup.php` and sign up once using the invite code you set in
  `config.php`. After that, you can leave `admin/signup.php` in place for
  other trusted staff, or remove it and add staff directly in the database.
