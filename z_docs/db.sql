-- =========================================================
-- LibraLite Database Schema
-- MySQL 8+
-- =========================================================

CREATE DATABASE IF NOT EXISTS libralite
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE libralite;


-- =========================================================
-- 1. USERS
-- =========================================================

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    member_code VARCHAR(50) NULL UNIQUE,
    phone VARCHAR(20) NULL,
    address TEXT NULL,

    remember_token VARCHAR(100) NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;


-- =========================================================
-- 2. CATEGORIES
-- =========================================================

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL UNIQUE,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;


-- =========================================================
-- 3. BOOKS
-- =========================================================

CREATE TABLE books (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_id BIGINT UNSIGNED NOT NULL,

    isbn VARCHAR(20) NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NULL,
    publication_year YEAR NULL,

    stock INT UNSIGNED NOT NULL DEFAULT 0,

    description TEXT NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_books_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;


-- =========================================================
-- 4. LOANS
-- =========================================================

CREATE TABLE loans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL,

    loan_code VARCHAR(50) NOT NULL UNIQUE,

    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,

    returned_at DATETIME NULL,

    status ENUM(
        'borrowed',
        'returned',
        'overdue'
    ) NOT NULL DEFAULT 'borrowed',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_loans_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;


-- =========================================================
-- 5. LOAN ITEMS
-- =========================================================

CREATE TABLE loan_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    loan_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_loan_items_loan
        FOREIGN KEY (loan_id)
        REFERENCES loans(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_loan_items_book
        FOREIGN KEY (book_id)
        REFERENCES books(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT unique_loan_book
        UNIQUE (loan_id, book_id)
) ENGINE=InnoDB;