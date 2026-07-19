# Persiapan Sidang: Sistem Informasi Pusat Karir

> Dokumen ini berisi rangkuman penjelasan arsitektur, alur bisnis, dan library
> yang digunakan di project **pusatkarir-v1** untuk keperluan persiapan sidang
> Tugas Akhir.

---

## Daftar Isi

1. [Bagaimana Laravel Bekerja (Refresh)](#1-bagaimana-laravel-bekerja-refresh)
2. [Arsitektur Project](#2-arsitektur-project)
3. [Fitur Utama & Alur Bisnis](#3-fitur-utama--alur-bisnis)
   - [A. Verifikasi Employer](#a-alur-verifikasi-employer)
   - [B. Posting & Kelola Lowongan](#b-alur-posting--kelola-lowongan)
   - [C. Lamaran & Pipeline Seleksi](#c-alur-lamaran--pipeline-seleksi)
   - [D. Job Fair](#d-alur-job-fair)
4. [Konsep Laravel yang Sering Ditanya](#4-konsep-laravel-yang-sering-ditanya)
5. [Pertanyaan Jebakan & Cara Jawab](#5-pertanyaan-jebakan--cara-jawab)
6. [Library & Dependencies Non-Default](#6-library--dependencies-non-default)
   - [PHP (Backend)](#php-libraries-backend)
   - [JavaScript (Frontend)](#javascript-libraries-frontend)
7. [Checklist Sebelum Hari-H](#7-checklist-sebelum-hari-h)

---

## 1. Bagaimana Laravel Bekerja (Refresh)

Bayangkan Laravel seperti restoran:

```
Browser (Pelanggan)
    |
    v
routes/web.php (Pelayan -- menerima pesanan, arahkan ke dapur yang tepat)
    |
    v
Middleware (Satpam -- cek identitas & izin sebelum masuk)
    |
    v
Controller (Koki -- proses pesanan, koordinasi bahan)
    |
    v
Model (Gudang Bahan -- ambil/simpan data dari database)
    |
    v
View / Blade (Piring Saji -- data disajikan sebagai HTML)
    |
    v
Browser (Pelanggan menerima hasil)
```

### Alur Lengkap Satu Request

Contoh: Employer buka `/employer/job/create`

1. **User buka browser** -- ketik URL `/employer/job/create`
2. **`routes/web.php`** -- cocokkan URL dengan controller:
   ```php
   Route::resource('job', JobController::class)->except(['destroy']);
   // resource otomatis buat 7 route: index, create, store, show, edit, update
   ```
3. **Middleware** dijalankan secara berurutan sebelum masuk controller:
   - `role:employer` -- cek apakah user punya role employer (Spatie Permission)
   - `verified_employer` -- cek apakah data perusahaan sudah lengkap & diverifikasi admin
4. **Controller** (`JobController@create`) dipanggil, ambil data yang diperlukan
5. **Model** (`Job`, `Employer`, `Step`) -- Eloquent ORM bicara ke database, return object PHP
6. **View** (`resources/views/frontoffice/employer/job/create.blade.php`) -- render HTML
7. **Response** dikirim balik ke browser

---

## 2. Arsitektur Project

Project ini menggunakan pola **MVC (Model-View-Controller)** bawaan Laravel.

### Layer Utama

| Layer          | Lokasi                    | Peran                                                                 |
|----------------|---------------------------|-----------------------------------------------------------------------|
| **Model**      | `app/Models/`             | Representasi tabel database. Relasi antar tabel didefinisikan di sini |
| **View**       | `resources/views/`        | Template Blade (HTML + PHP). Menggunakan Bootstrap 5 (Hope UI)        |
| **Controller** | `app/Http/Controllers/`   | Menerima request, proses logika, kirim data ke view                   |

### Layer Tambahan

| Layer            | Lokasi                 | Peran                                                             |
|------------------|------------------------|-------------------------------------------------------------------|
| **Middleware**    | `app/Http/Middleware/` | Filter request sebelum masuk controller (auth, role, verifikasi)  |
| **Form Request** | `app/Http/Requests/`  | Validasi input dari form -- dipisah dari controller supaya clean  |
| **Livewire**     | `app/Livewire/`       | Komponen interaktif tanpa reload halaman                          |
| **Services**     | `app/Services/`       | Business logic yang dipakai beberapa controller                   |

### Pembagian Controller

| Folder                         | Untuk Siapa    | Contoh                        |
|--------------------------------|----------------|-------------------------------|
| `Controllers/BackOffice/`      | Admin          | EmployerVerificationController |
| `Controllers/FrontOffice/`     | Public/Employer | JobFairController             |
| `Controllers/Auth/`            | Semua user     | AuthenticatedSessionController |
| `Controllers/Security/`        | Admin          | RoleController                |
| `Controllers/` (root)          | Shared         | JobController, ApplicationController |

---

## 3. Fitur Utama & Alur Bisnis

### A. Alur Verifikasi Employer

```
Employer Register --> Login --> Isi Data Perusahaan (/employer/verifikasi)
    --> Status jadi "pending"
    --> Middleware CompleteProfile BLOKIR akses sampai admin approve
    --> Admin buka /backoffic3/employer-verification --> Approve/Reject
    --> Kalau approved --> Employer bisa akses semua fitur
    --> Kalau rejected --> Ada catatan alasan, employer bisa submit ulang
```

**Kenapa penting?**
Tanpa ini, siapa saja bisa daftar sebagai employer dan langsung posting lowongan
palsu. Ini adalah business rule yang melindungi integritas data.

**File-file kunci:**

| File | Peran |
|------|-------|
| `app/Http/Middleware/CompleteProfile.php` | Gerbang utama, blokir employer belum verified |
| `app/Http/Controllers/BackOffice/EmployerVerificationController.php` | Admin approve/reject |
| `app/Models/Employer.php` | Field `verification_status` (pending/approved/rejected) |

---

### B. Alur Posting & Kelola Lowongan

```
Employer --> Buat Lowongan (nama, posisi, requirement, deadline)
    --> Wajib isi minimal 1 Tahap Seleksi (Step)
    --> Lowongan status "active" --> muncul di halaman publik
    --> Employer bisa Close/Reopen lowongan
    --> Soft Delete (admin only) -- data tidak hilang dari database
```

**Konsep kunci:**

- **Status** (`active`/`closed`) -- employer bisa tutup lowongan tanpa hapus
- **Soft Deletes** -- kolom `deleted_at` diisi timestamp, bukan benar-benar dihapus.
  Ini supaya history lamaran tetap ada
- **Step/Tahap wajib** -- validasi di `JobStoreRequest` memastikan setiap lowongan
  punya minimal 1 tahap seleksi

**Relasi Model:**

```
Employer --hasMany--> Job --hasMany--> Step (tahap seleksi)
                       |
                       +--hasMany--> Application --hasMany--> Progress
```

---

### C. Alur Lamaran & Pipeline Seleksi

> Ini fitur paling kompleks di project.

```
Jobseeker lihat lowongan --> Klik Apply
    --> Application dibuat (status: pending)
    --> Progress dibuat untuk setiap Step di lowongan tersebut
    --> Employer buka halaman Applicants --> pilih pelamar --> isi progress tiap tahap
    --> Tahap harus diisi BERURUTAN (Step 1 dulu, baru Step 2, dst)
    --> Kalau satu tahap GAGAL  --> status otomatis "rejected"
    --> Kalau SEMUA tahap LULUS --> status otomatis "accepted"
```

**State Machine:**

```
pending --(semua tahap lulus)--> accepted
   |
   +--(satu tahap gagal)------> rejected
```

**Method kunci di `app/Models/Application.php`:**

| Method | Fungsi |
|--------|--------|
| `isStepEditable($step)` | Hanya step yang sedang aktif yang bisa diedit |
| `isFinalized()` | Kalau sudah accepted/rejected, tidak bisa diubah lagi |
| `syncStatusFromProgress()` | Otomatis hitung status akhir setelah employer update satu tahap |
| `currentStep()` | Cari step pertama yang belum lulus |

**Contoh pertanyaan penguji:**

> "Bagaimana kalau employer coba loncat ke step 3 padahal step 1 belum selesai?"

Jawab: `isStepEditable()` mengecek apakah step itu adalah `currentStep()`. Kalau
bukan, form-nya di-hide dan request POST akan ditolak di controller
(`ApplicationController::updateProgress`).

---

### D. Alur Job Fair

```
Admin buat Job Fair (nama, tanggal, lokasi, kuota)
    --> Employer lihat daftar job fair --> pilih --> daftarkan lowongan
    --> Sistem cek: fair masih active? tanggal belum lewat? kuota belum penuh?
    --> Kalau lolos --> pendaftaran masuk (status: pending)
    --> Admin approve/reject di backoffice
    --> Jobseeker bisa lihat lowongan yang sudah approved di job fair
```

**Method kunci di `app/Models/JobFair.php`:**

| Method | Fungsi |
|--------|--------|
| `isRegistrationOpen()` | Cek active + tanggal belum lewat |
| `hasCapacity()` | Cek kuota (NULL = unlimited) |
| `registeredCount()` | Hitung pending + approved (rejected tidak dihitung) |

---

## 4. Konsep Laravel yang Sering Ditanya

### Eloquent ORM

Cara Laravel bicara ke database pakai object PHP, bukan SQL mentah.

```php
// Daripada: SELECT * FROM job WHERE employer_id = 5
$jobs = Job::where('employer_id', 5)->get();

// Relasi: ambil semua lamaran dari sebuah lowongan
$job->applications;  // otomatis query ke tabel application
```

### Migration

File PHP yang mendefinisikan struktur tabel database. Seperti "version control untuk
database". Jalankan `php artisan migrate` dan Laravel baca semua file di
`database/migrations/` lalu buat/ubah tabelnya.

### Middleware

Filter yang dijalankan SEBELUM request sampai ke controller. Di project ini:

- `auth` -- pastikan user sudah login
- `role:employer` -- pastikan user punya role employer (Spatie Permission)
- `verified_employer` -- pastikan data perusahaan sudah diverifikasi admin

Didaftarkan di `app/Http/Kernel.php` sebagai route middleware.

### Soft Deletes

Data tidak benar-benar dihapus dari database, melainkan kolom `deleted_at` diisi
timestamp. Query biasa (`Job::all()`) otomatis exclude data yang sudah di-soft-delete.
Dipakai di model `Job` supaya history lamaran tidak hilang.

### Route Resource

`Route::resource('job', JobController::class)` otomatis bikin 7 route sekaligus:

| Method    | URI               | Action  | Nama Route  |
|-----------|-------------------|---------|-------------|
| GET       | /job              | index   | job.index   |
| GET       | /job/create       | create  | job.create  |
| POST      | /job              | store   | job.store   |
| GET       | /job/{job}        | show    | job.show    |
| GET       | /job/{job}/edit   | edit    | job.edit    |
| PUT/PATCH | /job/{job}        | update  | job.update  |
| DELETE    | /job/{job}        | destroy | job.destroy |

Di project ini, employer resource pakai `->except(['destroy'])` karena hard delete
hanya boleh dilakukan admin.

### Form Request

Class khusus untuk validasi input (`app/Http/Requests/JobStoreRequest.php`). Daripada
validasi di dalam controller, Laravel bisa otomatis reject request yang tidak valid
sebelum masuk controller. Lebih rapi dan reusable.

### Livewire

Framework untuk bikin komponen interaktif di Blade tanpa menulis JavaScript. Setiap
interaksi user (klik, ketik, submit) dikirim ke server via AJAX, server update state,
lalu kirim balik HTML yang berubah saja.

```
User klik "Tambah Pendidikan"
    --> Livewire kirim AJAX request ke server
    --> PHP method di komponen dijalankan (misal: addRow())
    --> Server render ulang bagian HTML yang berubah
    --> Browser update DOM -- tanpa reload halaman
```

---

## 5. Pertanyaan Jebakan & Cara Jawab

### "Kenapa pakai Laravel, bukan framework lain?"

- Ekosistem lengkap (auth, ORM, migration, validation sudah built-in)
- Dokumentasi sangat baik, komunitas besar
- Blade template mudah dipelajari
- Cocok untuk aplikasi web monolith seperti sistem informasi

### "Kenapa tidak pakai API + frontend terpisah (React/Vue)?"

- Scope Tugas Akhir tidak memerlukan arsitektur microservice
- Server-side rendering dengan Blade lebih sederhana untuk aplikasi CRUD
- Livewire sudah cukup untuk interaktivitas yang dibutuhkan

### "Bagaimana keamanan sistem ini?"

- **CSRF Protection** -- semua form punya `@csrf` token, dicek oleh VerifyCsrfToken middleware
- **Role-based access** -- Spatie Permission memastikan employer tidak bisa akses halaman admin
- **Employer verification** -- mencegah akun palsu posting lowongan
- **Soft deletes** -- data tidak hilang secara permanen
- **Form validation** -- input divalidasi di server-side via FormRequest
- **reCAPTCHA** -- mencegah bot spam di form register/login

### "Apa kekurangan sistem ini?" (jawab jujur)

- Membership & Pembayaran belum diwiring (scaffold only)
- Data akademik (Prodi) belum dinormalisasi penuh -- free text, belum FK
- Profile completion belum di-enforce sebelum apply (placeholder data `'-'`)

---

## 6. Library & Dependencies Non-Default

### Daftar Lengkap (Ringkasan)

```
Laravel 10 Fresh Install
|-- laravel/framework ........... default
|-- laravel/sanctum ............. default
|-- laravel/tinker .............. default
|-- guzzlehttp/guzzle .......... default
|-- fakerphp/faker .............. default (dev)
|-- laravel/pint ................ default (dev)
|-- laravel/sail ................ default (dev)
|-- mockery/mockery ............. default (dev)
|-- nunomaduro/collision ........ default (dev)
|-- phpunit/phpunit ............. default (dev)
|-- spatie/laravel-ignition ..... default (dev)
|
|   == Yang di bawah ini DITAMBAHKAN ==
|
|-- AUTH & ACCESS
|   |-- laravel/breeze ................. auth scaffold (dev)
|   |-- laravel/socialite .............. social login (Google, dll)
|   +-- spatie/laravel-permission ...... role & permission (RBAC)
|
|-- PDF
|   |-- barryvdh/laravel-dompdf ........ generate PDF (pure PHP)
|   +-- barryvdh/laravel-snappy ........ generate PDF (wkhtmltopdf)
|
|-- EXCEL
|   |-- maatwebsite/excel .............. import/export Excel
|   +-- rap2hpoutre/fast-excel ......... quick export
|
|-- DATATABLES
|   +-- yajra/laravel-datatables ....... server-side tables
|
|-- UI/UX
|   |-- livewire/livewire .............. interactive components
|   |-- realrashid/sweet-alert ......... popup notifications
|   |-- anhskohbo/no-captcha ........... reCAPTCHA
|   +-- select2 ........................ searchable dropdowns
|
|-- MEDIA
|   +-- spatie/laravel-medialibrary .... file/image management
|
+-- DEV TOOLS
    |-- laravel/telescope .............. debug dashboard
    +-- laravel-shift/blueprint ........ code generator
```

---

### PHP Libraries (Backend) -- Penjelasan Detail

#### 1. Authentication & Authorization

**laravel/breeze** (dev-dependency)

Starter kit auth dari Laravel. Satu perintah `php artisan breeze:install` dan langsung
dapat halaman Login, Register, Forgot Password, Email Verification yang sudah jadi.
Menghasilkan semua file di `app/Http/Controllers/Auth/`, view di
`resources/views/auth/`, dan route di `routes/auth.php`.

Dev-dependency karena hanya dibutuhkan saat generate scaffold awal. Setelah file-file
auth sudah ada, package-nya tidak dipakai lagi saat runtime.

**laravel/socialite**

Library resmi Laravel untuk login via pihak ketiga (Google, Facebook, GitHub, dll).
Menangani seluruh alur OAuth2 -- redirect ke provider, terima callback, ambil data user.
Memungkinkan user login tanpa harus bikin password manual.

**spatie/laravel-permission**

Library untuk Role-Based Access Control (RBAC). Assign role (admin, employer, mahasiswa)
dan permission ke user, lalu cek di middleware atau di Blade.

Cara kerja di project:
- Middleware `role:admin` -- hanya admin boleh masuk backoffice
- Middleware `role:employer` -- hanya employer boleh posting lowongan
- Middleware `role:mahasiswa` -- hanya jobseeker boleh apply
- Di Blade: `@role('admin')` untuk show/hide menu

Spatie Permission menyimpan data di 5 tabel: `roles`, `permissions`,
`model_has_roles`, `model_has_permissions`, `role_has_permissions`.
Tabel `model_has_roles` adalah tabel pivot yang menghubungkan user dengan role-nya.

---

#### 2. PDF Generation

**barryvdh/laravel-dompdf**

Generate PDF dari HTML/Blade template. Tulis view biasa, library ini convert jadi file
PDF. Pure PHP, tidak butuh install software tambahan. Dipakai untuk generate CV
jobseeker dalam format PDF.

**barryvdh/laravel-snappy** + wkhtmltopdf binaries

Alternative PDF generator yang pakai wkhtmltopdf (program external yang render HTML
pakai WebKit engine, sama seperti browser). Hasilnya lebih bagus daripada dompdf untuk
layout kompleks.

Package pendukung:
- `h4cc/wkhtmltopdf-amd64` = binary untuk Linux
- `wemersonjanuario/wkhtmltopdf-windows` = binary untuk Windows

Kalau ditanya "kenapa pakai dua library PDF?": Dompdf lebih portable (pure PHP), Snappy
hasilnya lebih akurat untuk layout rumit. Tergantung fitur mana yang pakai yang mana.

---

#### 3. Excel / Spreadsheet

**maatwebsite/excel** + phpoffice/phpspreadsheet

Library untuk import dan export file Excel (.xlsx). `phpspreadsheet` adalah engine
low-level, `maatwebsite/excel` adalah wrapper Laravel yang bikin kamu bisa bikin class
Import/Export yang rapi.

```php
// Export
return Excel::download(new JobseekerExport, 'data.xlsx');

// Import
Excel::import(new JobseekerImport, $request->file('file'));
```

**rap2hpoutre/fast-excel**

Alternative Excel library yang lebih ringan dan cepat. Tidak perlu bikin class terpisah
-- cocok untuk export sederhana satu baris kode.

Kenapa ada dua? Maatwebsite untuk yang butuh custom formatting/import logic, Fast Excel
untuk export cepat tanpa ribet.

---

#### 4. DataTables (Server-Side)

**yajra/laravel-datatables** + buttons + oracle

Library untuk server-side DataTables. DataTables biasa (client-side) load semua data
sekaligus ke browser, lalu sorting/searching dilakukan di JavaScript. Kalau datanya
ribuan, browser akan lambat.

Yajra DataTables memindahkan sorting, searching, dan pagination ke server -- browser
hanya terima 10-25 row yang sedang ditampilkan.

```
Browser kirim request "page 2, search: 'PT Maju', sort by: nama"
    --> Controller panggil Yajra DataTables
    --> Query ke database dengan WHERE, ORDER BY, LIMIT
    --> Return JSON (hanya 10 row)
    --> DataTables JS render di browser
```

Kalau ditanya: "Server-side processing dipilih karena data bisa banyak (ribuan
user/lowongan). Kalau client-side, semua data harus di-load dulu ke browser, sedangkan
server-side hanya ambil data yang ditampilkan per halaman."

---

#### 5. UI & UX

**realrashid/sweet-alert**

Wrapper Laravel untuk SweetAlert2 -- popup notifikasi yang lebih bagus daripada
`alert()` bawaan browser. Bisa tampilkan pesan sukses, error, konfirmasi delete dengan
animasi. Setiap flash message di controller otomatis tampil sebagai popup cantik.

**laravelcollective/html**

Helper untuk generate form HTML. Menyediakan `Form::open()`, `Form::text()`, dll --
cara lama bikin form di Laravel.

**anhskohbo/no-captcha**

Integrasi Google reCAPTCHA untuk Laravel. Melindungi form dari bot spam. Dipakai di
form register/login untuk memastikan yang submit adalah manusia.

**select2 + apalfrey/select2-bootstrap-5-theme**

Select2 adalah jQuery plugin yang membuat dropdown `<select>` jadi searchable,
multi-select, dengan autocomplete. Dipakai di form yang punya banyak pilihan (pilih
Prodi, Industri Type, Posisi).

---

#### 6. Livewire

**livewire/livewire**

Framework untuk bikin komponen interaktif di Blade tanpa menulis JavaScript. Setiap
interaksi user dikirim ke server via AJAX, server update state, lalu kirim balik HTML
yang berubah saja.

Dipakai untuk form Riwayat Pendidikan -- user bisa tambah/hapus baris secara dinamis
tanpa reload halaman.

Kalau ditanya "kenapa tidak pakai Vue/React?": Livewire lebih cocok karena project ini
sudah server-rendered (Blade). Tidak perlu bikin API terpisah, state management di
frontend, atau build system yang kompleks. Untuk interaktivitas ringan, Livewire sudah
cukup.

---

#### 7. Media & File

**spatie/laravel-medialibrary**

Library untuk mengelola file upload yang terhubung ke model Eloquent. Mendukung resize
gambar, konversi format, multiple collections. Dipakai untuk upload foto profil, logo
perusahaan, dokumen lamaran, dll.

---

#### 8. Development Tools

**laravel/telescope**

Dashboard debugging untuk Laravel. Menampilkan semua request, query database, exception,
job queue, mail, notification secara real-time. Diakses via `/telescope`.

Kalau ditanya: "Telescope hanya diaktifkan di environment development, tidak di
production, untuk alasan keamanan dan performa."

**laravel-shift/blueprint** (dev)

Tool untuk generate code dari file YAML. Tulis definisi model, controller, migration
dalam satu file `draft.yaml`, lalu jalankan `php artisan blueprint:build` -- semua file
ter-generate otomatis. Kemungkinan besar dipakai di awal project untuk generate
scaffolding secara cepat.

**nwidart/laravel-modules**

Library untuk modular architecture. Terdaftar di `composer.json` tapi folder `Modules/`
tidak ada -- scaffold yang tidak jadi dipakai.

Kalau ditanya: "Awalnya dipertimbangkan arsitektur modular, tapi untuk scope Tugas
Akhir, struktur monolith standar Laravel sudah memadai."

---

#### 9. Lain-lain

**lavary/laravel-menu** -- Generate menu navigasi secara programmatik dari PHP.

**psr/simple-cache** -- Interface standar PHP untuk caching. Diperlukan sebagai
dependency oleh `maatwebsite/excel` (bukan dipakai langsung).

---

### JavaScript Libraries (Frontend)

| Library | Fungsi |
|---------|--------|
| **bootstrap** | CSS framework utama -- layout, grid, komponen UI |
| **jquery** | Library JS untuk DOM manipulation -- dibutuhkan oleh DataTables dan Select2 |
| **sweetalert2** | Popup notifikasi cantik (counterpart JS dari `realrashid/sweet-alert`) |
| **datatables.net-bs4/bs5** | Client-side DataTables plugin (tabel interaktif dengan search, sort, pagination) |
| **flatpickr** | Date/time picker -- input tanggal yang lebih user-friendly daripada native browser |
| **filepond** + plugins | Library upload file modern -- drag & drop, preview gambar, validasi ukuran/tipe, crop |
| **@pqina/pintura** | Image editor -- crop, resize, rotate gambar sebelum upload |
| **apexcharts** | Library grafik/chart -- dipakai di dashboard untuk visualisasi data |
| **nouislider** | Range slider input -- misal filter gaji minimum-maksimum |
| **fslightbox** | Lightbox untuk preview gambar/foto full-screen |
| **swiper** | Carousel/slider -- misal slider banner di landing page |
| **smooth-scrollbar** | Custom scrollbar styling |
| **counterup2** | Animasi angka naik (counting up) -- misal "500+ Lowongan" di landing page |
| **waypoints** | Trigger event saat user scroll ke posisi tertentu -- dikombinasikan dengan counterup |

---

### Kenapa Banyak Library?

Kalau penguji bertanya: Laravel ecosystem encourages **composition**. Daripada bikin
sendiri (reinvent the wheel), lebih baik pakai library yang sudah battle-tested,
well-documented, dan aktif di-maintain. Masing-masing punya satu tanggung jawab
spesifik (Single Responsibility), dan bisa di-replace tanpa mengubah keseluruhan sistem.

---

## 7. Checklist Sebelum Hari-H

- [ ] **Demo bisa jalan** -- `php artisan serve`, buka di browser, test semua alur utama
- [ ] **Siapkan data dummy** -- pastikan ada:
  - Employer (verified & unverified)
  - Lowongan (active & closed)
  - Lamaran di berbagai tahap (pending, accepted, rejected)
  - Job fair dengan kuota
- [ ] **Hafal ERD** -- bisa gambar relasi antar tabel utama di whiteboard:
  - User, Employer, Jobseeker, Job, Application, Step, Progress, JobFair
- [ ] **Pahami 4 alur bisnis utama** -- bisa walk through sambil tunjuk kode
- [ ] **Tahu letak file** -- kalau penguji tanya "di mana validasinya?", langsung jawab
  `app/Http/Requests/JobStoreRequest.php`
- [ ] **Bisa jelaskan setiap library** -- kenapa dipilih, apa fungsinya
- [ ] **Tahu kekurangan sistem** -- jujur, tapi frame sebagai "future work"
