-- Code Geek Academy — database schema
-- Import this file via phpMyAdmin (or `mysql -u user -p dbname < schema.sql`)
-- into the database you created for this site.

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('parent', 'admin') NOT NULL DEFAULT 'parent',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: create a first admin account yourself instead of using the
-- public admin signup form. Replace the values below, generate a password
-- hash with PHP's password_hash(), and run this INSERT manually.
--
-- INSERT INTO users (name, email, password_hash, role)
-- VALUES ('Admin Name', 'admin@codegeekacademy.com.my', '$2y$10$REPLACE_WITH_REAL_HASH', 'admin');
