-- =========================================================
-- LibraLite Database Schema
-- MySQL 8+
--
-- Aligned with PRD.md + TASK.md.
--
-- v2 change (per request): `members` merged back into `users`.
-- There is now a single `users` table for both Admin and Member
-- accounts. Member-only fields (member_code, phone, address,
-- date_of_birth, member_status, joined_at) are nullable, since
-- Admin users don't use them. Which account is an Admin vs a
-- Member is determined by the Spatie role assigned in
-- model_has_roles, not by a column here.
--
-- Everything that referenced `members.id` (attendances,
-- borrowings, payments) now references `users.id` directly.
--
-- Other changes carried over from the previous revision:
--   * categories        -> added slug, description, status (PRD #9).
--   * books              -> added status; cover image lives in
--                         `media` via Spatie Media Library.
--   * loans/loan_items -> replaced by `borrowings` (one book per
--                         transaction, matches the 3-active-
--                         borrowings limit in PRD #11).
--   * fines              -> new table (PRD #14), snapshots
--                         rate/amount so config changes don't
--                         rewrite history.
--   * payments           -> new table (PRD #15, Midtrans).
--   * attendances        -> new table (PRD #7).
--   * roles/permissions   -> Spatie Laravel Permission defaults.
--   * media               -> Spatie Media Library defaults.
--   * notifications       -> Laravel's built-in notifications table.
--   * activity_log        -> Spatie Activitylog defaults.
--   * password_reset_tokens -> required by Breeze forgot/reset flow.
--
-- Framework boilerplate tables Laravel generates automatically
-- (`sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`,
-- `failed_jobs`, `personal_access_tokens`) are intentionally not
-- hand-written here.
-- =========================================================

CREATE DATABASE IF NOT EXISTS libralite
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE libralite;


-- =========================================================
-- 1. USERS (auth + member profile, PRD #4 and #6 combined)
-- Admin and Member share this table. Role (Admin/Member) is
-- determined via Spatie's model_has_roles, not a column here.
-- =========================================================

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,

    -- Member-only fields (PRD #6). NULL for Admin accounts.
    member_code VARCHAR(20) NULL UNIQUE COMMENT 'e.g. LIB-000001. Null for Admin accounts.',
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    date_of_birth DATE NULL,
    member_status ENUM('active', 'inactive') NULL COMMENT 'Null for Admin accounts.',
    joined_at DATE NULL COMMENT 'Membership start date. Null for Admin accounts.',

    remember_token VARCHAR(100) NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_users_member_status (member_status)
) ENGINE=InnoDB;
-- Profile photo (PRD #6) and book cover (PRD #8) are both stored
-- via the `media` table, not a column here.


CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB;


-- =========================================================
-- 2. CATEGORIES (PRD #9 — Category Management)
-- =========================================================

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;


-- =========================================================
-- 3. BOOKS (PRD #8, #10 — Book Management & Availability)
-- =========================================================

CREATE TABLE books (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_id BIGINT UNSIGNED NOT NULL,

    isbn VARCHAR(20) NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NULL,
    publication_year YEAR NULL,

    stock INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Total stock. Available stock = stock - active borrowings, computed, not stored.',

    description TEXT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_books_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    INDEX idx_books_status (status)
) ENGINE=InnoDB;


-- =========================================================
-- 4. ATTENDANCES (PRD #7 — Library Attendance)
-- Check-in only, no check-out. One check-in per member per day.
-- =========================================================

CREATE TABLE attendances (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL COMMENT 'Member (users.id)',

    check_in_date DATE NOT NULL,
    check_in_time TIME NOT NULL,
    status ENUM('present') NOT NULL DEFAULT 'present',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_attendances_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT unique_user_checkin_per_day
        UNIQUE (user_id, check_in_date),

    INDEX idx_attendances_date (check_in_date)
) ENGINE=InnoDB;


-- =========================================================
-- 5. BORROWINGS (PRD #11-13 — Borrowing & Returning)
-- One row = one book borrowed by one member. The 3-active-
-- borrowings limit is enforced against this table directly.
-- =========================================================

CREATE TABLE borrowings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL COMMENT 'Member (users.id)',
    book_id BIGINT UNSIGNED NOT NULL,
    processed_by BIGINT UNSIGNED NULL COMMENT 'Admin (users.id) who processed the return',

    borrow_code VARCHAR(50) NOT NULL UNIQUE,

    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    returned_at DATETIME NULL,

    status ENUM(
        'borrowed',
        'returned',
        'overdue'
    ) NOT NULL DEFAULT 'borrowed',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_borrowings_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_borrowings_book
        FOREIGN KEY (book_id)
        REFERENCES books(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_borrowings_processed_by
        FOREIGN KEY (processed_by)
        REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    INDEX idx_borrowings_status (status),
    INDEX idx_borrowings_user_status (user_id, status),
    INDEX idx_borrowings_due_date (due_date)
) ENGINE=InnoDB;


-- =========================================================
-- 6. FINES (PRD #14 — Fine Management)
-- One fine per borrowing. rate_per_day/amount are snapshotted
-- at calculation time so later config changes don't alter
-- historical fines.
-- =========================================================

CREATE TABLE fines (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    borrowing_id BIGINT UNSIGNED NOT NULL UNIQUE,

    rate_per_day DECIMAL(10,2) NOT NULL DEFAULT 2000.00,
    overdue_days INT UNSIGNED NOT NULL DEFAULT 0,
    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    status ENUM('unpaid', 'paid', 'waived') NOT NULL DEFAULT 'unpaid',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_fines_borrowing
        FOREIGN KEY (borrowing_id)
        REFERENCES borrowings(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    INDEX idx_fines_status (status)
) ENGINE=InnoDB;


-- =========================================================
-- 7. PAYMENTS (PRD #15 — Online Fine Payment via Midtrans)
-- =========================================================

CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    fine_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL COMMENT 'Member (users.id)',

    order_id VARCHAR(100) NOT NULL UNIQUE COMMENT 'Unique order/transaction ID sent to Midtrans',
    transaction_id VARCHAR(100) NULL COMMENT 'Midtrans transaction_id from notification payload',

    provider VARCHAR(50) NOT NULL DEFAULT 'midtrans',
    payment_type VARCHAR(50) NULL COMMENT 'e.g. bank_transfer, gopay, credit_card',

    amount DECIMAL(10,2) NOT NULL,
    status ENUM(
        'pending',
        'paid',
        'failed',
        'expired',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',

    paid_at DATETIME NULL,
    raw_response JSON NULL COMMENT 'Raw Midtrans notification payload, for audit/verification',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_payments_fine
        FOREIGN KEY (fine_id)
        REFERENCES fines(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_payments_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    INDEX idx_payments_status (status)
) ENGINE=InnoDB;


-- =========================================================
-- 8. ROLES & PERMISSIONS (Spatie Laravel Permission defaults)
-- TASK 2.2
-- =========================================================

CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY permissions_name_guard_unique (name, guard_name)
) ENGINE=InnoDB;

CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY roles_name_guard_unique (name, guard_name)
) ENGINE=InnoDB;

CREATE TABLE model_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    INDEX idx_model_has_permissions_model (model_id, model_type),
    CONSTRAINT fk_mhp_permission
        FOREIGN KEY (permission_id)
        REFERENCES permissions(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    INDEX idx_model_has_roles_model (model_id, model_type),
    CONSTRAINT fk_mhr_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    CONSTRAINT fk_rhp_permission
        FOREIGN KEY (permission_id)
        REFERENCES permissions(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_rhp_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;


-- =========================================================
-- 9. MEDIA (Spatie Laravel Media Library defaults)
-- TASK 6.2 (book cover) + member profile photo
-- =========================================================

CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,

    uuid CHAR(36) NULL UNIQUE,
    collection_name VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    mime_type VARCHAR(255) NULL,
    disk VARCHAR(255) NOT NULL,
    conversions_disk VARCHAR(255) NULL,
    size BIGINT UNSIGNED NOT NULL,

    manipulations JSON NOT NULL,
    custom_properties JSON NOT NULL,
    generated_conversions JSON NOT NULL,
    responsive_images JSON NOT NULL,

    order_column INT UNSIGNED NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_media_model (model_type, model_id),
    INDEX idx_media_order (order_column)
) ENGINE=InnoDB;


-- =========================================================
-- 10. NOTIFICATIONS (Laravel built-in notifications table)
-- TASK 11.2 — in-app notifications
-- =========================================================

CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,

    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_notifications_notifiable (notifiable_type, notifiable_id)
) ENGINE=InnoDB;


-- =========================================================
-- 11. ACTIVITY LOG (Spatie Laravel Activitylog defaults)
-- TASK Phase 15
-- =========================================================

CREATE TABLE activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,

    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,

    event VARCHAR(255) NULL,

    causer_type VARCHAR(255) NULL,
    causer_id BIGINT UNSIGNED NULL,

    properties JSON NULL,
    batch_uuid CHAR(36) NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_activity_log_subject (subject_type, subject_id),
    INDEX idx_activity_log_causer (causer_type, causer_id),
    INDEX idx_activity_log_log_name (log_name)
) ENGINE=InnoDB;
