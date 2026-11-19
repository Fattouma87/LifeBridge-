CREATE DATABASE IF NOT EXISTS lifebridge_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE lifebridge_db;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('donor', 'center', 'admin') NOT NULL DEFAULT 'donor',
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NULL,
    city VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blood_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    center_id INT UNSIGNED NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    units_needed INT UNSIGNED NOT NULL DEFAULT 1,
    urgency ENUM('normal', 'urgent', 'critical') NOT NULL DEFAULT 'normal',
    status ENUM('open', 'fulfilled', 'closed') NOT NULL DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_requests_center FOREIGN KEY (center_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;