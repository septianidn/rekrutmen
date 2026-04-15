# Pusat Karir — ERD Relationship Rationale

Why each relationship exists, and why it's shaped the way it is.
This document explains the **business reasoning** behind the schema;
for the structural reference (columns, types, cardinalities) see [`ERD.md`](./ERD.md).

---

## 1. Core User Domain

The `users` table is the **authentication root**. All three user types
(admin, employer, jobseeker) share one login, one password hash, and one
account status — role-specific data lives in separate profile tables.

### `users` ◄── `employer` (user_id)

- **Cardinality:** 1 user → 1 employer (enforced logically; DB allows 1..N).
- **Why:** A company account must authenticate. Rather than duplicate
  login/status/email columns in `employer`, the FK to `users` reuses the
  shared auth scaffolding (Breeze, password resets, social login, notifications).
- **Why not merge into `users`?** Employer-only fields (company name,
  industry, website, address) don't belong on a row representing a jobseeker
  or admin — normalization keeps `users` slim.

### `users` ◄── `jobseeker` (user_id)

- **Cardinality:** 1 user → 1 jobseeker.
- **Why:** Same reasoning as `employer`. A seeker logs in via `users`;
  their CV-side data (name split, birthdate, seeker type) lives in `jobseeker`.
- **Why split?** The CV domain has ~7 satellite tables (education, work history,
  languages, …). Attaching those to `users` would force admins and employers
  to carry null FKs they don't use.

### `users` ◄── `pembayaran` (user_id)

- **Why:** Payment history is tied to the **person**, not the role. If a user
  changes role (graduate becoming alumni) or buys multiple memberships over
  time, the trail follows the identity.

### `users` ◄── `notification` (user_id)

- **Why:** The bell-icon inbox is one per login. Employers, jobseekers, and
  admins all receive notifications of different `type` ("application_status",
  "new_applicant", "job_fair"), but they all consume them via the same
  user-scoped feed.

### `users` ◄── `user_social_media` ──► `social_media`

- **Cardinality:** Many-to-many via `user_social_media` pivot.
- **Why a pivot?** A user has multiple social handles (LinkedIn + GitHub +
  Instagram), and each platform is used by many users. The pivot row also
  stores the handle/URL (`social_media_name`), which belongs on the edge,
  not on either entity.
- **Why `social_media` as a master table?** Admin can add/rename platforms
  without schema changes, and UI can render icons consistently per platform.

---

## 2. Employer Domain

### `industri_type` ◄── `employer` (industriType_id)

- **Cardinality:** 1 industry → N employers.
- **Why:** Companies must be categorized (technology, finance, manufacturing)
  for jobseeker filtering and admin analytics. Storing as a separate
  reference table (vs. a free-text column) ensures consistent spelling and
  lets admin rename an industry in one place.

### `employer` ◄── `job` (employer_id)

- **Cardinality:** 1 employer → N jobs.
- **Why:** A company runs multiple openings in parallel. The FK enforces
  ownership — only the posting employer can edit or close a job, and
  jobseeker-facing views can group "all jobs from Company X".

---

## 3. Job Content (Normalized Lists)

### `job` ◄── `_kualifikasi_job` (job_id)

- **Cardinality:** 1 job → N qualifications.
- **Why a child table and not a text column?** Qualifications are displayed
  as a bullet list and may later be searched/filtered ("jobs requiring
  English", "jobs with S1 minimum"). Each bullet gets its own row so it can
  be edited, removed, or indexed independently.

### `job` ◄── `tugas_dan_tanggung_jawab` (job_id)

- **Why:** Same normalization pattern for duties/responsibilities. Symmetry
  with `_kualifikasi_job` keeps the job-detail form predictable.

---

## 4. Recruitment Pipeline

This is the most intricate sub-schema. It models: *"for each application to a
job, track how far the applicant has advanced through that job's custom
hiring stages."*

### `proses` ◄── `step` (proses_id)

- **`proses`** is a **master list of stage types**: Screening, Interview,
  Technical Test, Offer, etc.
- **`step`** is the **actual stage instance** for a specific job.
- **Why split?** One company's "Interview" stage is semantically the same as
  another's — reporting can say "N candidates across the platform passed the
  Interview proses". But each job can reorder them or add descriptions.

### `job` ◄── `step` (job_id) + `urutan`

- **Cardinality:** 1 job → N ordered steps.
- **Why per-job steps?** Different roles need different pipelines (Sales:
  2 stages; Engineering: 5 stages with a code test). `urutan` stores the
  ordinal position so the UI renders stages in sequence.

### `jobseeker` ◄── `application` ──► `job`

- **Cardinality:** Jobseeker ↔ Job is many-to-many; `application`
  **resolves** that relationship.
- **Why not a plain pivot?** `application` carries state that doesn't belong
  on either side:
  - `tanggal_apply` — when the action happened
  - `status` — pending / accepted / rejected (final outcome)
- So `application` is a **first-class entity**, not a join table. A seeker
  can apply to many jobs; a job receives many applications.

### `application` ◄── `progress` ──► `step`

- **Cardinality:** Each application has N progress rows (one per step
  attempted).
- **Why this shape?** For applicant *A* applying to job *J*, the system must
  record per-step outcomes:
  - `step_id` — which stage
  - `lulus` — did they pass?
  - `catatan` — interviewer notes
- The natural unique key is `(application_id, step_id)`. This creates the
  pipeline view: `Application → ordered list of Progress rows → each tied to
  a Step → each Step typed by a Proses`.

---

## 5. Jobseeker Profile (CV Sections)

All seven profile tables share the same pattern: `jobseeker ←─── <section>`
with `jobseeker_id` FK.

### `jobseeker_type` ◄── `jobseeker`

- **Why:** Classifies seekers (Alumni, Current Student, External). Drives
  access rules — e.g., internship postings may be visible only to students,
  priority matching for alumni.

### `jobseeker` ◄── `organisasi / bahasa / riwayat_kerja / prestasi / riwayat_pendidikan / pelatihan / rekomendasi`

- **Why seven separate tables?** A CV is composed of repeatable sections.
  Each row represents one entry (one job, one language, one award), so:
  - **Variable count:** Some seekers have 10 past jobs, others have zero.
  - **Filterable:** "Show seekers who studied at UGM" → trivial JOIN.
  - **Attachable:** `prestasi.dokumen`, `pelatihan.sertifikat` hold file
    paths per entry. A single TEXT/JSON column would make this awkward.
  - **Auditable:** Each section row has its own timestamps.
- **Why not one generic `profile_item` table?** Fields differ too much
  (languages have a proficiency note; prestations have a year and document;
  rekomendasi has contact info). A generic EAV model would lose validation
  and readability.

---

## 6. Membership & Payment

### `membership` ◄── `pembayaran` ──► `users` / `account`

- **`membership`** is a **catalog** (plan name, duration, price).
- **`pembayaran`** is a **transaction** (who paid, what plan, which bank
  account received, valid-from / valid-to dates).
- **Why split catalog from transaction?** Prices change over time; a plan
  can be discontinued without invalidating past payments.

### `account` ◄── `pembayaran` (nomor_rekening)

- **Why keep the receiving account?** Admin may rotate business bank
  accounts. For reconciliation and audit, each payment must record *where
  the money went* at the time of transfer — even if the account is later
  deactivated.
- **Why is `nomor_rekening` the PK?** It's the natural business identifier
  (unique bank account number). Using it as PK avoids a surrogate and makes
  FK references self-documenting.

---

## 7. Job Fair

Job fairs are **optional, admin-curated events** that overlay existing jobs.

### `job_fair` ◄── `job_fair_job` ──► `job`

- **Cardinality:** Many-to-many — a fair lists many jobs; a job can appear
  in multiple fairs.
- **Why a pivot with state?** `job_fair_job` carries:
  - `status` — pending / approved / rejected (admin moderates which jobs
    actually appear in the fair)
  - `unique(job_fair_id, job_id)` — a job can be submitted to a given fair
    at most once.
- So this is more than a pivot — it's an **approval queue entity**.

### `employer` ◄── `job_fair_job` (employer_id)

- **Cardinality:** 1 employer → N fair submissions.
- **Why duplicate the employer FK** when it's derivable via `job.employer_id`?
  - **Query convenience:** "list all fair participations for this employer"
    avoids a JOIN through `job`.
  - **Integrity hint:** it makes clear who submitted the entry (potentially
    useful if a job's ownership ever changes).
- **Trade-off:** creates a denormalization that must stay consistent with
  `job.employer_id`. Worth it for the UX where employers manage their fair
  submissions from their own dashboard.

---

## 8. Cross-Cutting Observations

### Why so many 1:N from `users`?

`users` is the auth anchor. Anything that belongs to a *person's account* —
not to their role — hangs directly off it (payments, notifications, social
links). Anything belonging to a *role* hangs off `employer` or `jobseeker`.

### Why is `application` central?

It's the hinge where the three major actors meet:
`jobseeker → application → job → employer`. Every interaction
(submission, progress, acceptance, rejection, notification trigger)
flows through this table.

### Why is `job_fair_job` the most complex pivot?

It links **three** entities (fair + job + employer) and carries workflow
state (`status` enum). It encodes the rule *"an employer submits jobs to a
fair, and admin approves them"* — three parties, one approval step.

### Why satellite tables instead of JSON columns?

This schema was designed for an admin panel with **DataTables + search/
filter + exports to Excel/PDF**. Every one of those features performs
dramatically better against normalized rows than against JSON blobs. The
cost is more tables; the benefit is queryability and reporting fitness.
