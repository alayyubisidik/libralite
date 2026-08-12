# LibraLite — Product Requirements Document

## 1. Product Overview

**LibraLite** is a modern web-based library management system designed to support the day-to-day operations of a library.

The system manages:

* Members
* Books
* Categories
* Library attendance
* Borrowing
* Returning
* Fines
* Online fine payments
* Notifications
* Reports
* Library activity history

The primary operational workflow is centered around library visitors.

When a visitor arrives, an administrator can create or identify the member. The member is identified using their **Member Code**, and their library attendance is recorded through a check-in process.

LibraLite also manages the complete book lifecycle, from inventory and borrowing to returning and fine management.

Members with unpaid fines can pay their fines online through **Midtrans**.

LibraLite is primarily developed as a **practice project for Agentic AI software development**, while maintaining realistic business requirements, clean architecture, maintainable code, and a professional user experience.

---

# 2. Product Goals

## Primary Goals

1. Provide a centralized system for managing library operations.
2. Make member management simple for administrators.
3. Provide a fast attendance/check-in process using Member Code.
4. Manage book inventory and availability.
5. Manage borrowing and returning transactions.
6. Automatically calculate overdue fines.
7. Allow members to pay fines online.
8. Provide email and in-app notifications.
9. Provide useful dashboards and reports.
10. Provide role-based access control.
11. Maintain accurate library transaction and inventory data.
12. Serve as a realistic project for practicing Agentic AI development.

---

# 3. Target Users

LibraLite has two primary roles:

## 3.1 Admin

Admin is the primary operator of the library system.

Admin can:

* Manage members
* Create member accounts
* Manage books
* Manage categories
* Manage borrowing
* Process returns
* Manage fines
* Monitor attendance
* View dashboards
* View reports
* View payment records
* Monitor online payment status
* View system activity

## 3.2 Member

Member is a registered library visitor.

Member can:

* Access their personal dashboard
* View their profile
* View their borrowing history
* View active borrowings
* View due dates
* View fines
* Pay outstanding fines online
* View payment history
* View attendance history
* Receive library notifications

Members **cannot self-register**.

---

# 4. Authentication

LibraLite uses **Laravel Breeze** for authentication.

## Authentication Requirements

* Login using email and password.
* Logout.
* Forgot password.
* Reset password.
* Change password.
* Authenticated routes.
* Role and permission based authorization.

## Registration Policy

Public registration is **disabled**.

There is no:

* Public registration page
* Self-registration
* Public member registration form

Members are created by an authorized administrator.

---

# 5. Roles & Permissions

The system uses **Spatie Laravel Permission** for role and permission management.

## Roles

### Admin

Administrative access to library management functionality.

### Member

Limited access to personal library information.

Permissions should be granular enough to allow functionality to be controlled independently from the role itself.

Examples:

```text
view dashboard
manage members
create members
edit members
delete members
view books
manage books
manage categories
manage borrowing
process returns
view reports
manage fines
view attendance
view payments
manage payments
```

The dashboard and application navigation should use permissions to determine which information and actions are visible to the authenticated user.

---

# 6. Member Management

Admin can manage library members.

## Member Creation

A member is created by an administrator.

The member record should contain information such as:

* Member Code
* Name
* Email
* Phone
* Address
* Date of birth
* Profile photo, if required
* Status
* Account information
* Registration date

The exact fields can be adjusted during implementation based on the final database design.

## Member Code

Every member receives a unique **Member Code**.

Example:

```text
LIB-000001
LIB-000002
LIB-000003
```

The Member Code is used for operational identification, especially for attendance.

Member Code must be:

* Unique
* Easy to read
* Easy to enter
* Stable
* Searchable

## Member Status

Possible statuses:

* Active
* Inactive

Inactive members cannot perform new borrowing transactions.

---

# 7. Library Attendance

Attendance is one of the primary operational features of LibraLite.

## Check-In

When a visitor arrives:

```text
Visitor arrives
      ↓
Member Code is entered
      ↓
System identifies member
      ↓
Member information is displayed
      ↓
Attendance is recorded
```

The attendance process should be fast and require minimal interaction.

## Attendance Record

Attendance records should contain:

* Member
* Check-in date
* Check-in time
* Status

There is intentionally **no check-out feature**.

LibraLite only records the member's arrival/check-in.

## Attendance History

Admin can:

* View attendance history
* Search by member
* Filter by date
* Filter by date range
* View daily attendance
* View historical attendance

Members can view their own attendance history.

---

# 8. Book Management

Admin can manage books.

Book information should include:

* Title
* ISBN
* Author
* Publisher
* Publication year
* Category
* Description
* Cover image
* Stock
* Available stock
* Status

## Book Inventory

Books support stock management.

Example:

```text
Book Stock       : 5
Borrowed         : 3
Available        : 2
```

A book cannot be borrowed when its available stock is zero.

---

# 9. Category Management

Admin can manage book categories.

Category information:

* Name
* Slug
* Description
* Status

A category can contain multiple books.

A category cannot be deleted when doing so would violate existing book relationships unless the system provides an appropriate reassignment or safe deletion mechanism.

---

# 10. Book Availability

The system must distinguish between:

* Total stock
* Currently borrowed quantity
* Available stock

Example:

```text
Total Stock       : 10
Currently Borrowed: 4
Available Stock   : 6
```

Available stock must be calculated consistently with active borrowing transactions.

A book with:

```text
Available Stock = 0
```

cannot be borrowed.

---

# 11. Borrowing Management

Borrowing is one of the core features of LibraLite.

## Borrowing Flow

```text
Member is identified
      ↓
Member selects book
      ↓
System checks availability
      ↓
System checks member borrowing limit
      ↓
Borrowing transaction created
      ↓
Book stock updated
      ↓
Due date calculated
      ↓
Borrowing confirmation
```

## Borrowing Limit

Each member can have a maximum of:

**3 active books**

at the same time.

A member cannot create a new borrowing transaction when they already have 3 active borrowings.

## Borrowing Requirements

Before borrowing, the system must verify:

1. Member exists.
2. Member is active.
3. Member has no blocking restriction.
4. Book exists.
5. Book is active.
6. Book has available stock.
7. Member has fewer than 3 active borrowings.

---

# 12. Borrowing Period

The default borrowing period is:

**7 days**

Example:

```text
Borrowed:
12 August 2026

Due:
19 August 2026
```

The due date should be calculated automatically.

The borrowing period should be centralized in configuration or business logic so it can be changed later without modifying multiple parts of the application.

---

# 13. Returning Books

Admin processes book returns.

## Return Flow

```text
Active Borrowing
      ↓
Admin opens borrowing
      ↓
Return processed
      ↓
System checks due date
      ↓
Fine calculated if overdue
      ↓
Book stock increased
      ↓
Borrowing marked returned
```

The return record should contain:

* Borrowing
* Return date/time
* Due date
* Overdue days
* Fine amount
* Return status
* Processed by

---

# 14. Fine Management

LibraLite automatically calculates overdue fines.

## Default Fine

The default fine is:

**Rp2.000 per day per book**

Example:

```text
Due date:
19 August

Returned:
22 August

Late:
3 days

Fine:
3 × Rp2.000
= Rp6.000
```

The fine rate should be configurable.

## Fine Status

A fine can have statuses such as:

* Unpaid
* Paid
* Waived

Admin can manage the fine status.

The system should preserve the original fine amount even if the fine configuration changes later.

---

# 15. Online Fine Payment

LibraLite supports online payment for outstanding fines.

The payment gateway used is **Midtrans**.

## Payment Flow

```text
Member has unpaid fine
        ↓
Member opens fine details
        ↓
Member selects Pay Fine
        ↓
System creates payment transaction
        ↓
Member is presented with Midtrans payment options
        ↓
Member completes payment
        ↓
Midtrans sends payment result
        ↓
System verifies payment
        ↓
Fine marked as paid
        ↓
Payment history updated
        ↓
Member receives confirmation
```

## Payment Requirements

The system must:

* Create a unique payment transaction.
* Associate the payment with the correct fine.
* Send the transaction to Midtrans.
* Support Midtrans payment methods available to the configured account.
* Receive payment status updates.
* Verify payment notifications.
* Prevent unauthorized payment status manipulation.
* Update the fine only after successful payment verification.
* Store payment transaction information.
* Maintain payment history.

## Payment Status

Payments may have statuses such as:

* Pending
* Paid
* Failed
* Expired
* Cancelled

The exact mapping should follow the Midtrans payment response/status model.

## Payment History

Members can view their own payment history.

Admin can view payment records and payment status.

Payment records should contain information such as:

* Payment ID
* Fine
* Member
* Amount
* Payment provider
* Transaction reference
* Payment status
* Payment date
* Created date
* Updated date

## Payment Security

The application must never trust payment status directly from the client.

Payment status must be verified through the appropriate Midtrans server-side notification/API mechanism.

The system must prevent:

* Client-side manipulation of payment status
* Duplicate payment processing
* Incorrect fine updates
* Payment records being associated with the wrong member or fine

---

# 16. Notifications

LibraLite provides in-app notifications and email notifications.

## Notification Types

Potential notification events include:

* Successful borrowing
* Successful return
* Upcoming due date
* Overdue borrowing
* Fine generated
* Fine payment successful
* Fine payment failed
* Important library announcements

## Email Reminder

The system should send email reminders for borrowing deadlines.

Examples:

```text
Upcoming Due Date
```

and:

```text
Overdue Borrowing
```

Payment-related emails may include:

```text
Payment Successful
Payment Failed
```

Email notifications should use a clean, professional template.

The implementation should support Laravel's notification/mail system and queued jobs where appropriate.

---

# 17. Dashboard

The dashboard is role/permission aware.

## Admin Dashboard

The admin dashboard should provide an operational overview.

Recommended KPIs:

* Total Members
* Active Members
* Total Books
* Total Available Books
* Active Borrowings
* Overdue Borrowings
* Today's Attendance
* Unpaid Fines
* Paid Fines
* Pending Payments

## Charts

The dashboard should provide useful visualizations such as:

### Borrowing Statistics

Borrowing activity over time.

### Attendance Statistics

Library visits over time.

### Popular Books

Books with the highest borrowing frequency.

### Overdue Statistics

Current overdue borrowing information.

### Fine Statistics

Fine generation and payment information.

The dashboard should prioritize useful operational information rather than displaying excessive statistics.

---

# 18. Member Dashboard

Members should have a simplified dashboard.

Recommended information:

* Current borrowings
* Upcoming due dates
* Overdue books
* Current fines
* Recent borrowing history
* Recent attendance
* Payment history
* Notifications

Members should only see their own data.

---

# 19. Search, Filter & Pagination

Management pages should support appropriate data navigation.

The system should provide:

* Search
* Filtering
* Sorting
* Pagination

Where relevant.

## Members

Search by:

* Member Code
* Name
* Email

## Books

Search by:

* Title
* ISBN
* Author

Filter by:

* Category
* Availability
* Status

## Borrowings

Filter by:

* Member
* Book
* Status
* Date
* Due status

## Attendance

Filter by:

* Member
* Date
* Date range

## Payments

Filter by:

* Member
* Payment status
* Date
* Date range

---

# 20. Reports

Admin can access library reports.

## Member Reports

* Member list
* Active/inactive members
* Member activity

## Book Reports

* Book inventory
* Available books
* Borrowed books
* Books by category

## Borrowing Reports

* Borrowing history
* Active borrowing
* Returned borrowing
* Overdue borrowing

## Attendance Reports

* Daily attendance
* Monthly attendance
* Member attendance history

## Fine Reports

* Total fines
* Paid fines
* Unpaid fines
* Overdue fines

## Payment Reports

* Total payments
* Successful payments
* Failed payments
* Pending payments
* Payment history

Reports should support filtering by date range where relevant.

Export functionality should support:

* PDF
* Excel

---

# 21. User Experience

LibraLite should provide a modern, clean, and professional administrative experience.

## Layout

The primary application layout consists of:

```text
┌──────────────────────────────────────┐
│              Topbar                  │
├────────────┬─────────────────────────┤
│            │                         │
│  Sidebar   │        Content          │
│            │                         │
│            │                         │
└────────────┴─────────────────────────┘
```

## Design Direction

The design should be:

* Modern
* Clean
* Minimal
* Professional
* Responsive
* Easy to understand

## Color Direction

Primary visual direction:

* White
* Light neutral backgrounds
* Blue as the primary accent

Avoid excessive colors.

Status colors may still be used where necessary for semantic meaning, such as:

* Success
* Warning
* Danger
* Information

---

# 22. Responsive Design

The application must work across:

* Desktop
* Laptop
* Tablet
* Mobile

The desktop experience is the primary target because the application is intended for library administration.

Mobile layouts should remain usable for:

* Attendance
* Member lookup
* Basic monitoring
* Member dashboard
* Fine payment

---

# 23. Operational Priority

The system should prioritize speed for common library operations.

The most important operational flows are:

```text
Member Identification
        ↓
Attendance
        ↓
Borrowing
        ↓
Returning
        ↓
Fine
        ↓
Online Payment
```

The attendance/check-in workflow should require as few steps as reasonably possible.

The fine payment workflow should also be simple for members.

---

# 24. Data Integrity

The system must maintain consistent relationships between:

* Members
* Books
* Book stock
* Borrowings
* Returns
* Fines
* Payments
* Attendance
* Notifications

Important business rules must be enforced at the application level and, where appropriate, at the database level.

Examples:

* A borrowing cannot reference an inactive member.
* A borrowing cannot exceed available stock.
* A member cannot exceed the active borrowing limit.
* Returning a book must restore available stock.
* A returned borrowing cannot be returned again.
* Fine calculations must be consistent.
* Member Code must be unique.
* A fine can only be marked as paid after successful payment verification.
* A payment must belong to the correct fine.
* A payment notification must not result in duplicate payment processing.

---

# 25. Auditability

Important administrative actions should be traceable.

The system should record relevant activity such as:

* Member creation
* Member updates
* Book creation
* Book updates
* Borrowing creation
* Book returns
* Fine changes
* Payment-related administrative actions
* Important administrative actions

Activity logging can use **Spatie Laravel Activitylog**.

---

# 26. Technology Stack

## Backend

* Laravel
* PHP

## Frontend

* Blade
* Tailwind CSS
* Alpine.js

## Database

* MySQL

## Authentication

* Laravel Breeze

## Authorization

* Spatie Laravel Permission

## Media

* Spatie Laravel Media Library

## Notifications

* Laravel Mail / Notification system
* Email delivery service

## Payment

* Midtrans

## Reporting

* Laravel DomPDF
* Laravel Excel

## Activity Logging

* Spatie Laravel Activitylog

Additional libraries may be introduced when they provide clear value and remain consistent with the project architecture.

---

# 27. Non-Functional Requirements

## Maintainability

The codebase should:

* Follow Laravel conventions.
* Use meaningful naming.
* Avoid unnecessary complexity.
* Keep business logic organized.
* Avoid excessively large controllers.
* Prefer reusable components.

## Security

The application must:

* Protect authenticated routes.
* Enforce authorization using permissions.
* Validate user input.
* Protect against unauthorized data access.
* Prevent members from accessing other members' private data.
* Protect sensitive authentication information.
* Protect Midtrans payment credentials.
* Verify payment notifications server-side.

## Performance

The application should:

* Avoid unnecessary database queries.
* Use pagination for large datasets.
* Use eager loading where appropriate.
* Avoid loading unnecessary records.
* Use queues for suitable background tasks such as email notifications.

---

# 28. Out of Scope

The following are intentionally excluded from the initial product scope:

* Public member registration
* Social login
* Book reservation system
* Multi-library management
* Public-facing library website
* Mobile native application
* Barcode/QR-based book scanning
* Online payment providers other than Midtrans

The following are explicitly included:

* Online fine payment through Midtrans

---

# 29. Primary User Journey

The primary real-world workflow is:

```text
┌───────────────────┐
│ Visitor arrives   │
└─────────┬─────────┘
          ↓
┌───────────────────┐
│ Identify member   │
│ using Member Code │
└─────────┬─────────┘
          ↓
┌───────────────────┐
│ Record attendance │
└─────────┬─────────┘
          ↓
┌───────────────────┐
│ Library activities│
└─────────┬─────────┘
          ↓
      ┌───┴────┐
      ↓        ↓
  Borrow     Browse
      ↓
┌───────────────────┐
│ Borrowing created │
└─────────┬─────────┘
          ↓
┌───────────────────┐
│ Due date reminder │
└─────────┬─────────┘
          ↓
┌───────────────────┐
│ Return book       │
└─────────┬─────────┘
          ↓
     ┌────┴────┐
     ↓         ↓
 On time    Overdue
     ↓         ↓
     │       Fine
     │         ↓
     │     Pay Fine
     │         ↓
     │     Midtrans
     │         ↓
     │    Payment Verified
     │         ↓
     └────┬────┘
          ↓
┌───────────────────┐
│ Transaction closed│
└───────────────────┘
```

---

# 30. Success Criteria

LibraLite is considered successful when an administrator can efficiently perform the complete operational workflow:

1. Create a member.
2. Give the member a unique Member Code.
3. Identify the member using the Member Code.
4. Record library attendance.
5. Manage books and inventory.
6. Process a borrowing transaction.
7. Enforce the three-book borrowing limit.
8. Automatically calculate the due date.
9. Process book returns.
10. Automatically calculate overdue fines.
11. Restore book availability after return.
12. Send relevant email reminders.
13. Allow members to pay outstanding fines through Midtrans.
14. Verify Midtrans payment notifications securely.
15. Update fine status after successful payment.
16. View payment history.
17. View operational statistics.
18. Generate library reports.
19. Export reports to PDF and Excel.
20. Control functionality through roles and permissions.
21. Maintain an auditable history of important activities.

---

# 31. Product Principles

The following principles should guide development:

### 1. Operational First

The system should optimize real library workflows rather than simply provide CRUD interfaces.

### 2. Simple for Admins

Common operations such as member identification, attendance, borrowing, and returning should require minimal steps.

### 3. Simple for Members

Members should be able to easily monitor borrowings, fines, notifications, and online payments.

### 4. Data Integrity

Library inventory, transaction, fine, and payment data must remain consistent.

### 5. Secure Payments

Payment status must always be verified server-side through Midtrans mechanisms.

### 6. Clear Authorization

Users should only access functionality and data that their permissions allow.

### 7. Maintainable Code

The project is intended as an Agentic AI development exercise, so generated code must remain understandable, structured, and maintainable.

### 8. No Feature Creep

AI agents must not introduce features outside this PRD without explicit approval.

---

# 32. Requirements Priority

## Must Have

* Authentication
* Admin/member roles
* Permission management
* Member management
* Member Code
* Attendance check-in
* Book management
* Category management
* Stock management
* Borrowing
* Returning
* Borrowing limit
* Due dates
* Fine calculation
* Online fine payment
* Midtrans integration
* Payment status verification
* Payment history
* Dashboard
* Search/filter/pagination
* Email reminders
* Reports
* PDF export
* Excel export
* Activity logging
* Responsive UI

## Should Have

* Advanced dashboard charts
* Detailed notification center
* Advanced report filtering
* Configurable borrowing and fine settings
* Member activity overview
* Payment statistics

---

# 33. Development Rule for AI Agents

When working on LibraLite, an AI coding agent should:

1. Read `PRD.md` before implementing product functionality.
2. Read `TASK.md` before starting a development task.
3. Read `STYLE.md` before creating or modifying UI or code.
4. Implement only the requested task.
5. Avoid introducing unrequested features.
6. Preserve existing functionality.
7. Follow the established project architecture.
8. Validate business rules before considering a task complete.
9. Update `TASK.md` when a task is completed.
10. Ask for clarification when a requirement conflicts with the PRD rather than silently changing the product requirements.
11. Never modify payment status based solely on client-side input.
12. Treat Midtrans payment verification as a server-side responsibility.

# Technical Specification

## Backend

* Laravel 13
* PHP 8.4+

## Database

* MySQL 8

## Frontend

* Blade
* Tailwind CSS
* Alpine.js

## Authentication

* Laravel Breeze

## Authorization

* Spatie Laravel Permission

## Media

* Spatie Laravel Media Library

## Payment

* Midtrans

## Notification

* Laravel Mail
* PHP Flasher Notyf

## PDF

* Laravel DomPDF

## Excel

* Laravel Excel

## Activity Log

* Spatie Laravel Activitylog

---

# Dependencies

## Production Dependencies

```json
{
    "require": {
        "php": "^8.4",
        "barryvdh/laravel-dompdf": "^3.1",
        "cviebrock/eloquent-sluggable": "^13.0",
        "guzzlehttp/guzzle": "^7.15",
        "laravel/framework": "^13.8",
        "laravel/tinker": "^3.0",
        "maatwebsite/excel": "^3.1",
        "midtrans/midtrans-php": "^2.6",
        "php-flasher/flasher-notyf-laravel": "^2.6",
        "spatie/laravel-activitylog": "^5.0",
        "spatie/laravel-medialibrary": "^11.23"
    }
}
```

## Development Dependencies

```json
{
    "require-dev": {
        "barryvdh/laravel-debugbar": "^4.4",
        "fakerphp/faker": "^1.23",
        "laravel/breeze": "^2.4",
        "laravel/pail": "^1.2.5",
        "laravel/pint": "^1.27",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.6",
        "phpunit/phpunit": "^12.5.12"
    }
}
```

## Dependency Notes

The following dependencies from the previous project are intentionally not included because they are not required for the initial LibraLite scope:

* `artesaos/seotools`
* `spatie/laravel-sitemap`
* `laravel/pao`

The dependency list should remain minimal. New packages should only be added when there is a clear requirement that cannot be reasonably handled by Laravel or the existing dependencies.
