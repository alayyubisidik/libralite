# LibraLite — Development Tasks

## Development Rules

* [ ] Complete tasks sequentially unless a task has no dependency on the current phase.
* [ ] Read `PRD.md` before implementing product functionality.
* [ ] Read the Technical Specification section in `PRD.md` before installing or configuring dependencies.
* [ ] Follow `STYLE.md` when it is available.
* [ ] Do not implement features outside the PRD without approval.
* [ ] Test each completed feature before moving to the next feature.
* [ ] Include positive, negative, validation, authorization, and edge-case tests where applicable.
* [ ] Keep each implementation focused and maintainable.
* [ ] Update this checklist when tasks are completed.

---

# Phase 1 — Project Setup

## 1.1 Laravel Project

* [ ] Create Laravel 13 project
* [ ] Verify PHP version is 8.4+
* [x] Configure application name as LibraLite
* [x] Configure application URL
* [x] Configure application timezone
* [x] Configure locale where appropriate
* [ ] Initialize Git repository

## 1.2 Environment Configuration

* [ ] Configure `.env`
* [ ] Create/update `.env.example`
* [ ] Configure MySQL connection
* [ ] Configure application environment
* [ ] Configure application key
* [ ] Verify database connection

## 1.3 Install Dependencies

* [x] Install Laravel Breeze
* [x] Install Spatie Laravel Permission
* [x] Install Spatie Laravel Media Library
* [x] Install Midtrans PHP SDK
* [x] Install Laravel DomPDF
* [x] Install Laravel Excel
* [x] Install Spatie Laravel Activitylog
* [x] Install PHP Flasher Notyf
* [x] Install remaining approved dependencies
* [x] Verify all dependencies are compatible with Laravel 13

## 1.4 Basic Application Verification

* [x] Run migrations
* [x] Verify database connection
* [ ] Verify Laravel application starts correctly
* [ ] Verify frontend assets compile
* [ ] Verify authentication scaffolding is accessible

---

# Phase 2 — Authentication & Authorization

## 2.1 Laravel Breeze

* [ ] Configure Laravel Breeze
* [ ] Verify login
* [ ] Verify logout
* [ ] Verify forgot password
* [ ] Verify reset password
* [ ] Verify change password
* [ ] Disable public registration
* [ ] Remove/hide public registration routes and UI

## 2.2 Roles & Permissions

* [ ] Configure Spatie Laravel Permission
* [ ] Create Admin role
* [ ] Create Member role
* [ ] Define application permissions
* [ ] Assign appropriate permissions to Admin
* [ ] Assign appropriate permissions to Member
* [ ] Configure authorization middleware/policies where required

## 2.3 Admin Setup

The application must provide a secure initial admin setup mechanism.

* [ ] Define admin setup token in `.env`
* [ ] Add admin setup token configuration
* [ ] Create secure admin setup mechanism
* [ ] Create initial admin user through setup process
* [ ] Assign Admin role automatically
* [ ] Prevent unauthorized users from creating an admin
* [ ] Prevent unnecessary repeated admin setup
* [ ] Validate setup token securely
* [ ] Ensure setup token is never exposed in the UI
* [ ] Ensure setup token is never committed to Git

## 2.4 Authentication & Authorization Testing

* [ ] Test successful login
* [ ] Test invalid credentials
* [ ] Test logout
* [ ] Test password reset
* [ ] Test unauthorized page access
* [ ] Test Admin permissions
* [ ] Test Member permissions
* [ ] Test disabled public registration
* [ ] Test admin setup with valid token
* [ ] Test admin setup with invalid token
* [ ] Test repeated/unauthorized admin setup

---

# Phase 3 — Database Foundation

## 3.1 Database Design

* [x] Finalize database entities based on PRD
* [x] Define entity relationships
* [x] Define required indexes
* [x] Define foreign keys
* [x] Define unique constraints
* [x] Define required status fields

## 3.2 Migrations

* [x] Create users migration adjustments if required
* [x] Create members migration (merged into `users` per db.sql v2)
* [x] Create categories migration
* [x] Create books migration
* [x] Create attendances migration
* [x] Create borrowings migration
* [x] Create fines migration
* [x] Create payments migration
* [x] Create required notification/activity tables
* [x] Verify all relationships
* [x] Run fresh migration successfully

## 3.3 Models & Relationships

* [ ] Create Member model
* [ ] Create Category model
* [ ] Create Book model
* [ ] Create Attendance model
* [ ] Create Borrowing model
* [ ] Create Fine model
* [ ] Create Payment model
* [ ] Define model relationships
* [ ] Define appropriate casts
* [ ] Define appropriate scopes
* [ ] Configure media relationships where required

## 3.4 Factories & Seeders

* [ ] Create Member factory
* [ ] Create Category factory
* [ ] Create Book factory
* [ ] Create Attendance factory
* [ ] Create Borrowing factory where appropriate
* [ ] Create required test data factories
* [ ] Create role/permission seeder
* [ ] Create development data seeder
* [ ] Verify seeders work from a fresh database

---

# Phase 4 — Member Management

## 4.1 Member Creation

* [ ] Create Member CRUD structure
* [ ] Create member form
* [ ] Implement member validation
* [ ] Generate unique Member Code
* [ ] Create associated user account when required
* [ ] Assign Member role
* [ ] Store member information
* [ ] Handle member status

## 4.2 Member List

* [ ] Create member list page
* [ ] Add search
* [ ] Add pagination
* [ ] Add status filter
* [ ] Display Member Code
* [ ] Display relevant member information

## 4.3 Member Detail

* [ ] Create member detail page
* [ ] Display profile information
* [ ] Display Member Code
* [ ] Display borrowing summary
* [ ] Display attendance summary
* [ ] Display fine summary
* [ ] Display payment summary

## 4.4 Member Update

* [ ] Create member edit page
* [ ] Validate updates
* [ ] Prevent invalid Member Code duplication
* [ ] Handle member status changes

## 4.5 Member Assistance

Admin must be able to help members who forget their Member Code or login credentials.

* [ ] Add member search by full name
* [ ] Add member search by Member Code
* [ ] Add member search by email
* [ ] Display matching member information
* [ ] Allow admin to access member information needed for assistance
* [ ] Provide secure password reset assistance where appropriate

## 4.6 Member Testing

* [ ] Test member creation
* [ ] Test Member Code uniqueness
* [ ] Test invalid member data
* [ ] Test member update
* [ ] Test inactive member
* [ ] Test member search
* [ ] Test member lookup by full name
* [ ] Test member lookup by Member Code
* [ ] Test authorization

---

# Phase 5 — Category Management

## 5.1 Category CRUD

* [ ] Create category migration/model if not completed
* [ ] Create category list
* [ ] Create category form
* [ ] Create category validation
* [ ] Create category edit
* [ ] Create category deletion
* [ ] Add slug generation
* [ ] Add pagination
* [ ] Add search

## 5.2 Category Testing

* [ ] Test category creation
* [ ] Test duplicate category
* [ ] Test validation
* [ ] Test update
* [ ] Test deletion
* [ ] Test category with associated books
* [ ] Test authorization

---

# Phase 6 — Book Management

## 6.1 Book CRUD

* [ ] Create Book CRUD structure
* [ ] Create book form
* [ ] Implement book validation
* [ ] Implement category relationship
* [ ] Implement ISBN handling
* [ ] Implement stock management
* [ ] Implement book status

## 6.2 Book Media

* [ ] Configure Spatie Media Library
* [ ] Add book cover upload
* [ ] Add cover replacement
* [ ] Add cover deletion
* [ ] Validate uploaded files
* [ ] Display book cover

## 6.3 Book List

* [ ] Create book list page
* [ ] Add search
* [ ] Add category filter
* [ ] Add availability filter
* [ ] Add status filter
* [ ] Add sorting
* [ ] Add pagination

## 6.4 Book Detail

* [ ] Create book detail page
* [ ] Display book information
* [ ] Display total stock
* [ ] Display borrowed quantity
* [ ] Display available stock
* [ ] Display borrowing information where appropriate

## 6.5 Book Testing

* [ ] Test book creation
* [ ] Test book validation
* [ ] Test ISBN uniqueness where required
* [ ] Test stock validation
* [ ] Test cover upload
* [ ] Test cover replacement
* [ ] Test search
* [ ] Test filtering
* [ ] Test pagination
* [ ] Test authorization

---

# Phase 7 — Public Member Attendance

Attendance must be accessible without login.

## 7.1 Attendance Page

* [ ] Create public attendance page
* [ ] Create Member Code input
* [ ] Validate Member Code
* [ ] Find member by Member Code
* [ ] Display member information after successful lookup
* [ ] Provide Check In action
* [ ] Record attendance
* [ ] Display success feedback
* [ ] Display clear error when Member Code is invalid

## 7.2 Attendance Rules

* [ ] Verify member exists
* [ ] Verify member is active
* [ ] Apply final duplicate-attendance rule
* [ ] Store check-in date
* [ ] Store check-in time
* [ ] Store attendance status

## 7.3 Admin Attendance

* [ ] Create attendance management page
* [ ] Display attendance history
* [ ] Add member search
* [ ] Add date filter
* [ ] Add date range filter
* [ ] Add pagination

## 7.4 Member Attendance

* [ ] Display member attendance history
* [ ] Restrict member to their own attendance records

## 7.5 Attendance Testing

* [ ] Test valid Member Code
* [ ] Test invalid Member Code
* [ ] Test inactive member
* [ ] Test duplicate attendance condition
* [ ] Test public access without authentication
* [ ] Test member attendance authorization
* [ ] Test admin attendance access

---

# Phase 8 — Member Dashboard

* [ ] Create authenticated Member dashboard
* [ ] Display current borrowings
* [ ] Display upcoming due dates
* [ ] Display overdue books
* [ ] Display current fines
* [ ] Display recent borrowing history
* [ ] Display recent attendance
* [ ] Display payment history
* [ ] Display notifications
* [ ] Ensure member can only access their own data

## Dashboard Testing

* [ ] Test member dashboard authentication
* [ ] Test member data isolation
* [ ] Test empty states
* [ ] Test dashboard with active borrowing
* [ ] Test dashboard with overdue borrowing
* [ ] Test dashboard with unpaid fine

---

# Phase 9 — Borrowing

Borrowing is performed by authenticated members.

## 9.1 Borrowing UI

* [ ] Create book browsing/list for members
* [ ] Allow member to view book details
* [ ] Display book availability
* [ ] Provide borrowing action for available books

## 9.2 Borrowing Validation

Before creating a borrowing:

* [ ] Verify member is authenticated
* [ ] Verify member is active
* [ ] Verify book exists
* [ ] Verify book is active
* [ ] Verify available stock
* [ ] Verify member has fewer than 3 active borrowings
* [ ] Verify all required borrowing conditions

## 9.3 Borrowing Transaction

* [ ] Create borrowing service/workflow
* [ ] Calculate due date
* [ ] Create borrowing record
* [ ] Update book inventory
* [ ] Ensure transaction integrity
* [ ] Display borrowing confirmation

## 9.4 Borrowing History

* [ ] Create member borrowing history
* [ ] Display active borrowings
* [ ] Display returned borrowings
* [ ] Display due date
* [ ] Display borrowing status
* [ ] Add appropriate filtering/pagination

## 9.5 Borrowing Testing

* [ ] Test successful borrowing
* [ ] Test unauthenticated borrowing
* [ ] Test inactive member
* [ ] Test unavailable book
* [ ] Test zero stock
* [ ] Test three-book limit
* [ ] Test borrowing due date
* [ ] Test concurrent/transaction safety
* [ ] Test inventory update
* [ ] Test authorization
* [ ] Test duplicate/invalid borrowing request

---

# Phase 10 — Returning & Fine

Returns are processed by Admin.

## 10.1 Admin Borrowing Management

* [ ] Create admin borrowing list
* [ ] Add search
* [ ] Add member filter
* [ ] Add book filter
* [ ] Add status filter
* [ ] Add overdue filter
* [ ] Add date filtering
* [ ] Add pagination

## 10.2 Return Processing

* [ ] Create return processing interface
* [ ] Display borrowing information
* [ ] Verify borrowing is still active
* [ ] Calculate overdue days
* [ ] Calculate fine
* [ ] Create fine when required
* [ ] Record return date/time
* [ ] Update borrowing status
* [ ] Restore available book stock
* [ ] Ensure transaction integrity
* [ ] Display return confirmation

## 10.3 Fine Management

* [ ] Create fine model/relationship
* [ ] Implement configurable fine rate
* [ ] Set default fine rate to Rp2.000/day/book
* [ ] Store calculated fine amount
* [ ] Implement fine status
* [ ] Support unpaid status
* [ ] Support paid status
* [ ] Support waived status
* [ ] Prevent incorrect fine modification

## 10.4 Fine Testing

* [ ] Test on-time return
* [ ] Test overdue return
* [ ] Test one-day overdue
* [ ] Test multiple-day overdue
* [ ] Test fine calculation
* [ ] Test zero-fine return
* [ ] Test duplicate return
* [ ] Test stock restoration
* [ ] Test transaction rollback
* [ ] Test fine status
* [ ] Test authorization

---

# Phase 11 — Email & Notifications

## 11.1 Mail Configuration

* [ ] Configure Laravel Mail
* [ ] Configure Mailtrap
* [ ] Verify email connection
* [ ] Create base email template
* [ ] Test sending email

## 11.2 Notifications

* [ ] Implement due-date reminder notification
* [ ] Implement overdue notification
* [ ] Implement fine-created notification
* [ ] Implement successful payment notification
* [ ] Implement failed payment notification
* [ ] Implement appropriate in-app notifications

## 11.3 Scheduled Reminders

* [ ] Configure Laravel Scheduler
* [ ] Create upcoming due-date reminder job
* [ ] Create overdue reminder job
* [ ] Prevent duplicate reminder notifications
* [ ] Test scheduled notification behavior

## 11.4 Notification Testing

* [ ] Test email delivery
* [ ] Test due-date reminder
* [ ] Test overdue reminder
* [ ] Test fine notification
* [ ] Test payment notification
* [ ] Test duplicate notification prevention
* [ ] Test invalid/missing email conditions

---

# Phase 12 — Midtrans Payment

Use **Midtrans Sandbox** during development.

## 12.1 Midtrans Configuration

* [ ] Configure Midtrans server key
* [ ] Configure Midtrans client key
* [ ] Configure sandbox environment
* [ ] Add Midtrans configuration
* [ ] Ensure credentials are stored in `.env`
* [ ] Add credentials to `.env.example` as placeholders

## 12.2 Payment Structure

* [ ] Create Payment model
* [ ] Create Payment migration
* [ ] Define Fine → Payment relationship
* [ ] Define Member → Payment relationship
* [ ] Define payment statuses
* [ ] Store Midtrans transaction reference

## 12.3 Payment Creation

* [ ] Create member fine payment page
* [ ] Display outstanding fine
* [ ] Create payment transaction
* [ ] Generate unique order/transaction ID
* [ ] Send transaction to Midtrans
* [ ] Display Midtrans payment interface
* [ ] Handle payment creation errors

## 12.4 Payment Notification

* [ ] Create Midtrans notification endpoint
* [ ] Receive Midtrans notification
* [ ] Verify notification
* [ ] Map Midtrans status to internal status
* [ ] Update payment status
* [ ] Update fine status after successful payment
* [ ] Prevent duplicate payment processing
* [ ] Handle failed payment
* [ ] Handle expired payment
* [ ] Handle cancelled payment

## 12.5 Payment History

* [ ] Create member payment history
* [ ] Display payment status
* [ ] Display payment amount
* [ ] Display transaction reference
* [ ] Display payment date
* [ ] Create admin payment history
* [ ] Add payment filters
* [ ] Add pagination

## 12.6 Payment Testing

* [ ] Test payment creation
* [ ] Test valid payment
* [ ] Test failed payment
* [ ] Test expired payment
* [ ] Test cancelled payment
* [ ] Test Midtrans notification
* [ ] Test invalid notification
* [ ] Test duplicate notification
* [ ] Test payment ownership
* [ ] Test fine status update
* [ ] Test unauthorized payment access
* [ ] Test sandbox environment

---

# Phase 13 — Admin Dashboard

## 13.1 Dashboard KPIs

* [ ] Display total members
* [ ] Display active members
* [ ] Display total books
* [ ] Display available books
* [ ] Display active borrowings
* [ ] Display overdue borrowings
* [ ] Display today's attendance
* [ ] Display unpaid fines
* [ ] Display paid fines
* [ ] Display pending payments

## 13.2 Dashboard Charts

* [ ] Create borrowing statistics
* [ ] Create attendance statistics
* [ ] Create popular books statistics
* [ ] Create overdue statistics
* [ ] Create fine/payment statistics

## 13.3 Dashboard Authorization

* [ ] Apply permission-based dashboard visibility
* [ ] Ensure Admin sees administrative data
* [ ] Ensure Member sees only member data
* [ ] Hide unauthorized dashboard actions

## 13.4 Dashboard Testing

* [ ] Test KPI accuracy
* [ ] Test chart accuracy
* [ ] Test empty data states
* [ ] Test date filtering where applicable
* [ ] Test permission-based visibility
* [ ] Test member data isolation

---

# Phase 14 — Reports

## 14.1 Member Reports

* [ ] Create member report
* [ ] Add filtering
* [ ] Add date/status filters where appropriate
* [ ] Add PDF export
* [ ] Add Excel export

## 14.2 Book Reports

* [ ] Create book inventory report
* [ ] Create available/busy book report
* [ ] Add category filtering
* [ ] Add PDF export
* [ ] Add Excel export

## 14.3 Borrowing Reports

* [ ] Create borrowing report
* [ ] Add status filter
* [ ] Add member filter
* [ ] Add book filter
* [ ] Add date range filter
* [ ] Add PDF export
* [ ] Add Excel export

## 14.4 Attendance Reports

* [ ] Create attendance report
* [ ] Add member filter
* [ ] Add date range filter
* [ ] Add PDF export
* [ ] Add Excel export

## 14.5 Fine Reports

* [ ] Create fine report
* [ ] Add paid/unpaid/waived filter
* [ ] Add date range filter
* [ ] Add PDF export
* [ ] Add Excel export

## 14.6 Payment Reports

* [ ] Create payment report
* [ ] Add payment status filter
* [ ] Add member filter
* [ ] Add date range filter
* [ ] Add PDF export
* [ ] Add Excel export

## 14.7 Report Testing

* [ ] Test report data accuracy
* [ ] Test filters
* [ ] Test date ranges
* [ ] Test PDF generation
* [ ] Test Excel generation
* [ ] Test empty report results
* [ ] Test large dataset handling
* [ ] Test report authorization

---

# Phase 15 — Activity Log

## 15.1 Activity Logging

* [ ] Configure Spatie Laravel Activitylog
* [ ] Configure relevant models
* [ ] Record important administrative actions
* [ ] Record member management activity
* [ ] Record book management activity
* [ ] Record borrowing activity
* [ ] Record return activity
* [ ] Record fine changes
* [ ] Record important payment-related actions

## 15.2 Activity Log UI

* [ ] Create activity log list
* [ ] Display actor
* [ ] Display action
* [ ] Display subject
* [ ] Display timestamp
* [ ] Add filtering
* [ ] Add pagination

## 15.3 Activity Log Testing

* [ ] Test activity creation
* [ ] Test actor association
* [ ] Test relevant model logging
* [ ] Test filtering
* [ ] Test authorization
* [ ] Ensure sensitive information is not logged

---

# Phase 16 — UI & UX

## 16.1 Application Layout

* [ ] Create responsive sidebar
* [ ] Create topbar
* [ ] Create content layout
* [ ] Create navigation based on permissions
* [ ] Create responsive mobile navigation

## 16.2 Common Components

* [ ] Buttons
* [ ] Inputs
* [ ] Selects
* [ ] Textareas
* [ ] Tables
* [ ] Cards
* [ ] Badges
* [ ] Modals
* [ ] Alerts
* [ ] Pagination
* [ ] Empty states
* [ ] Loading states
* [ ] Confirmation dialogs

## 16.3 Application States

* [ ] Loading state
* [ ] Empty state
* [ ] Validation error state
* [ ] Success state
* [ ] Error state
* [ ] Unauthorized state
* [ ] Not found state

## 16.4 Responsive Testing

* [ ] Test desktop
* [ ] Test laptop
* [ ] Test tablet
* [ ] Test mobile
* [ ] Test sidebar behavior
* [ ] Test tables on small screens
* [ ] Test forms on small screens

---

# Phase 17 — Security & Validation Review

* [ ] Review authentication protection
* [ ] Review authorization
* [ ] Review member data isolation
* [ ] Review input validation
* [ ] Review mass assignment protection
* [ ] Review file upload validation
* [ ] Review CSRF protection
* [ ] Review payment security
* [ ] Review Midtrans notification verification
* [ ] Review duplicate payment handling
* [ ] Review environment secrets
* [ ] Review sensitive logging
* [ ] Review public attendance security
* [ ] Review rate limiting where appropriate

---

# Phase 18 — Feature Testing

Every major feature must be tested before finalization.

## Authentication

* [ ] Login
* [ ] Logout
* [ ] Forgot password
* [ ] Reset password
* [ ] Authorization

## Members

* [ ] CRUD
* [ ] Member Code
* [ ] Search
* [ ] Status
* [ ] User relationship

## Attendance

* [ ] Public check-in
* [ ] Invalid Member Code
* [ ] Inactive member
* [ ] Duplicate condition
* [ ] Attendance history

## Books

* [ ] CRUD
* [ ] Stock
* [ ] Availability
* [ ] Category
* [ ] Media

## Borrowing

* [ ] Successful borrowing
* [ ] Stock restriction
* [ ] Three-book limit
* [ ] Inactive member
* [ ] Due date

## Returning

* [ ] Successful return
* [ ] Overdue
* [ ] Fine
* [ ] Stock restoration
* [ ] Duplicate return

## Payment

* [ ] Create payment
* [ ] Sandbox payment
* [ ] Notification
* [ ] Verification
* [ ] Duplicate notification
* [ ] Payment status
* [ ] Fine status

## Notifications

* [ ] Email
* [ ] Due reminder
* [ ] Overdue reminder
* [ ] Payment notification

## Reports

* [ ] PDF
* [ ] Excel
* [ ] Filters
* [ ] Authorization

---

# Phase 19 — Final Review

## Functional Review

* [ ] Verify all PRD Must Have features are implemented
* [ ] Verify all core business rules
* [ ] Verify Admin workflows
* [ ] Verify Member workflows
* [ ] Verify public attendance workflow
* [ ] Verify borrowing workflow
* [ ] Verify returning workflow
* [ ] Verify fine workflow
* [ ] Verify payment workflow

## Technical Review

* [ ] Run Laravel Pint
* [ ] Run automated tests
* [ ] Fix failing tests
* [ ] Review database queries
* [ ] Review N+1 query risks
* [ ] Review authorization
* [ ] Review payment security
* [ ] Review environment configuration
* [ ] Review unused dependencies
* [ ] Review unused code

## UI Review

* [ ] Review consistency
* [ ] Review responsive behavior
* [ ] Review empty states
* [ ] Review error states
* [ ] Review validation messages
* [ ] Review navigation
* [ ] Review accessibility basics

---

# Phase 20 — Finalization

* [ ] Verify `.env.example`
* [ ] Verify README
* [ ] Verify installation instructions
* [ ] Verify database setup instructions
* [ ] Verify Mailtrap configuration instructions
* [ ] Verify Midtrans Sandbox configuration instructions
* [ ] Verify admin setup instructions
* [ ] Verify test credentials for development
* [ ] Verify Git status
* [ ] Remove debug code
* [ ] Remove temporary files
* [ ] Run final test suite
* [ ] Run final application review
* [ ] Mark completed tasks
* [ ] Confirm LibraLite is ready for development/demo

---

# Development Completion Criteria

LibraLite is considered development-complete when:

* [ ] All PRD Must Have requirements are implemented.
* [ ] Authentication works.
* [ ] Public attendance works without login.
* [ ] Admin can create and manage members.
* [ ] Members can log in.
* [ ] Members can borrow books.
* [ ] Admin can process returns.
* [ ] Fines are calculated correctly.
* [ ] Members can pay fines through Midtrans Sandbox.
* [ ] Payment notifications are verified correctly.
* [ ] Email notifications work through Mailtrap.
* [ ] Dashboard data is accurate.
* [ ] Reports can be generated.
* [ ] PDF export works.
* [ ] Excel export works.
* [ ] Activity logging works.
* [ ] Authorization is enforced.
* [ ] Automated tests cover major business rules.
* [ ] Responsive UI is implemented.
* [ ] No critical security issues remain.
