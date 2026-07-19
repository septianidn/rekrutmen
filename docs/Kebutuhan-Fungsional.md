# Dokumen Kebutuhan Fungsional & Non-Fungsional

## Sistem Informasi Pusat Karir

> Dokumen ini mencakup Kebutuhan Fungsional, Kebutuhan Non-Fungsional,
> Deskripsi Aktor, dan Skenario Use Case untuk project pusatkarir-v1.

---

## Daftar Isi

1. [Deskripsi Sistem](#1-deskripsi-sistem)
2. [Identifikasi Aktor](#2-identifikasi-aktor)
3. [Kebutuhan Fungsional](#3-kebutuhan-fungsional)
4. [Kebutuhan Non-Fungsional](#4-kebutuhan-non-fungsional)
5. [Deskripsi Use Case](#5-deskripsi-use-case)

---

## 1. Deskripsi Sistem

Sistem Informasi Pusat Karir adalah aplikasi web yang menghubungkan mahasiswa/pencari
kerja (jobseeker) dengan perusahaan (employer) melalui platform yang dikelola oleh
pusat karir perguruan tinggi (admin). Sistem menyediakan fitur pengelolaan lowongan
kerja, proses lamaran dengan pipeline seleksi bertahap, job fair, serta manajemen
profil dan CV digital.

---

## 2. Identifikasi Aktor

| No | Aktor | Deskripsi |
|----|-------|-----------|
| 1 | **Admin** | Pengelola backoffice pusat karir. Memiliki akses penuh untuk mengelola data master, verifikasi employer, kelola lowongan, job fair, user, dan konten. |
| 2 | **Employer** | Perusahaan yang telah terdaftar dan terverifikasi. Dapat memposting lowongan, mengelola tahap seleksi, mereview pelamar, dan berpartisipasi di job fair. |
| 3 | **Jobseeker (Mahasiswa)** | Pencari kerja / mahasiswa. Dapat mengelola profil & CV, melamar pekerjaan, melihat progress seleksi, dan mengikuti job fair. |
| 4 | **Guest** | Pengunjung yang belum login. Dapat melihat landing page dan daftar lowongan publik. |

---

## 3. Kebutuhan Fungsional

### 3.1 Modul Autentikasi & Registrasi

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-AUTH-01 | Sistem menyediakan halaman registrasi dengan pilihan peran (Employer atau Mahasiswa). | Guest | Tinggi |
| F-AUTH-02 | Sistem menyediakan halaman login untuk semua peran pengguna. | Guest | Tinggi |
| F-AUTH-03 | Sistem mendukung login melalui akun sosial media (Google) menggunakan OAuth2. | Guest | Sedang |
| F-AUTH-04 | Sistem menyediakan fitur lupa password dan reset password melalui email. | Guest | Tinggi |
| F-AUTH-05 | Sistem menyediakan fitur logout yang menghapus session pengguna. | Semua | Tinggi |
| F-AUTH-06 | Sistem mengarahkan pengguna ke dashboard sesuai peran setelah login (admin ke backoffice, employer ke halaman verifikasi/dashboard, jobseeker ke dashboard). | Semua | Tinggi |
| F-AUTH-07 | Sistem mendukung proteksi form dengan CAPTCHA (Google reCAPTCHA) untuk mencegah bot. | Guest | Sedang |

### 3.2 Modul Verifikasi Employer

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-VER-01 | Employer yang baru terdaftar wajib mengisi data perusahaan (nama, deskripsi, tipe industri, alamat, telepon, website) sebelum dapat mengakses fitur lain. | Employer | Tinggi |
| F-VER-02 | Setelah mengisi data, status employer menjadi "pending" dan seluruh akses selain halaman verifikasi diblokir oleh sistem. | Employer | Tinggi |
| F-VER-03 | Admin dapat melihat daftar employer berdasarkan status verifikasi (pending, approved, rejected) beserta jumlah masing-masing. | Admin | Tinggi |
| F-VER-04 | Admin dapat melihat detail data perusahaan employer yang mengajukan verifikasi. | Admin | Tinggi |
| F-VER-05 | Admin dapat menyetujui (approve) pengajuan verifikasi employer, sehingga employer dapat mengakses seluruh fitur. | Admin | Tinggi |
| F-VER-06 | Admin dapat menolak (reject) pengajuan verifikasi employer disertai catatan alasan penolakan. | Admin | Tinggi |
| F-VER-07 | Employer yang ditolak dapat mengirim ulang data perusahaan untuk diverifikasi kembali. | Employer | Tinggi |
| F-VER-08 | Sistem mengirimkan notifikasi ke employer ketika status verifikasi berubah (disetujui/ditolak). | Sistem | Tinggi |

### 3.3 Modul Kelola Lowongan Kerja

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-JOB-01 | Employer dapat membuat lowongan kerja baru dengan mengisi: nama pekerjaan, alamat, posisi, requirement, deskripsi pekerjaan, ekspektasi gaji, tipe waktu kerja (worktime), dan deadline lamaran. | Employer | Tinggi |
| F-JOB-02 | Employer wajib mengisi minimal 1 tahap seleksi (step) saat membuat lowongan. Setiap step terdiri dari jenis proses seleksi dan deskripsi. | Employer | Tinggi |
| F-JOB-03 | Employer dapat melihat daftar semua lowongan miliknya beserta jumlah pelamar per lowongan. | Employer | Tinggi |
| F-JOB-04 | Employer dapat mengedit lowongan dan tahap seleksinya. Jika sudah ada pelamar yang masuk ke tahap seleksi (progress), tahap tidak dapat diubah. | Employer | Tinggi |
| F-JOB-05 | Employer dapat menutup lowongan (status menjadi "closed") sehingga tidak menerima lamaran baru, tanpa menghapus data. | Employer | Tinggi |
| F-JOB-06 | Employer dapat membuka kembali lowongan yang telah ditutup (status kembali "active"). | Employer | Sedang |
| F-JOB-07 | Admin dapat melihat seluruh lowongan dari semua employer dengan filter berdasarkan status (semua, active, closed, terhapus) dan pencarian berdasarkan nama lowongan, posisi, atau nama perusahaan. | Admin | Tinggi |
| F-JOB-08 | Admin dapat menghapus lowongan secara soft delete, dengan syarat tidak ada lamaran berstatus "pending". | Admin | Tinggi |
| F-JOB-09 | Admin dapat memulihkan (restore) lowongan yang telah dihapus. | Admin | Sedang |
| F-JOB-10 | Lowongan yang telah di-soft-delete tidak muncul di daftar publik namun riwayat lamaran tetap tersimpan. | Sistem | Tinggi |

### 3.4 Modul Lamaran & Pipeline Seleksi

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-APP-01 | Jobseeker dapat melamar pekerjaan yang berstatus "active". Sistem mencegah lamaran ke lowongan yang sudah ditutup. | Jobseeker | Tinggi |
| F-APP-02 | Sistem memvalidasi kelengkapan profil sebelum melamar: jobseeker wajib memiliki minimal Riwayat Pendidikan dan Bahasa. | Jobseeker | Tinggi |
| F-APP-03 | Sistem mencegah jobseeker melamar lowongan yang sama lebih dari satu kali. | Sistem | Tinggi |
| F-APP-04 | Setelah lamaran terkirim, sistem mengirimkan notifikasi ke employer bahwa ada pelamar baru. | Sistem | Tinggi |
| F-APP-05 | Employer dapat melihat daftar semua pelamar pada setiap lowongan miliknya. | Employer | Tinggi |
| F-APP-06 | Employer dapat melihat CV/profil lengkap pelamar yang telah melamar ke lowongan miliknya. | Employer | Tinggi |
| F-APP-07 | Employer dapat mengunduh CV pelamar dalam format PDF. | Employer | Sedang |
| F-APP-08 | Employer dapat mengisi progress setiap tahap seleksi untuk masing-masing pelamar (lulus/tidak lulus, disertai catatan). | Employer | Tinggi |
| F-APP-09 | Tahap seleksi harus diisi secara berurutan. Employer tidak dapat mengisi tahap ke-N sebelum tahap ke-(N-1) selesai. | Sistem | Tinggi |
| F-APP-10 | Setelah semua tahap seleksi diisi lulus, status lamaran otomatis berubah menjadi "accepted". | Sistem | Tinggi |
| F-APP-11 | Jika salah satu tahap seleksi diisi tidak lulus, status lamaran otomatis berubah menjadi "rejected". | Sistem | Tinggi |
| F-APP-12 | Lamaran yang sudah berstatus "accepted" atau "rejected" (final) tidak dapat diubah lagi. | Sistem | Tinggi |
| F-APP-13 | Sistem mengirimkan notifikasi ke jobseeker setiap kali ada perubahan progress tahap seleksi, termasuk notifikasi final (diterima/ditolak). | Sistem | Tinggi |
| F-APP-14 | Jobseeker dapat melihat daftar semua lamaran yang telah dikirim beserta statusnya. | Jobseeker | Tinggi |
| F-APP-15 | Jobseeker dapat melihat detail progress tahap seleksi untuk setiap lamarannya. | Jobseeker | Tinggi |

### 3.5 Modul Job Fair

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-JF-01 | Admin dapat membuat job fair baru dengan mengisi: nama, deskripsi, lokasi, tanggal mulai, tanggal selesai, status (draft/active/completed), dan kuota peserta (opsional, NULL = unlimited). | Admin | Tinggi |
| F-JF-02 | Admin dapat mengedit dan menghapus data job fair. | Admin | Tinggi |
| F-JF-03 | Admin dapat melihat daftar peserta (employer & lowongan) yang mendaftar di setiap job fair. | Admin | Tinggi |
| F-JF-04 | Admin dapat menyetujui atau menolak pendaftaran peserta job fair, disertai notifikasi ke employer. | Admin | Tinggi |
| F-JF-05 | Employer dapat melihat daftar job fair yang berstatus "active". | Employer | Tinggi |
| F-JF-06 | Employer dapat mendaftarkan lowongan miliknya ke job fair. Sistem memvalidasi: job fair masih active, tanggal mulai belum lewat, kuota belum penuh, dan lowongan belum terdaftar sebelumnya. | Employer | Tinggi |
| F-JF-07 | Employer dapat membatalkan pendaftaran lowongan dari job fair. | Employer | Sedang |
| F-JF-08 | Employer dapat melihat status pendaftaran lowongannya di setiap job fair (pending/approved/rejected). | Employer | Tinggi |
| F-JF-09 | Sistem mengirimkan notifikasi ke semua admin ketika ada employer yang mendaftar ke job fair. | Sistem | Sedang |
| F-JF-10 | Jobseeker dapat melihat daftar job fair yang sedang aktif. | Jobseeker | Tinggi |
| F-JF-11 | Jobseeker dapat melihat lowongan yang telah disetujui (approved) dan masih active di dalam sebuah job fair. | Jobseeker | Tinggi |

### 3.6 Modul Profil & CV Jobseeker

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-PROF-01 | Jobseeker dapat mengelola data profil pribadi: nama, jenis kelamin, tanggal lahir, tipe jobseeker, nomor telepon, dan alamat. | Jobseeker | Tinggi |
| F-PROF-02 | Jobseeker dapat mengelola riwayat pendidikan (tambah, ubah, hapus) meliputi instansi, jenjang, jurusan, tahun masuk, dan tahun lulus. | Jobseeker | Tinggi |
| F-PROF-03 | Jobseeker dapat mengelola data bahasa yang dikuasai. | Jobseeker | Tinggi |
| F-PROF-04 | Jobseeker dapat mengelola riwayat kerja. | Jobseeker | Sedang |
| F-PROF-05 | Jobseeker dapat mengelola data organisasi yang pernah diikuti. | Jobseeker | Sedang |
| F-PROF-06 | Jobseeker dapat mengelola data prestasi/penghargaan. | Jobseeker | Sedang |
| F-PROF-07 | Jobseeker dapat mengelola data pelatihan/sertifikasi. | Jobseeker | Sedang |
| F-PROF-08 | Jobseeker dapat mengelola data rekomendasi/referensi. | Jobseeker | Sedang |
| F-PROF-09 | Sistem menampilkan persentase kelengkapan profil di dashboard jobseeker. | Sistem | Sedang |
| F-PROF-10 | Jobseeker dapat mengunduh CV dalam format PDF yang dibuat otomatis dari data profil. | Jobseeker | Tinggi |

### 3.7 Modul Profil Employer

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-EMP-01 | Employer dapat melihat profil perusahaan miliknya. | Employer | Tinggi |
| F-EMP-02 | Employer dapat mengedit data perusahaan: nama, deskripsi, tipe industri, alamat, telepon, dan website. | Employer | Tinggi |
| F-EMP-03 | Sistem menampilkan persentase kelengkapan profil perusahaan di dashboard employer. | Sistem | Sedang |

### 3.8 Modul Dashboard

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-DASH-01 | Dashboard admin menampilkan ringkasan data sistem (statistik). | Admin | Tinggi |
| F-DASH-02 | Dashboard employer menampilkan: jumlah lowongan (total & aktif), statistik lamaran (total, pending, accepted, rejected), daftar lamaran terbaru, job fair aktif, dan kelengkapan profil. | Employer | Tinggi |
| F-DASH-03 | Dashboard jobseeker menampilkan: kelengkapan profil, statistik lamaran (total, pending, accepted, rejected), dan lowongan terbaru. | Jobseeker | Tinggi |

### 3.9 Modul Notifikasi

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-NOTIF-01 | Sistem mengirimkan notifikasi in-app ke pengguna terkait saat terjadi event penting (lamaran baru, perubahan status verifikasi, update progress seleksi, pendaftaran job fair). | Sistem | Tinggi |
| F-NOTIF-02 | Pengguna dapat melihat daftar notifikasi dan jumlah notifikasi yang belum dibaca. | Semua | Tinggi |
| F-NOTIF-03 | Pengguna dapat menandai satu notifikasi sebagai sudah dibaca, yang kemudian mengarahkan ke halaman terkait. | Semua | Tinggi |
| F-NOTIF-04 | Pengguna dapat menandai semua notifikasi sebagai sudah dibaca sekaligus. | Semua | Sedang |

### 3.10 Modul Landing Page & Halaman Publik

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-PUB-01 | Sistem menampilkan landing page dengan informasi umum pusat karir. | Guest | Tinggi |
| F-PUB-02 | Sistem menampilkan daftar lowongan kerja yang berstatus "active" secara publik (halaman vacancy), dengan pagination. | Guest | Tinggi |

### 3.11 Modul Backoffice: Kelola Data Master

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-MASTER-01 | Admin dapat mengelola (CRUD) data Jenjang Pendidikan. | Admin | Sedang |
| F-MASTER-02 | Admin dapat mengelola (CRUD) data Fakultas. | Admin | Sedang |
| F-MASTER-03 | Admin dapat mengelola (CRUD) data Program Studi (Prodi). | Admin | Sedang |

### 3.12 Modul Backoffice: Kelola User & Security

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-USER-01 | Admin dapat mengelola (CRUD) data user. | Admin | Tinggi |
| F-USER-02 | Admin dapat mengelola (CRUD) data admin. | Admin | Tinggi |
| F-USER-03 | Admin dapat mengelola (CRUD) data role. | Admin | Tinggi |
| F-USER-04 | Admin dapat mengelola (CRUD) data permission. | Admin | Tinggi |
| F-USER-05 | Admin dapat mengatur relasi role dan permission. | Admin | Tinggi |
| F-USER-06 | Admin dapat mengelola (CRUD) data konselor. | Admin | Sedang |

### 3.13 Modul Backoffice: Kelola Konten & Email

| ID | Kebutuhan Fungsional | Aktor | Prioritas |
|----|----------------------|-------|-----------|
| F-CMS-01 | Admin dapat mengelola (CRUD) grup konten. | Admin | Rendah |
| F-CMS-02 | Admin dapat mengelola (CRUD) kategori konten. | Admin | Rendah |
| F-CMS-03 | Admin dapat mengelola (CRUD) konten/artikel. | Admin | Rendah |
| F-CMS-04 | Admin dapat mengelola template email. | Admin | Rendah |
| F-CMS-05 | Admin dapat mengirim email melalui sistem. | Admin | Rendah |

---

## 4. Kebutuhan Non-Fungsional

| ID | Kebutuhan Non-Fungsional | Kategori | Deskripsi |
|----|--------------------------|----------|-----------|
| NF-01 | Keamanan Autentikasi | Security | Sistem menggunakan session-based authentication dengan password yang di-hash menggunakan Bcrypt. Session di-regenerate setelah login untuk mencegah session fixation. |
| NF-02 | Proteksi CSRF | Security | Setiap form POST/PUT/PATCH/DELETE dilindungi token CSRF yang divalidasi otomatis oleh middleware VerifyCsrfToken. |
| NF-03 | Otorisasi Berbasis Peran | Security | Akses ke fitur dibatasi berdasarkan role (admin, employer, mahasiswa) menggunakan middleware Spatie Laravel Permission. |
| NF-04 | Proteksi Bot | Security | Form registrasi dan login dilindungi Google reCAPTCHA untuk mencegah serangan brute-force dan spam. |
| NF-05 | Validasi Input | Security | Seluruh input pengguna divalidasi di sisi server menggunakan Form Request sebelum diproses oleh controller. |
| NF-06 | Soft Delete | Reliability | Data lowongan kerja yang dihapus tidak hilang secara permanen dari database (soft delete), sehingga riwayat lamaran tetap terjaga. |
| NF-07 | Responsivitas | Usability | Antarmuka web menggunakan Bootstrap 5 yang responsif, dapat diakses dari perangkat desktop maupun mobile. |
| NF-08 | Kompatibilitas Browser | Usability | Sistem dapat diakses melalui browser modern (Chrome, Firefox, Safari, Edge). |
| NF-09 | Feedback Interaktif | Usability | Sistem memberikan feedback visual berupa popup SweetAlert2 untuk setiap aksi penting (sukses, error, konfirmasi). |
| NF-10 | Interaktivitas Form | Usability | Form yang membutuhkan input dinamis (tambah/hapus baris) menggunakan Livewire sehingga tidak memerlukan reload halaman. |
| NF-11 | Server-Side Pagination | Performance | Tabel data yang berpotensi besar (daftar user, lowongan, lamaran) menggunakan server-side DataTables untuk menghindari loading semua data sekaligus. |
| NF-12 | Teknologi | Maintainability | Sistem dibangun menggunakan Laravel 10 (PHP 8.1+), Blade template, Bootstrap 5, Livewire 3, dan MySQL/MariaDB. |
| NF-13 | Arsitektur | Maintainability | Sistem menggunakan arsitektur MVC (Model-View-Controller) sesuai konvensi Laravel, dengan pemisahan layer middleware, form request, dan service. |
| NF-14 | Export Dokumen | Functionality | Sistem mampu menghasilkan file PDF (CV) dan file Excel (data export). |

---

## 5. Deskripsi Use Case

Berikut skenario use case untuk fitur-fitur utama sistem.

---

### UC-01: Registrasi Pengguna

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Guest |
| **Deskripsi** | Guest mendaftarkan akun baru sebagai Employer atau Mahasiswa. |
| **Pre-condition** | Guest belum memiliki akun. |
| **Post-condition** | Akun terdaftar di sistem, user otomatis login dan diarahkan ke halaman sesuai peran. |
| **Trigger** | Guest membuka halaman registrasi. |

**Skenario Utama:**
1. Guest memilih peran: Employer atau Mahasiswa.
2. Guest mengisi email dan password (+ konfirmasi password).
3. Jika memilih Mahasiswa, Guest juga memilih tipe jobseeker (Alumni/Mahasiswa Aktif).
4. Guest submit form.
5. Sistem memvalidasi data (email unik, password minimal 8 karakter).
6. Sistem membuat akun User dan assign role sesuai pilihan.
7. Jika Mahasiswa: sistem otomatis membuat record Jobseeker.
8. Sistem me-login-kan user dan redirect ke dashboard.

**Skenario Alternatif:**
- 5a. Validasi gagal (email sudah terdaftar, password terlalu pendek): sistem menampilkan pesan error, kembali ke form.

---

### UC-02: Verifikasi Employer

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Employer, Admin |
| **Deskripsi** | Employer mengisi data perusahaan untuk diverifikasi oleh Admin sebelum dapat mengakses fitur. |
| **Pre-condition** | Employer sudah login, belum terverifikasi. |
| **Post-condition** | Employer berstatus approved/rejected. |
| **Trigger** | Employer mengakses halaman manapun (middleware mengarahkan ke halaman verifikasi). |

**Skenario Utama:**
1. Sistem menampilkan form verifikasi (nama perusahaan, deskripsi, tipe industri, alamat, telepon, website).
2. Employer mengisi dan submit form.
3. Status employer berubah menjadi "pending".
4. Admin membuka halaman daftar verifikasi employer.
5. Admin melihat detail data perusahaan.
6. Admin menekan tombol "Approve".
7. Status berubah menjadi "approved". Notifikasi dikirim ke employer.
8. Employer kini dapat mengakses seluruh fitur.

**Skenario Alternatif:**
- 6a. Admin menekan tombol "Reject" dan mengisi catatan alasan.
- 6b. Status berubah menjadi "rejected". Notifikasi dikirim ke employer.
- 6c. Employer dapat mengirim ulang data yang sudah diperbaiki (kembali ke langkah 1).

---

### UC-03: Membuat Lowongan Kerja

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Employer |
| **Deskripsi** | Employer membuat lowongan kerja baru lengkap dengan tahap seleksi. |
| **Pre-condition** | Employer sudah login dan terverifikasi (approved). |
| **Post-condition** | Lowongan tersimpan di database dengan status "active" dan minimal 1 tahap seleksi. |
| **Trigger** | Employer menekan tombol "Buat Lowongan". |

**Skenario Utama:**
1. Sistem menampilkan form lowongan (nama pekerjaan, alamat, posisi, requirement, deskripsi, ekspektasi gaji, tipe waktu kerja, deadline).
2. Employer mengisi data lowongan.
3. Employer menambahkan minimal 1 tahap seleksi (memilih jenis proses dan mengisi deskripsi).
4. Employer submit form.
5. Sistem memvalidasi data (semua field wajib terisi, minimal 1 tahap seleksi).
6. Lowongan tersimpan dengan status "active".
7. Sistem redirect ke daftar lowongan dengan pesan sukses.

**Skenario Alternatif:**
- 5a. Validasi gagal (field kosong, tahap seleksi kosong): sistem menampilkan pesan error.

---

### UC-04: Melamar Pekerjaan

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Jobseeker |
| **Deskripsi** | Jobseeker melamar pekerjaan yang tersedia. |
| **Pre-condition** | Jobseeker sudah login, profil memiliki minimal Riwayat Pendidikan dan Bahasa. |
| **Post-condition** | Lamaran tersimpan dengan status "pending", notifikasi terkirim ke employer. |
| **Trigger** | Jobseeker menekan tombol "Lamar" pada halaman lowongan. |

**Skenario Utama:**
1. Jobseeker melihat daftar lowongan yang berstatus "active".
2. Jobseeker memilih lowongan dan menekan tombol "Lamar".
3. Sistem memeriksa: lowongan masih active, profil lengkap (Riwayat Pendidikan & Bahasa ada), belum pernah melamar lowongan ini.
4. Sistem membuat record Application (status: pending, tanggal_apply: hari ini).
5. Sistem mengirimkan notifikasi ke employer.
6. Sistem menampilkan pesan sukses.

**Skenario Alternatif:**
- 3a. Lowongan sudah ditutup: sistem menampilkan pesan error "Lowongan sudah ditutup".
- 3b. Profil belum lengkap: sistem menampilkan pesan error dan mengarahkan ke halaman edit profil.
- 3c. Sudah pernah melamar: sistem menampilkan pesan error "Sudah melamar".

---

### UC-05: Mengelola Progress Seleksi

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Employer |
| **Deskripsi** | Employer mengisi progress tahap seleksi untuk setiap pelamar secara berurutan. |
| **Pre-condition** | Ada lamaran masuk untuk lowongan employer, lamaran belum berstatus final. |
| **Post-condition** | Progress tersimpan, status lamaran ter-update otomatis jika semua tahap selesai. |
| **Trigger** | Employer membuka halaman progress pelamar. |

**Skenario Utama:**
1. Employer membuka daftar pelamar pada sebuah lowongan.
2. Employer memilih pelamar dan menekan "Lihat Progress".
3. Sistem menampilkan semua tahap seleksi. Hanya tahap yang sedang aktif (current step) yang bisa diedit.
4. Employer mengisi hasil tahap aktif: lulus atau tidak lulus, disertai catatan.
5. Employer submit form.
6. Sistem menyimpan progress.
7. Sistem menjalankan `syncStatusFromProgress()`:
   - Jika tahap gagal: status lamaran berubah ke "rejected".
   - Jika semua tahap lulus: status lamaran berubah ke "accepted".
   - Jika belum selesai: status tetap "pending", tahap berikutnya menjadi aktif.
8. Sistem mengirimkan notifikasi ke jobseeker tentang update progress.

**Skenario Alternatif:**
- 3a. Lamaran sudah final (accepted/rejected): sistem menampilkan progress sebagai read-only.
- 5a. Employer mencoba mengisi tahap yang bukan current step: sistem menolak dengan pesan error "Tahap harus diisi berurutan".

---

### UC-06: Mendaftarkan Lowongan ke Job Fair

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Employer |
| **Deskripsi** | Employer mendaftarkan lowongan miliknya ke job fair yang sedang aktif. |
| **Pre-condition** | Employer sudah login dan terverifikasi, job fair berstatus "active" dan belum dimulai. |
| **Post-condition** | Pendaftaran tersimpan dengan status "pending", notifikasi terkirim ke admin. |
| **Trigger** | Employer membuka halaman detail job fair dan menekan "Daftarkan Lowongan". |

**Skenario Utama:**
1. Employer melihat daftar job fair yang aktif.
2. Employer membuka detail job fair.
3. Employer memilih lowongan dari daftar lowongan miliknya.
4. Employer menekan tombol "Daftar".
5. Sistem memeriksa: job fair masih active, tanggal mulai belum lewat, kuota belum penuh, lowongan belum terdaftar.
6. Sistem menyimpan pendaftaran (status: pending).
7. Sistem mengirimkan notifikasi ke semua admin.
8. Sistem menampilkan pesan "Menunggu persetujuan admin".

**Skenario Alternatif:**
- 5a. Tanggal mulai sudah lewat: pesan error "Pendaftaran sudah ditutup".
- 5b. Kuota penuh: pesan error "Kuota job fair sudah penuh".
- 5c. Lowongan sudah terdaftar: pesan error "Lowongan sudah terdaftar".

---

### UC-07: Mengelola Profil & Download CV

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Jobseeker |
| **Deskripsi** | Jobseeker mengelola data profil dan mengunduh CV otomatis dalam format PDF. |
| **Pre-condition** | Jobseeker sudah login. |
| **Post-condition** | Data profil tersimpan / file PDF terunduh. |
| **Trigger** | Jobseeker membuka halaman profil. |

**Skenario Utama (Edit Profil):**
1. Jobseeker membuka halaman "Edit Profil".
2. Sistem menampilkan form dengan data: informasi pribadi, riwayat pendidikan, bahasa, riwayat kerja, organisasi, prestasi, pelatihan, rekomendasi.
3. Jobseeker mengubah/menambah/menghapus data.
4. Jobseeker menekan "Simpan".
5. Sistem menyimpan seluruh perubahan.
6. Redirect ke halaman profil dengan pesan sukses.

**Skenario Utama (Download CV):**
1. Jobseeker menekan tombol "Download CV PDF".
2. Sistem men-generate file PDF dari data profil menggunakan DomPDF.
3. Browser mengunduh file PDF.

---

### UC-08: Mengelola Job Fair (Admin)

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin membuat, mengedit, menghapus job fair dan mengelola pendaftaran peserta. |
| **Pre-condition** | Admin sudah login. |
| **Post-condition** | Data job fair tersimpan, status pendaftaran peserta ter-update. |
| **Trigger** | Admin membuka halaman kelola job fair. |

**Skenario Utama (Buat Job Fair):**
1. Admin menekan "Buat Job Fair Baru".
2. Admin mengisi: nama, deskripsi, lokasi, tanggal mulai, tanggal selesai, status (draft/active/completed), kuota (opsional).
3. Admin submit form.
4. Sistem memvalidasi (tanggal selesai >= tanggal mulai, kuota >= 1 jika diisi).
5. Job fair tersimpan.

**Skenario Utama (Kelola Peserta):**
1. Admin membuka detail job fair.
2. Sistem menampilkan daftar lowongan yang terdaftar beserta nama employer dan status.
3. Admin menekan "Approve" atau "Reject" pada pendaftaran.
4. Sistem meng-update status pendaftaran.
5. Sistem mengirimkan notifikasi ke employer terkait.

---

### UC-09: Mengelola Lowongan (Admin)

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin melihat, mencari, menghapus, dan memulihkan lowongan dari seluruh employer. |
| **Pre-condition** | Admin sudah login. |
| **Post-condition** | Data lowongan ter-update sesuai aksi. |
| **Trigger** | Admin membuka halaman "Kelola Lowongan" di backoffice. |

**Skenario Utama:**
1. Sistem menampilkan daftar lowongan dari semua employer (default: semua termasuk yang terhapus).
2. Admin dapat memfilter berdasarkan tab (Semua / Active / Closed / Terhapus).
3. Admin dapat mencari berdasarkan nama lowongan, posisi, atau nama perusahaan.
4. Admin menekan "Hapus" pada lowongan.
5. Sistem memeriksa: jika masih ada lamaran pending, tolak dengan pesan error.
6. Jika tidak ada pending: lowongan di-soft-delete.
7. Admin dapat menekan "Pulihkan" pada tab Terhapus untuk me-restore lowongan.

---

### UC-10: Melihat Lowongan di Job Fair (Jobseeker)

| Komponen | Deskripsi |
|----------|-----------|
| **Aktor** | Jobseeker |
| **Deskripsi** | Jobseeker melihat lowongan yang tersedia di job fair. |
| **Pre-condition** | Jobseeker sudah login, job fair berstatus "active". |
| **Post-condition** | - |
| **Trigger** | Jobseeker membuka halaman job fair. |

**Skenario Utama:**
1. Jobseeker melihat daftar job fair aktif.
2. Jobseeker memilih job fair.
3. Sistem menampilkan lowongan yang sudah approved oleh admin DAN masih berstatus "active".
4. Jobseeker dapat melamar lowongan langsung dari halaman job fair (mengikuti alur UC-04).

---

## Lampiran: Matriks Aktor vs Kebutuhan Fungsional

| Modul | Admin | Employer | Jobseeker | Guest | Sistem |
|-------|:-----:|:--------:|:---------:|:-----:|:------:|
| Autentikasi & Registrasi | - | - | - | v | - |
| Verifikasi Employer | v | v | - | - | v |
| Kelola Lowongan | v | v | - | - | v |
| Lamaran & Pipeline | - | v | v | - | v |
| Job Fair | v | v | v | - | v |
| Profil & CV Jobseeker | - | - | v | - | v |
| Profil Employer | - | v | - | - | v |
| Dashboard | v | v | v | - | - |
| Notifikasi | v | v | v | - | v |
| Landing Page & Publik | - | - | - | v | - |
| Data Master | v | - | - | - | - |
| User & Security | v | - | - | - | - |
| Konten & Email | v | - | - | - | - |
