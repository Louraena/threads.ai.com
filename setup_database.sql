-- Create database
CREATE DATABASE IF NOT EXISTS threads_clone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE threads_clone;

-- Create login_attempts table
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Create a user for the application (recommended for production)
-- CREATE USER 'threads_user'@'localhost' IDENTIFIED BY 'your_secure_password';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON threads_clone.* TO 'threads_user'@'localhost';
-- FLUSH PRIVILEGES;