-- Code Geek Academy — Parent Portal v2 migration
-- Run this AFTER schema.sql has already been imported (it only adds new
-- tables, it does not touch the existing `users` table).
-- Import via phpMyAdmin > Import, or:
--   mysql -u your_db_username -p your_db_name < schema_v2_parent_portal.sql

-- ---------------------------------------------------------------
-- 1. Children registered by a parent
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS children (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    date_of_birth DATE NULL,
    gender ENUM('male', 'female') NULL,
    program VARCHAR(100) NULL,
    notes VARCHAR(500) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_children_parent FOREIGN KEY (parent_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------
-- 2. Tuition fee submissions (2.1 Fee Submission / 2.2 Fee Record
--    are both powered by this one table — submission INSERTs a row,
--    record just lists them)
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS fee_payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED NOT NULL,
    child_id INT UNSIGNED NOT NULL,
    billing_period VARCHAR(50) NOT NULL,          -- e.g. "July 2026"
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('bank_transfer','online_banking','duitnow','cash','other') NOT NULL,
    reference_no VARCHAR(100) NULL,
    receipt_path VARCHAR(255) NULL,               -- uploaded proof of payment, if any
    notes VARCHAR(500) NULL,
    status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
    submitted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_fee_parent FOREIGN KEY (parent_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_fee_child FOREIGN KEY (child_id) REFERENCES children(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------
-- 3. Attendance records
--    (Parents can only VIEW these. There is no admin UI to create
--    them yet — an admin/staff attendance-marking screen would be
--    the natural next step.)
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS attendance (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id INT UNSIGNED NOT NULL,
    session_date DATE NOT NULL,
    program VARCHAR(100) NULL,
    status ENUM('present','absent','late') NOT NULL DEFAULT 'present',
    remarks VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attendance_child FOREIGN KEY (child_id) REFERENCES children(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
