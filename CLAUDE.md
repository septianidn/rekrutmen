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
- **Media:** Spatie Laravel MediaLibrary
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
