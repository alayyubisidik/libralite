# STYLE.md

# LibraLite — UI, UX & Coding Style Guide

Dokumen ini mendefinisikan standar visual, pengalaman pengguna, dan aturan coding untuk project **LibraLite**.

Dokumen ini juga menjadi pedoman bagi AI Agent ketika membuat, mengubah, atau mereview kode.

Tujuan utama:

* Menjaga tampilan aplikasi konsisten.
* Menghindari pembuatan UI yang berbeda-beda untuk setiap halaman.
* Memastikan aplikasi terasa modern tetapi tetap seperti sistem manajemen perpustakaan.
* Menjaga UX yang sederhana dan mudah dipahami.
* Menghindari kompleksitas arsitektur yang tidak diperlukan.
* Memastikan AI Agent mengikuti pola yang sudah ada sebelum membuat pola baru.

---

# 1. Design Direction

LibraLite menggunakan gaya:

> **Modern Dashboard + Modern Library Management System**

Visual harus terasa seperti aplikasi administrasi modern, tetapi tetap jelas bahwa LibraLite adalah sistem manajemen perpustakaan.

Karakter visual:

* Clean
* Modern
* Professional
* Functional
* Minimal visual noise
* Easy to scan
* Consistent spacing
* Tidak terlalu banyak dekorasi

Hindari desain yang:

* Terlalu colorful.
* Terlalu banyak gradient.
* Terlalu banyak shadow.
* Terlalu banyak rounded element.
* Terlihat seperti landing page marketing.
* Menggunakan animasi berlebihan.
* Membuat informasi administratif sulit dibaca.

---

# 2. Color System

Gunakan warna yang konsisten di seluruh aplikasi.

## Primary

Warna utama aplikasi adalah **blue**.

Digunakan untuk:

* Primary button
* Active navigation
* Links
* Focus state
* Important interactive elements
* Selected state

## Background

Gunakan:

* White
* Very light gray

Background harus memberikan kontras yang cukup terhadap card, table, form, dan sidebar.

## Text

Gunakan:

* Dark gray untuk primary text.
* Medium gray untuk secondary text.
* Muted gray untuk helper text dan informasi tambahan.

Hindari menggunakan pure black secara berlebihan.

## Semantic Colors

Gunakan warna semantic secara konsisten:

| Status  | Color |
| ------- | ----- |
| Success | Green |
| Warning | Amber |
| Danger  | Red   |
| Info    | Blue  |

Warna semantic hanya digunakan ketika memiliki makna.

Jangan menggunakan warna hanya untuk dekorasi.

---

# 3. Dark Mode

LibraLite mendukung **dark mode**.

Dark mode harus mengikuti sistem warna yang sama dengan light mode.

Pastikan:

* Text tetap memiliki contrast yang baik.
* Border tetap terlihat.
* Table tetap mudah dibaca.
* Form input tetap jelas.
* Badge tetap memiliki contrast yang cukup.
* Modal dan dropdown tidak kehilangan hierarchy.

Jangan membuat warna dark mode secara acak pada setiap component.

---

# 4. Border Radius

Gunakan **medium border radius** sebagai standar.

Target utama:

```text
rounded-lg
```

Gunakan radius yang konsisten.

Jangan mencampur:

```text
rounded-sm
rounded-md
rounded-lg
rounded-xl
rounded-2xl
```

secara sembarangan.

`rounded-xl` atau lebih besar hanya digunakan jika memang diperlukan oleh desain tertentu.

---

# 5. Shadow

Gunakan **subtle shadow**.

Shadow harus membantu memberikan hierarchy, bukan menjadi elemen visual utama.

Gunakan shadow terutama pada:

* Dropdown
* Modal
* Floating element
* Card tertentu

Hindari strong shadow pada semua card.

---

# 6. Typography

Font utama:

> **Inter**

Gunakan Inter secara konsisten di seluruh aplikasi.

Hierarchy:

```text
Page Title
    ↓
Page Description
    ↓
Section Title
    ↓
Body Text
    ↓
Helper / Muted Text
```

## Page Title

Digunakan untuk judul utama halaman.

Contoh:

```text
Books
Members
Borrowings
Categories
Dashboard
```

## Description

Digunakan jika halaman membutuhkan penjelasan singkat.

Contoh:

```text
Manage all books available in the library.
```

## Body

Gunakan ukuran dan weight yang nyaman dibaca.

Jangan menggunakan font-size besar secara berlebihan pada dashboard administratif.

---

# 7. Layout

Layout utama:

```text
┌──────────────────────────────────────────────┐
│ Sidebar │ Topbar                             │
│         ├────────────────────────────────────┤
│         │                                    │
│         │ Main Content                       │
│         │                                    │
│         │                                    │
└─────────┴────────────────────────────────────┘
```

## Sidebar

Sidebar berada di sebelah kiri.

Desktop:

* Sidebar tetap tersedia.
* Navigation mudah diakses.
* Active menu harus terlihat jelas.

Mobile:

* Sidebar berubah menjadi drawer.
* Sidebar tidak mengambil ruang utama layar.

## Topbar

Topbar digunakan untuk:

* User profile
* User information
* Dropdown actions

Profile menampilkan:

```text
Profile Photo
Name
Email
```

Ketika profile diklik, tampilkan dropdown.

Dropdown dapat berisi:

```text
Profile
Logout
```

Tidak perlu search feature pada topbar.

---

# 8. Navigation

Navigation harus menggunakan icon + label.

Contoh:

```text
Dashboard

Library
    Books
    Categories

Members

Borrowings

Reports
```

Gunakan active state yang jelas.

Navigation harus mudah dipindai.

Jangan menggunakan terlalu banyak nested navigation jika tidak diperlukan.

---

# 9. Dashboard

Dashboard menggunakan kombinasi:

* KPI Cards
* Charts
* Recent Activity
* Recent Transactions
* Quick Actions

Dashboard harus memberikan overview kondisi sistem tanpa mengharuskan administrator membuka banyak halaman.

## KPI Cards

KPI harus menampilkan:

* Nilai utama
* Label
* Context jika diperlukan
* Icon jika relevan

Contoh:

```text
Total Books
1,245
```

Jangan memenuhi KPI card dengan terlalu banyak informasi.

## Charts

Chart hanya digunakan ketika data memang lebih mudah dipahami secara visual.

Jangan menggunakan chart hanya sebagai dekorasi.

## Recent Activity

Digunakan untuk menampilkan aktivitas terbaru yang relevan.

## Recent Transactions

Digunakan untuk menampilkan transaksi terbaru, terutama borrowing/return.

## Quick Actions

Digunakan untuk action yang sering dilakukan.

Contoh:

```text
Add Book
Add Member
Create Borrowing
```

---

# 10. Buttons

Gunakan beberapa variant standar:

```text
Primary
Secondary
Outline
Ghost
Danger
```

## Primary

Untuk action utama.

Contoh:

```text
Save
Create Book
Create Member
```

## Secondary

Untuk action pendamping.

## Outline

Untuk action yang tidak menjadi fokus utama.

## Ghost

Untuk action ringan seperti:

```text
Cancel
Back
```

atau action pada area yang membutuhkan visual minimal.

## Danger

Untuk action destruktif:

```text
Delete
Remove
Cancel Borrowing
```

Jangan menggunakan danger button untuk action biasa.

---

# 11. Forms

Semua form CRUD harus konsisten.

Struktur standar:

```text
Label
Input
Helper Text
Validation Error
```

Contoh:

```text
Book Title

[ Enter book title ]

The title of the book.

Book title is required.
```

Gunakan label yang jelas.

Jangan mengandalkan placeholder sebagai pengganti label.

---

# 12. Form Validation

Validation dilakukan menggunakan **Laravel Form Request**.

Controller tidak boleh melakukan validasi manual yang seharusnya berada di Form Request.

Contoh pola:

```php
public function store(StoreBookRequest $request)
{
    // process validated data
}
```

Pesan validation menggunakan **Bahasa Indonesia**.

Contoh:

```text
Judul buku wajib diisi.
Email tidak valid.
Kategori wajib dipilih.
```

---

# 13. Tables

Table digunakan untuk data administratif seperti:

* Books
* Members
* Categories
* Borrowings
* Users
* Reports

Table mendukung:

* Search jika halaman memang membutuhkan search.
* Filter
* Sort
* Pagination
* Rows per page
* Action menu

Namun jangan menambahkan fitur search pada halaman yang memang tidak membutuhkan pencarian.

Search harus memiliki tujuan yang jelas.

---

# 14. Table Actions

Gunakan tombol action secara langsung:

```text
View | Edit | Delete
```

Tidak perlu menggunakan `...` menu sebagai default.

Gunakan action yang jelas dan mudah ditemukan.

Untuk action destruktif seperti Delete, tetap gunakan confirmation.

---

# 15. Delete Confirmation

Semua action delete harus menggunakan confirmation.

Contoh:

```text
Delete Book?

Are you sure you want to delete this book?

[Cancel] [Delete]
```

Confirmation harus menjelaskan konsekuensi action secara singkat.

Jangan membuat confirmation yang terlalu panjang.

---

# 16. Notifications

Gunakan **PHP Flasher Notyf** untuk feedback action.

Semua action yang berhasil atau gagal harus memberikan feedback jika memang relevan.

Contoh:

```text
Book created successfully.
Book updated successfully.
Book deleted successfully.
```

Untuk aplikasi LibraLite, pesan ditampilkan dalam **Bahasa Indonesia**.

Contoh:

```text
Buku berhasil ditambahkan.
Buku berhasil diperbarui.
Buku berhasil dihapus.
```

Jangan menampilkan notification untuk setiap interaksi kecil yang tidak membutuhkan feedback.

---

# 17. Loading State

Gunakan loading state untuk proses yang membutuhkan waktu.

Contoh:

```text
Save → Saving...
Export → Generating...
Process → Processing...
```

Loading state harus mencegah user melakukan action yang sama berulang kali.

Gunakan loading state terutama pada:

* Form submission
* Export
* Process borrowing
* Process return
* Action yang membutuhkan request server

---

# 18. Empty State

Setiap list/table yang tidak memiliki data harus memiliki empty state.

Contoh:

```text
No books found.

There are currently no books available.
```

Empty state harus sederhana.

Gunakan **simple icon**, bukan illustration besar.

Empty state dapat menyediakan action jika relevan.

Contoh:

```text
No books found.

[ Add Book ]
```

---

# 19. Icons

Gunakan:

> **Lucide**

Icon harus digunakan secara konsisten.

Jangan mencampurkan:

* Lucide
* Font Awesome
* Heroicons
* Icon library lain

tanpa alasan yang jelas.

Gunakan icon yang mudah dipahami.

Contoh:

```text
Book
Users
Plus
Edit
Trash
Eye
Settings
LogOut
```

Icon tidak boleh menggantikan label pada action penting jika dapat menyebabkan kebingungan.

---

# 20. Illustrations

Tidak perlu menggunakan illustration besar.

Gunakan:

> **Simple icon**

untuk:

* Empty state
* Tidak ada data
* Informasi sederhana
* Error state tertentu

Tujuannya menjaga aplikasi tetap clean dan profesional.

---

# 21. Responsive Design

LibraLite harus usable pada desktop maupun mobile.

Responsive bukan hanya berarti layout tidak rusak.

## Desktop

Gunakan layout multi-column jika memang diperlukan.

## Mobile

Gunakan:

* Sidebar → Drawer
* Cards → Stack
* Form → Single column
* Modal → Full/near-full width
* Table → Horizontal scroll atau responsive layout

Pastikan button dan interactive element tetap mudah disentuh.

---

# 22. Alpine.js

Alpine.js digunakan untuk **UI interaction ringan**.

Contoh penggunaan:

* Modal
* Dropdown
* Sidebar
* Tabs
* Confirmation
* Toggle
* Mobile navigation

Alpine.js **bukan** digunakan untuk membuat SPA.

Jangan mengubah halaman Blade sederhana menjadi aplikasi frontend kompleks jika tidak diperlukan.

---

# 23. Blade Components

Tidak perlu membuat sistem reusable Blade Components secara berlebihan.

Prioritas:

> Keep Blade simple.

Jangan membuat component hanya untuk mengabstraksi markup yang sangat kecil dan hanya digunakan sekali.

Namun jika terdapat pola UI yang benar-benar berulang dan jelas, component dapat dibuat.

Contoh yang layak dijadikan component:

```text
Button
Modal
Badge
Card
```

Tetapi jangan membuat abstraction hanya demi abstraction.

---

# 24. Backend Coding Style

Arsitektur backend LibraLite dibuat sederhana.

Tidak menggunakan Service layer sebagai standar.

Alur utama:

```text
Route
  ↓
Controller
  ↓
Form Request
  ↓
Eloquent Model
  ↓
Database
```

Controller bertanggung jawab menangani proses bisnis aplikasi.

Contoh:

```php
public function store(StoreBookRequest $request)
{
    $book = Book::create($request->validated());

    return redirect()
        ->route('books.index')
        ->with('success', 'Buku berhasil ditambahkan.');
}
```

---

# 25. Controller

Controller menjadi tempat utama untuk application logic.

Tidak perlu membuat Service class hanya untuk memindahkan beberapa baris kode dari controller.

Namun controller tetap harus:

* Mudah dibaca.
* Terstruktur.
* Tidak memiliki kode duplikat berlebihan.
* Menggunakan Form Request untuk validation.
* Menggunakan Eloquent untuk database operation.
* Menggunakan Policy/Permission untuk authorization jika diperlukan.

Jika suatu controller menjadi sangat kompleks, evaluasi terlebih dahulu apakah kompleksitas tersebut memang diperlukan sebelum memperkenalkan abstraction baru.

---

# 26. Form Request

Gunakan Form Request untuk validation.

Contoh:

```text
StoreBookRequest
UpdateBookRequest
StoreMemberRequest
UpdateMemberRequest
```

Validation rules tidak diletakkan langsung di controller jika dapat menggunakan Form Request.

Gunakan:

```php
$request->validated()
```

setelah validation berhasil.

---

# 27. Eloquent

Gunakan Eloquent sebagai ORM utama.

Database operation harus mengikuti pola Laravel yang idiomatis.

Prioritaskan:

```php
Book::query()
Book::create()
$book->update()
$book->delete()
```

Hindari raw SQL jika Eloquent sudah cukup untuk kebutuhan tersebut.

Gunakan query builder ketika memang lebih sesuai.

---

# 28. Authorization

Authorization menggunakan mekanisme Laravel yang sesuai, seperti:

* Policies
* Gates
* Permission/Role jika digunakan

Jangan mengandalkan hanya hidden button untuk keamanan.

UI restriction bukan pengganti authorization di backend.

---

# 29. Language

Seluruh UI aplikasi menggunakan:

> **Bahasa Indonesia**

Termasuk:

* Page title
* Button
* Form label
* Validation message
* Notification
* Empty state
* Confirmation
* Error message
* Help text

Technical naming dalam source code tetap menggunakan Bahasa Inggris.

Contoh:

```text
UI:
Tambah Buku

Code:
CreateBookRequest
```

Gunakan istilah Bahasa Indonesia yang natural dan mudah dipahami pengguna.

---

# 30. AI Agent Rules

`STYLE.md` adalah aturan wajib bagi AI Agent.

Sebelum membuat UI baru, Agent harus:

1. Membaca `STYLE.md`.
2. Mengecek UI yang sudah ada.
3. Menggunakan pattern yang sudah tersedia.
4. Menghindari membuat style baru tanpa alasan.
5. Mengikuti color system.
6. Mengikuti typography.
7. Mengikuti spacing.
8. Mengikuti component pattern.
9. Mengikuti responsive behavior.
10. Mengikuti bahasa UI Bahasa Indonesia.

---

# 31. Reuse Before Create

AI Agent harus selalu mencari pola yang sudah ada sebelum membuat sesuatu yang baru.

Prioritas:

```text
Existing UI
    ↓
Existing Pattern
    ↓
Existing Component
    ↓
Create New Pattern
```

Jangan membuat:

```text
New Button Style
New Card Style
New Modal Style
New Table Style
```

jika pattern yang sudah ada masih dapat digunakan.

---

# 32. No Unnecessary Dependencies

AI Agent tidak boleh menambahkan library UI/frontend baru tanpa alasan yang jelas.

Jangan menambahkan library hanya karena:

* Lebih mudah.
* Terlihat keren.
* Ada di tutorial.
* AI terbiasa menggunakannya.

Jika library baru benar-benar diperlukan, jelaskan alasannya terlebih dahulu.

---

# 33. No Unnecessary Abstraction

Hindari overengineering.

Jangan membuat:

```text
Service
Repository
Manager
Factory
Helper
Component
Composable
```

hanya untuk membuat struktur terlihat lebih kompleks.

Gunakan abstraction hanya ketika terdapat kebutuhan nyata.

Prinsip:

> Simple is better than complex.

---

# 34. Consistency Rule

Jika dua halaman memiliki kebutuhan UI yang sama, gunakan pattern yang sama.

Contoh:

```text
Books
Members
Categories
```

harus memiliki pola:

```text
Page Header
Action Button
Filter/Search
Table
Pagination
Empty State
```

jika kebutuhan fiturnya sama.

User tidak boleh merasa sedang menggunakan aplikasi yang berbeda ketika berpindah halaman.

---

# 35. UX Priority

Urutan prioritas ketika membuat UI:

```text
1. Usability
2. Clarity
3. Consistency
4. Accessibility
5. Visual polish
```

Jangan mengorbankan usability hanya untuk membuat UI terlihat lebih menarik.

---

# 36. Final Principle

LibraLite harus terasa:

> **Modern, clean, professional, simple, dan mudah digunakan.**

Bukan:

> Complex, flashy, over-designed, atau over-engineered.

Setiap perubahan UI dan coding harus mempertimbangkan:

```text
Is it necessary?
Is it consistent?
Is it simple?
Is it maintainable?
Does it follow STYLE.md?
```

Jika jawabannya tidak, jangan tambahkan kompleksitas tersebut.
