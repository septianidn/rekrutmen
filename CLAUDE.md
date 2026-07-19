# CLAUDE.md — pusatkarir-v1

## Project Overview

**Pusat Karir** is a career center web application (Sistem Informasi Pusat Karir) built as a Final Project (Tugas Akhir). It serves three main user roles:

- **Backoffice (Admin)** — manages all platform data
- **Employer** — posts jobs, manages applications, participates in job fairs
- **Jobseeker** — browses jobs, applies, manages profile

## Tech Stack

- **Framework:** Laravel 10 (PHP 8.1+)
- **Frontend:** Blade templates + Bootstrap 5 (Hope UI admin template)
- **CSS/JS bundler:** Laravel Mix (`webpack.mix.js`)
- **Real-time / reactive:** Livewire 3
- **Auth:** Laravel Breeze + Laravel Socialite (social login)
- **Permissions:** Spatie Laravel Permission
- **Media:** Spatie Laravel MediaLibrary (still used on `User` model; removed from `Employer` — logo/dokumen now stored as direct columns)
- **QR Code:** `simplesoftwareio/simple-qrcode` — used for job fair booth & attendance QR generation
- **PDF export:** barryvdh/laravel-dompdf + laravel-snappy (wkhtmltopdf)
- **Excel export:** Maatwebsite Excel + Rap2hpoutre Fast Excel
- **DataTables:** Yajra DataTables (with Buttons)
- **Alerts:** RealRashid SweetAlert
- **Telescope:** Enabled (dev debugging)

## Project Structure

```
app/
  Http/
    Controllers/
      Auth/           # Standard Laravel auth
      EmployerAuth/   # Employer-specific auth
      BackOffice/     # Admin panel controllers
      FrontOffice/    # Public-facing controllers
      Security/       # Security-related controllers
  Models/             # Eloquent models (Job, Employer, Jobseeker, etc.)
  Livewire/           # Livewire components
  Helpers/helper.php  # Global helper functions (autoloaded)
  Services/           # Business logic services
  Imports/            # Excel import classes (Maatwebsite)
  Jobs/               # Laravel queued jobs
  Mail/               # Mailable classes
resources/views/
  backoffice/         # Admin views
  frontoffice/        # Public/employer views
  layouts/            # Base layouts
  partials/           # Shared partials
  components/         # Blade components
  auth/               # Auth views
database/
  migrations/
  seeders/
  factories/
routes/
  web.php             # Main web routes
  api.php             # API routes
  auth.php            # Auth routes
```

## Key Models

| Model | Description |
|-------|-------------|
| `User` | Base user (jobseeker/admin) |
| `Employer` | Company/employer account |
| `Jobseeker` | Job seeker profile |
| `Job` | Job postings |
| `JobFair` | Job fair events |
| `JobFairJob` | Pivot — employer's job registration to a fair (booth info) |
| `JobFairAttendance` | Jobseeker registration + check-in per fair (kode_qr) |
| `JobFairBoothScan` | Queue entry — jobseeker ↔ employer booth interaction |
| `Application` | Job applications |
| `Membership` | Membership/subscription |
| `Pembayaran` | Payment records |
| `Notification` | In-app notifications |
| `Proses` / `Step` / `Progress` | Application process pipeline |
| `Pelatihan` | Training/courses |
| `Rekomendasi` | Recommendations |

## Common Commands

```bash
# Start development server
php artisan serve

# Build frontend assets
npm run dev
npm run prod   # for production

# Database
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Clear caches
php artisan optimize:clear

# Queue worker (if using jobs)
php artisan queue:work
```

## Development Notes

- The `Modules/` namespace is registered in `composer.json` but the directory does not currently exist — do not assume modular structure.
- Global helpers live in `app/Helpers/helper.php` and are autoloaded for all files.
- Views use the **Hope UI Bootstrap 5** design system — keep UI consistent with existing layout conventions.
- Livewire components are under `app/Livewire/` and `resources/views/` Blade counterparts.
- PDF generation uses both dompdf and snappy (wkhtmltopdf) — check which one a specific feature uses before modifying.
- Indonesian language is used throughout (`Bahasa`, `Prodi`, `Fakultas`, `Jenjang` are Indonesian academic terms).

## Known Flaws (Audit — 2026-04-15)

Open issues in business flow and implementation. Cited with file:line at time of audit; verify before acting.

### Critical

1. ~~**No employer verification gate**~~ — **Fixed 2026-04-15.** Employer now submits data at `/employer/verifikasi`, gets `verification_status='pending'`, and is blocked by `CompleteProfile` middleware until an admin approves via `/backoffic3/employer-verification`. Rejection captures a note and notifies the employer via `NotificationService`. See migration `2026_04_15_100000_add_verification_to_employer_table.php`, `app/Http/Controllers/BackOffice/EmployerVerificationController.php`.
2. ~~**Application pipeline skips steps**~~ — **Fixed 2026-04-15.** `Application::isStepEditable()` + `isFinalized()` enforce that only the current (first unpassed) step is editable and only while `status='pending'`. `ApplicationController::updateProgress` rejects out-of-order or post-finalization updates with an error flash. After each save, `syncStatusFromProgress()` auto-sets `accepted` (all steps lulus) or `rejected` (any step failed). The progress view hides the form on locked steps with a reason message.
3. ~~**Job deletion unprotected**~~ — **Partially fixed 2026-04-24.** Delete replaced with close/reopen toggle (`status` column). Soft delete exists on job table. In-flight applications still not blocked on close — orphan risk reduced but not eliminated.
4. ~~**Job fair registration ignores dates & capacity**~~ — **Fixed 2026-04-24.** `employerRegister()` now checks `isActive()`, `tanggal_mulai->isFuture()`, and `hasCapacity()`. Switched from raw `DB::table()->insert()` to `$jobFair->jobs()->attach()`. Job fair QR feature (bilateral scan + queue) also implemented — see `D:\rekrutmen_hidden\docs\jobfair_implementation_procedure.txt`.

### Important

5. **Membership & Pembayaran are scaffolds, pending approval** — routes commented out at `routes/web.php:300-302`. Controllers exist but no paywall on job posting. Not implementing yet — waiting for institutional approval. When implemented, the intended design is:
   - `account` = platform's bank accounts (global, no employer FK) — admin registers these
   - `pembayaran` should reference `employer_id` (not `user_id`) since employers are the paying entity
   - `pembayaran` needs `status` enum (pending/lunas/gagal) and `bukti_transfer` (proof of payment file)
   - `membership.harga` must be changed from `string` to `decimal(10,2)`
   - `membership.durasi` must be changed from `string` to integer (days or months, pick one unit)
   - `Account` model missing `protected $primaryKey = 'nomor_rekening'` (custom PK not declared)
   - FK column in `pembayaran` migration is `nomor_rekening` but model uses `account_id` — must be made consistent
   - Flow: admin registers bank accounts → employer picks membership tier → employer submits pembayaran with bukti transfer → admin verifies → membership activated on employer record
6. **Academic data not normalized** — `RiwayatPendidikan.jenjang` is free-text (migration `2024_01_08_150458`). `Prodi` model exists (`app/Models/Prodi.php:13-14`, PK `kode_prodi`) but is **not** FK'd from `RiwayatPendidikan`. Blocks "alumni per prodi" reporting — core value for a pusat karir.
7. **Profile completion not enforced before applying** — `app/Http/Controllers/Auth/EmployerAuth/AuthenticatedSessionController.php:68-101` creates placeholder Jobseeker rows (`'-'` for name, etc.). `applyJob()` re-checks education/bahasa at `ApplicationController` (~lines 270-281). Move the gate to first login.
8. **Notifications half-wired** — `NotificationService` fires on application events, but bell UI, unread count, and email channel are thin/missing.
9. ~~**Verified employer can edit profile freely**~~ — **Fixed 2026-05-06.** Once `verification_status='approved'`, edits to legal-identity fields (`nama_perusahaan`, `alamat_perusahaan`, `logo`, `dokumen_legalitas`) now route through `EmployerChangeRequest` (table `employer_change_request`, model `app/Models/EmployerChangeRequest.php`). `EmployerController::updateVerified()` splits input: ungated fields (`deskripsi_perusahaan`, `industriType_id`, `telp_perusahaan`, `website`) apply directly; gated fields create a `pending` change request with required `reason` text + uploaded files staged under `change-requests/...` (originals untouched). Admin reviews at `/backoffic3/employer-change-request` (`BackOffice\EmployerChangeRequestController` — index/show/approve/decline/serveProposedDocument/serveProposedLogo); approve copies payload onto `employer` and moves files into final paths, decline requires `admin_note` and deletes staged files. Both branches notify employer via `NotificationService`. Employer cannot submit a second request while one is pending. Employer cannot post new jobs (`JobController::create`/`store`) while a change request is pending. Edit view shows banner with locked gated fields when pending; otherwise shows a "perlu persetujuan admin" badge on each gated field plus a `reason` textarea (required only when gated values differ). Migration `2026_05_06_100000_create_employer_change_request_table.php`. Sidebar nav adds "Permintaan Perubahan" with pending count badge.

### Nice to have

- **N+1 on employer dashboard** — `app/Http/Controllers/EmployerController.php:26-47` runs 4 separate queries per job set. Use `withCount` / eager loading.
- **`JobStoreRequest::authorize()` returns `true`** — move `employer_id` ownership check into the FormRequest instead of trusting the controller.
- **Jobseeker index lacks eager loading** — `app/Http/Controllers/JobseekerController.php:72-79` fetches applied job IDs separately and does not eager-load `employer`.

### Suggested sidang-defense priorities

Focus on ~~(1) employer verification~~, ~~(2) enforced pipeline state machine~~, (6) normalized academic fields — they map directly to the project's stated purpose and each is a small, demonstrable change.
