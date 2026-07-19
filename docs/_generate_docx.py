"""
Generate Word documents from the sidang preparation materials.
Outputs two .docx files into the docs/ folder:
  1. Persiapan-Sidang.docx
  2. Kebutuhan-Fungsional.docx
"""

import os, sys
from docx import Document
from docx.shared import Pt, Inches, Cm, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.oxml.ns import qn, nsdecls
from docx.oxml import parse_xml

DOCS_DIR = os.path.dirname(os.path.abspath(__file__))


# ── helpers ──────────────────────────────────────────────────────────────

def set_cell_shading(cell, color_hex):
    """Set background color of a table cell."""
    shading = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color_hex}"/>')
    cell._tc.get_or_add_tcPr().append(shading)


def add_formatted_cell(cell, text, bold=False, size=9, alignment=None, color=None):
    """Write text into a cell with formatting."""
    cell.text = ""
    p = cell.paragraphs[0]
    if alignment:
        p.alignment = alignment
    run = p.add_run(text)
    run.font.size = Pt(size)
    run.bold = bold
    if color:
        run.font.color.rgb = RGBColor(*color)


def make_table(doc, headers, rows, col_widths=None):
    """Create a formatted table with header row."""
    table = doc.add_table(rows=1 + len(rows), cols=len(headers))
    table.style = "Table Grid"
    table.alignment = WD_TABLE_ALIGNMENT.CENTER

    # Header row
    for i, h in enumerate(headers):
        cell = table.rows[0].cells[i]
        add_formatted_cell(cell, h, bold=True, size=9, color=(255, 255, 255))
        set_cell_shading(cell, "2B579A")

    # Data rows
    for r_idx, row_data in enumerate(rows):
        for c_idx, val in enumerate(row_data):
            cell = table.rows[r_idx + 1].cells[c_idx]
            add_formatted_cell(cell, str(val), size=9)
            if r_idx % 2 == 1:
                set_cell_shading(cell, "F2F2F2")

    # Column widths
    if col_widths:
        for row in table.rows:
            for i, w in enumerate(col_widths):
                row.cells[i].width = Cm(w)

    return table


def heading(doc, text, level=1):
    h = doc.add_heading(text, level=level)
    for run in h.runs:
        run.font.color.rgb = RGBColor(0x1A, 0x1A, 0x2E)
    return h


def para(doc, text, bold=False, italic=False, size=11, space_after=6):
    p = doc.add_paragraph()
    run = p.add_run(text)
    run.font.size = Pt(size)
    run.bold = bold
    run.italic = italic
    p.paragraph_format.space_after = Pt(space_after)
    return p


def bullet(doc, text, level=0, bold_prefix=""):
    p = doc.add_paragraph(style="List Bullet")
    p.paragraph_format.left_indent = Cm(1.27 + level * 0.63)
    if bold_prefix:
        run_b = p.add_run(bold_prefix)
        run_b.bold = True
        run_b.font.size = Pt(10)
        run = p.add_run(text)
        run.font.size = Pt(10)
    else:
        p.text = ""
        run = p.add_run(text)
        run.font.size = Pt(10)
    return p


def numbered(doc, text, number=""):
    p = doc.add_paragraph(style="List Number")
    p.text = ""
    run = p.add_run(text)
    run.font.size = Pt(10)
    return p


def code_block(doc, text):
    p = doc.add_paragraph()
    p.paragraph_format.left_indent = Cm(1.0)
    p.paragraph_format.space_before = Pt(4)
    p.paragraph_format.space_after = Pt(4)
    run = p.add_run(text)
    run.font.name = "Consolas"
    run.font.size = Pt(9)
    run.font.color.rgb = RGBColor(0x33, 0x33, 0x33)
    # Set east-asian font too
    rPr = run._element.get_or_add_rPr()
    rFonts = rPr.find(qn("w:rFonts"))
    if rFonts is None:
        rFonts = parse_xml(f'<w:rFonts {nsdecls("w")} w:ascii="Consolas" w:hAnsi="Consolas" w:cs="Consolas"/>')
        rPr.append(rFonts)
    return p


def add_use_case_table(doc, fields):
    """Render a use-case header as a two-column table."""
    table = doc.add_table(rows=len(fields), cols=2)
    table.style = "Table Grid"
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    for i, (label, value) in enumerate(fields):
        cell_l = table.rows[i].cells[0]
        cell_r = table.rows[i].cells[1]
        add_formatted_cell(cell_l, label, bold=True, size=9)
        add_formatted_cell(cell_r, value, size=9)
        cell_l.width = Cm(3)
        cell_r.width = Cm(13)
        set_cell_shading(cell_l, "E8EDF3")
    return table


# ═════════════════════════════════════════════════════════════════════════
# DOCUMENT 1: Persiapan Sidang
# ═════════════════════════════════════════════════════════════════════════

def build_persiapan_sidang():
    doc = Document()

    # Default font
    style = doc.styles["Normal"]
    font = style.font
    font.name = "Calibri"
    font.size = Pt(11)

    # ── Title page ──
    doc.add_paragraph()  # spacing
    title = doc.add_paragraph()
    title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = title.add_run("Persiapan Sidang")
    run.bold = True
    run.font.size = Pt(26)
    run.font.color.rgb = RGBColor(0x1A, 0x1A, 0x2E)

    subtitle = doc.add_paragraph()
    subtitle.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = subtitle.add_run("Sistem Informasi Pusat Karir")
    run.font.size = Pt(16)
    run.font.color.rgb = RGBColor(0x55, 0x55, 0x55)

    doc.add_paragraph()
    note = doc.add_paragraph()
    note.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = note.add_run(
        "Dokumen ini berisi rangkuman penjelasan arsitektur, alur bisnis, "
        "dan library yang digunakan di project pusatkarir-v1 "
        "untuk keperluan persiapan sidang Tugas Akhir."
    )
    run.italic = True
    run.font.size = Pt(10)
    run.font.color.rgb = RGBColor(0x66, 0x66, 0x66)

    doc.add_page_break()

    # ── 1. Bagaimana Laravel Bekerja ──
    heading(doc, "1. Bagaimana Laravel Bekerja (Refresh)", level=1)

    para(doc, "Bayangkan Laravel seperti restoran:")

    code_block(doc,
        "Browser (Pelanggan)\n"
        "    |\n"
        "    v\n"
        "routes/web.php (Pelayan -- menerima pesanan, arahkan ke dapur yang tepat)\n"
        "    |\n"
        "    v\n"
        "Middleware (Satpam -- cek identitas & izin sebelum masuk)\n"
        "    |\n"
        "    v\n"
        "Controller (Koki -- proses pesanan, koordinasi bahan)\n"
        "    |\n"
        "    v\n"
        "Model (Gudang Bahan -- ambil/simpan data dari database)\n"
        "    |\n"
        "    v\n"
        "View / Blade (Piring Saji -- data disajikan sebagai HTML)\n"
        "    |\n"
        "    v\n"
        "Browser (Pelanggan menerima hasil)"
    )

    heading(doc, "Alur Lengkap Satu Request", level=2)
    para(doc, 'Contoh: Employer buka /employer/job/create')

    numbered(doc, "User buka browser -- ketik URL /employer/job/create")
    numbered(doc, "routes/web.php -- cocokkan URL dengan controller. Route::resource otomatis buat 7 route: index, create, store, show, edit, update, destroy.")
    numbered(doc, "Middleware dijalankan secara berurutan sebelum masuk controller: role:employer (cek role), verified_employer (cek data perusahaan terverifikasi).")
    numbered(doc, "Controller (JobController@create) dipanggil, ambil data yang diperlukan.")
    numbered(doc, "Model (Job, Employer, Step) -- Eloquent ORM bicara ke database, return object PHP.")
    numbered(doc, "View (resources/views/frontoffice/employer/job/create.blade.php) -- render HTML pakai data dari controller.")
    numbered(doc, "Response dikirim balik ke browser.")

    doc.add_page_break()

    # ── 2. Arsitektur Project ──
    heading(doc, "2. Arsitektur Project", level=1)
    para(doc, "Project ini menggunakan pola MVC (Model-View-Controller) bawaan Laravel.")

    heading(doc, "Layer Utama", level=2)
    make_table(doc,
        ["Layer", "Lokasi", "Peran"],
        [
            ["Model", "app/Models/", "Representasi tabel database. Relasi antar tabel didefinisikan di sini (hasMany, belongsTo, dll)."],
            ["View", "resources/views/", "Template Blade (HTML + PHP). Menggunakan Bootstrap 5 (Hope UI)."],
            ["Controller", "app/Http/Controllers/", "Menerima request, proses logika, kirim data ke view."],
        ],
        col_widths=[3, 4.5, 9]
    )

    doc.add_paragraph()
    heading(doc, "Layer Tambahan", level=2)
    make_table(doc,
        ["Layer", "Lokasi", "Peran"],
        [
            ["Middleware", "app/Http/Middleware/", "Filter request sebelum masuk controller (auth, role, verifikasi)."],
            ["Form Request", "app/Http/Requests/", "Validasi input dari form -- dipisah dari controller."],
            ["Livewire", "app/Livewire/", "Komponen interaktif tanpa reload halaman."],
            ["Services", "app/Services/", "Business logic yang dipakai beberapa controller."],
        ],
        col_widths=[3, 4.5, 9]
    )

    doc.add_paragraph()
    heading(doc, "Pembagian Controller", level=2)
    make_table(doc,
        ["Folder", "Untuk Siapa", "Contoh"],
        [
            ["Controllers/BackOffice/", "Admin", "EmployerVerificationController"],
            ["Controllers/FrontOffice/", "Public / Employer", "JobFairController"],
            ["Controllers/Auth/", "Semua user", "AuthenticatedSessionController"],
            ["Controllers/Security/", "Admin", "RoleController"],
            ["Controllers/ (root)", "Shared", "JobController, ApplicationController"],
        ],
        col_widths=[5, 4, 7.5]
    )

    doc.add_page_break()

    # ── 3. Fitur Utama & Alur Bisnis ──
    heading(doc, "3. Fitur Utama & Alur Bisnis", level=1)

    # A. Verifikasi Employer
    heading(doc, "A. Alur Verifikasi Employer", level=2)
    code_block(doc,
        "Employer Register --> Login --> Isi Data Perusahaan (/employer/verifikasi)\n"
        "    --> Status jadi \"pending\"\n"
        "    --> Middleware CompleteProfile BLOKIR akses sampai admin approve\n"
        "    --> Admin buka /backoffic3/employer-verification --> Approve/Reject\n"
        "    --> Kalau approved --> Employer bisa akses semua fitur\n"
        "    --> Kalau rejected --> Ada catatan alasan, employer bisa submit ulang"
    )
    para(doc,
        "Kenapa penting? Tanpa ini, siapa saja bisa daftar sebagai employer dan langsung "
        "posting lowongan palsu. Ini adalah business rule yang melindungi integritas data.",
        italic=True, size=10
    )
    heading(doc, "File kunci:", level=3)
    make_table(doc,
        ["File", "Peran"],
        [
            ["app/Http/Middleware/CompleteProfile.php", "Gerbang utama, blokir employer belum verified"],
            ["app/Http/Controllers/BackOffice/EmployerVerificationController.php", "Admin approve/reject"],
            ["app/Models/Employer.php", "Field verification_status (pending/approved/rejected)"],
        ],
        col_widths=[9, 7.5]
    )

    doc.add_paragraph()

    # B. Posting & Kelola Lowongan
    heading(doc, "B. Alur Posting & Kelola Lowongan", level=2)
    code_block(doc,
        "Employer --> Buat Lowongan (nama, posisi, requirement, deadline)\n"
        "    --> Wajib isi minimal 1 Tahap Seleksi (Step)\n"
        "    --> Lowongan status \"active\" --> muncul di halaman publik\n"
        "    --> Employer bisa Close/Reopen lowongan\n"
        "    --> Soft Delete (admin only) -- data tidak hilang dari database"
    )
    heading(doc, "Konsep kunci:", level=3)
    bullet(doc, " -- employer bisa tutup lowongan tanpa hapus.", bold_prefix="Status (active/closed)")
    bullet(doc, " -- kolom deleted_at diisi timestamp, bukan benar-benar dihapus. History lamaran tetap ada.", bold_prefix="Soft Deletes")
    bullet(doc, " -- validasi di JobStoreRequest memastikan setiap lowongan punya minimal 1 tahap seleksi.", bold_prefix="Step/Tahap wajib")

    heading(doc, "Relasi Model:", level=3)
    code_block(doc,
        "Employer --hasMany--> Job --hasMany--> Step (tahap seleksi)\n"
        "                       |\n"
        "                       +--hasMany--> Application --hasMany--> Progress"
    )

    doc.add_page_break()

    # C. Lamaran & Pipeline
    heading(doc, "C. Alur Lamaran & Pipeline Seleksi (Paling Kompleks)", level=2)
    code_block(doc,
        "Jobseeker lihat lowongan --> Klik Apply\n"
        "    --> Application dibuat (status: pending)\n"
        "    --> Employer buka halaman Applicants --> pilih pelamar --> isi progress tiap tahap\n"
        "    --> Tahap harus diisi BERURUTAN (Step 1 dulu, baru Step 2, dst)\n"
        "    --> Kalau satu tahap GAGAL  --> status otomatis \"rejected\"\n"
        "    --> Kalau SEMUA tahap LULUS --> status otomatis \"accepted\""
    )

    heading(doc, "State Machine:", level=3)
    code_block(doc,
        "pending --(semua tahap lulus)--> accepted\n"
        "   |\n"
        "   +--(satu tahap gagal)------> rejected"
    )

    heading(doc, "Method kunci di app/Models/Application.php:", level=3)
    make_table(doc,
        ["Method", "Fungsi"],
        [
            ["isStepEditable($step)", "Hanya step yang sedang aktif yang bisa diedit"],
            ["isFinalized()", "Kalau sudah accepted/rejected, tidak bisa diubah lagi"],
            ["syncStatusFromProgress()", "Otomatis hitung status akhir setelah employer update satu tahap"],
            ["currentStep()", "Cari step pertama yang belum lulus"],
        ],
        col_widths=[5.5, 11]
    )

    doc.add_paragraph()
    para(doc,
        "Contoh pertanyaan penguji: \"Bagaimana kalau employer coba loncat ke step 3 "
        "padahal step 1 belum selesai?\"",
        bold=True, size=10
    )
    para(doc,
        "Jawab: isStepEditable() mengecek apakah step itu adalah currentStep(). Kalau bukan, "
        "form-nya di-hide dan request POST akan ditolak di controller (ApplicationController::updateProgress).",
        size=10
    )

    doc.add_paragraph()

    # D. Job Fair
    heading(doc, "D. Alur Job Fair", level=2)
    code_block(doc,
        "Admin buat Job Fair (nama, tanggal, lokasi, kuota)\n"
        "    --> Employer lihat daftar job fair --> pilih --> daftarkan lowongan\n"
        "    --> Sistem cek: fair masih active? tanggal belum lewat? kuota belum penuh?\n"
        "    --> Kalau lolos --> pendaftaran masuk (status: pending)\n"
        "    --> Admin approve/reject di backoffice\n"
        "    --> Jobseeker bisa lihat lowongan yang sudah approved di job fair"
    )
    heading(doc, "Method kunci di app/Models/JobFair.php:", level=3)
    make_table(doc,
        ["Method", "Fungsi"],
        [
            ["isRegistrationOpen()", "Cek active + tanggal belum lewat"],
            ["hasCapacity()", "Cek kuota (NULL = unlimited)"],
            ["registeredCount()", "Hitung pending + approved (rejected tidak dihitung)"],
        ],
        col_widths=[5.5, 11]
    )

    doc.add_page_break()

    # ── 4. Konsep Laravel yang Sering Ditanya ──
    heading(doc, "4. Konsep Laravel yang Sering Ditanya Penguji", level=1)

    concepts = [
        ("Eloquent ORM",
         "Cara Laravel bicara ke database pakai object PHP, bukan SQL mentah.",
         "$jobs = Job::where('employer_id', 5)->get();\n$job->applications;  // otomatis query ke tabel application"),
        ("Migration",
         "File PHP yang mendefinisikan struktur tabel database. Seperti \"version control untuk database\". "
         "Jalankan php artisan migrate dan Laravel baca semua file di database/migrations/ lalu buat/ubah tabelnya.",
         None),
        ("Middleware",
         "Filter yang dijalankan SEBELUM request sampai ke controller. Di project ini:\n"
         "- auth: pastikan user sudah login\n"
         "- role:employer: pastikan user punya role employer (Spatie Permission)\n"
         "- verified_employer: pastikan data perusahaan sudah diverifikasi admin\n"
         "Didaftarkan di app/Http/Kernel.php sebagai route middleware.",
         None),
        ("Soft Deletes",
         "Data tidak benar-benar dihapus dari database, melainkan kolom deleted_at diisi timestamp. "
         "Query biasa (Job::all()) otomatis exclude data yang sudah di-soft-delete. "
         "Dipakai di model Job supaya history lamaran tidak hilang.",
         None),
        ("Route Resource",
         "Route::resource('job', JobController::class) otomatis bikin 7 route sekaligus: "
         "index (GET /job), create (GET /job/create), store (POST /job), show (GET /job/{job}), "
         "edit (GET /job/{job}/edit), update (PUT /job/{job}), destroy (DELETE /job/{job}). "
         "Di project ini, employer resource pakai ->except(['destroy']) karena hard delete hanya boleh admin.",
         None),
        ("Form Request",
         "Class khusus untuk validasi input (app/Http/Requests/JobStoreRequest.php). Daripada validasi di dalam "
         "controller, Laravel bisa otomatis reject request yang tidak valid sebelum masuk controller. Lebih rapi dan reusable.",
         None),
        ("Livewire",
         "Framework untuk bikin komponen interaktif di Blade tanpa menulis JavaScript. Setiap interaksi user "
         "dikirim ke server via AJAX, server update state, lalu kirim balik HTML yang berubah saja. "
         "Di project ini dipakai untuk form Riwayat Pendidikan.",
         None),
    ]

    for title_text, desc, code in concepts:
        heading(doc, title_text, level=2)
        para(doc, desc, size=10)
        if code:
            code_block(doc, code)

    doc.add_page_break()

    # ── 5. Pertanyaan Jebakan ──
    heading(doc, "5. Pertanyaan Jebakan & Cara Jawab", level=1)

    qas = [
        ("Kenapa pakai Laravel, bukan framework lain?",
         "Ekosistem lengkap (auth, ORM, migration, validation sudah built-in). "
         "Dokumentasi sangat baik, komunitas besar. Blade template mudah dipelajari. "
         "Cocok untuk aplikasi web monolith seperti sistem informasi."),
        ("Kenapa tidak pakai API + frontend terpisah (React/Vue)?",
         "Scope Tugas Akhir tidak memerlukan arsitektur microservice. "
         "Server-side rendering dengan Blade lebih sederhana untuk aplikasi CRUD. "
         "Livewire sudah cukup untuk interaktivitas yang dibutuhkan."),
        ("Bagaimana keamanan sistem ini?",
         "CSRF Protection: semua form punya @csrf token. "
         "Role-based access: Spatie Permission memastikan employer tidak bisa akses halaman admin. "
         "Employer verification: mencegah akun palsu posting lowongan. "
         "Soft deletes: data tidak hilang permanen. "
         "Form validation: input divalidasi server-side via FormRequest. "
         "reCAPTCHA: mencegah bot spam."),
        ("Apa kekurangan sistem ini? (jawab jujur)",
         "Membership & Pembayaran belum diwiring (scaffold only). "
         "Data akademik (Prodi) belum dinormalisasi penuh -- free text, belum FK. "
         "Profile completion belum di-enforce sebelum apply (placeholder data '-')."),
    ]

    for q, a in qas:
        para(doc, q, bold=True, size=11)
        para(doc, a, size=10)

    doc.add_page_break()

    # ── 6. Library & Dependencies ──
    heading(doc, "6. Library & Dependencies Non-Default", level=1)

    heading(doc, "Ringkasan Struktur", level=2)
    code_block(doc,
        "Laravel 10 Fresh Install\n"
        "|-- laravel/framework ........... default\n"
        "|-- laravel/sanctum ............. default\n"
        "|-- laravel/tinker .............. default\n"
        "|-- guzzlehttp/guzzle .......... default\n"
        "|\n"
        "|   == Yang di bawah ini DITAMBAHKAN ==\n"
        "|\n"
        "|-- AUTH & ACCESS\n"
        "|   |-- laravel/breeze ................. auth scaffold (dev)\n"
        "|   |-- laravel/socialite .............. social login (Google, dll)\n"
        "|   +-- spatie/laravel-permission ...... role & permission (RBAC)\n"
        "|\n"
        "|-- PDF\n"
        "|   |-- barryvdh/laravel-dompdf ........ generate PDF (pure PHP)\n"
        "|   +-- barryvdh/laravel-snappy ........ generate PDF (wkhtmltopdf)\n"
        "|\n"
        "|-- EXCEL\n"
        "|   |-- maatwebsite/excel .............. import/export Excel\n"
        "|   +-- rap2hpoutre/fast-excel ......... quick export\n"
        "|\n"
        "|-- DATATABLES\n"
        "|   +-- yajra/laravel-datatables ....... server-side tables\n"
        "|\n"
        "|-- UI/UX\n"
        "|   |-- livewire/livewire .............. interactive components\n"
        "|   |-- realrashid/sweet-alert ......... popup notifications\n"
        "|   |-- anhskohbo/no-captcha ........... reCAPTCHA\n"
        "|   +-- select2 ....................... searchable dropdowns\n"
        "|\n"
        "|-- MEDIA\n"
        "|   +-- spatie/laravel-medialibrary .... file/image management\n"
        "|\n"
        "+-- DEV TOOLS\n"
        "    |-- laravel/telescope .............. debug dashboard\n"
        "    +-- laravel-shift/blueprint ........ code generator"
    )

    doc.add_paragraph()

    # PHP Libraries detail
    heading(doc, "PHP Libraries -- Penjelasan Detail", level=2)

    libs = [
        ("Authentication & Authorization", [
            ("laravel/breeze (dev)",
             "Starter kit auth dari Laravel. Menghasilkan halaman Login, Register, Forgot Password, Email Verification. "
             "Dev-dependency karena hanya dibutuhkan saat generate scaffold awal."),
            ("laravel/socialite",
             "Library resmi Laravel untuk login via pihak ketiga (Google, Facebook, GitHub) menggunakan OAuth2."),
            ("spatie/laravel-permission",
             "Library untuk Role-Based Access Control (RBAC). Assign role (admin, employer, mahasiswa) dan permission ke user. "
             "Data disimpan di 5 tabel: roles, permissions, model_has_roles, model_has_permissions, role_has_permissions."),
        ]),
        ("PDF Generation", [
            ("barryvdh/laravel-dompdf",
             "Generate PDF dari HTML/Blade template. Pure PHP, tidak butuh install software tambahan. Dipakai untuk generate CV."),
            ("barryvdh/laravel-snappy + wkhtmltopdf",
             "Alternative PDF generator pakai wkhtmltopdf (WebKit engine). Hasilnya lebih bagus untuk layout kompleks."),
        ]),
        ("Excel / Spreadsheet", [
            ("maatwebsite/excel + phpoffice/phpspreadsheet",
             "Library untuk import dan export file Excel (.xlsx). Dipakai di app/Imports/ untuk import data."),
            ("rap2hpoutre/fast-excel",
             "Alternative Excel library yang lebih ringan. Cocok untuk export sederhana satu baris kode."),
        ]),
        ("DataTables (Server-Side)", [
            ("yajra/laravel-datatables",
             "Library untuk server-side DataTables. Sorting, searching, dan pagination dilakukan di server -- "
             "browser hanya terima data yang ditampilkan. Dipakai di hampir semua halaman index backoffice."),
        ]),
        ("UI & UX", [
            ("realrashid/sweet-alert",
             "Wrapper Laravel untuk SweetAlert2 -- popup notifikasi yang lebih bagus daripada alert() bawaan browser."),
            ("anhskohbo/no-captcha",
             "Integrasi Google reCAPTCHA untuk Laravel. Melindungi form dari bot spam."),
            ("select2 + bootstrap-5-theme",
             "jQuery plugin yang membuat dropdown <select> jadi searchable, multi-select, dengan autocomplete."),
        ]),
        ("Livewire", [
            ("livewire/livewire",
             "Framework untuk bikin komponen interaktif di Blade tanpa JavaScript. "
             "Dipakai untuk form Riwayat Pendidikan -- tambah/hapus baris tanpa reload halaman."),
        ]),
        ("Media & File", [
            ("spatie/laravel-medialibrary",
             "Library untuk mengelola file upload yang terhubung ke model Eloquent. "
             "Mendukung resize gambar, konversi format, multiple collections."),
        ]),
        ("Development Tools", [
            ("laravel/telescope",
             "Dashboard debugging -- menampilkan request, query database, exception, dll secara real-time. "
             "Hanya diaktifkan di environment development."),
            ("laravel-shift/blueprint (dev)",
             "Tool untuk generate code dari file YAML. Dipakai di awal project untuk scaffolding cepat."),
        ]),
    ]

    for section_title, items in libs:
        heading(doc, section_title, level=3)
        for lib_name, lib_desc in items:
            para(doc, lib_name, bold=True, size=10, space_after=2)
            para(doc, lib_desc, size=10, space_after=8)

    doc.add_paragraph()

    # JS Libraries
    heading(doc, "JavaScript Libraries (Frontend)", level=2)
    make_table(doc,
        ["Library", "Fungsi"],
        [
            ["bootstrap", "CSS framework utama -- layout, grid, komponen UI"],
            ["jquery", "DOM manipulation -- dibutuhkan oleh DataTables dan Select2"],
            ["sweetalert2", "Popup notifikasi cantik (counterpart JS dari realrashid/sweet-alert)"],
            ["datatables.net", "Client-side DataTables plugin (tabel interaktif)"],
            ["flatpickr", "Date/time picker -- input tanggal yang user-friendly"],
            ["filepond + plugins", "Upload file modern -- drag & drop, preview, validasi, crop"],
            ["@pqina/pintura", "Image editor -- crop, resize, rotate sebelum upload"],
            ["apexcharts", "Library grafik/chart -- visualisasi data di dashboard"],
            ["nouislider", "Range slider input -- misal filter gaji"],
            ["fslightbox", "Lightbox untuk preview gambar full-screen"],
            ["swiper", "Carousel/slider -- misal slider banner di landing page"],
            ["counterup2 + waypoints", "Animasi angka naik -- misal \"500+ Lowongan\" di landing page"],
        ],
        col_widths=[4.5, 12]
    )

    doc.add_page_break()

    # ── 7. Checklist ──
    heading(doc, "7. Checklist Sebelum Hari-H", level=1)

    checklist = [
        "Demo bisa jalan -- php artisan serve, buka di browser, test semua alur utama.",
        "Siapkan data dummy -- employer (verified & unverified), lowongan (active & closed), lamaran di berbagai tahap (pending, accepted, rejected), job fair dengan kuota.",
        "Hafal ERD -- bisa gambar relasi antar tabel utama di whiteboard: User, Employer, Jobseeker, Job, Application, Step, Progress, JobFair.",
        "Pahami 4 alur bisnis utama -- bisa walk through sambil tunjuk kode.",
        "Tahu letak file -- kalau penguji tanya \"di mana validasinya?\", langsung jawab app/Http/Requests/JobStoreRequest.php.",
        "Bisa jelaskan setiap library -- kenapa dipilih, apa fungsinya.",
        "Tahu kekurangan sistem -- jujur, tapi frame sebagai \"future work\".",
    ]
    for item in checklist:
        bullet(doc, item)

    # Save
    path = os.path.join(DOCS_DIR, "Persiapan-Sidang.docx")
    doc.save(path)
    print(f"  -> {path}")
    return path


# ═════════════════════════════════════════════════════════════════════════
# DOCUMENT 2: Kebutuhan Fungsional
# ═════════════════════════════════════════════════════════════════════════

def build_kebutuhan_fungsional():
    doc = Document()

    style = doc.styles["Normal"]
    font = style.font
    font.name = "Calibri"
    font.size = Pt(11)

    # ── Title page ──
    doc.add_paragraph()
    title = doc.add_paragraph()
    title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = title.add_run("Dokumen Kebutuhan Fungsional\ndan Non-Fungsional")
    run.bold = True
    run.font.size = Pt(24)
    run.font.color.rgb = RGBColor(0x1A, 0x1A, 0x2E)

    subtitle = doc.add_paragraph()
    subtitle.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run = subtitle.add_run("Sistem Informasi Pusat Karir")
    run.font.size = Pt(16)
    run.font.color.rgb = RGBColor(0x55, 0x55, 0x55)

    doc.add_page_break()

    # ── 1. Deskripsi Sistem ──
    heading(doc, "1. Deskripsi Sistem", level=1)
    para(doc,
        "Sistem Informasi Pusat Karir adalah aplikasi web yang menghubungkan "
        "mahasiswa/pencari kerja (jobseeker) dengan perusahaan (employer) melalui "
        "platform yang dikelola oleh pusat karir perguruan tinggi (admin). Sistem "
        "menyediakan fitur pengelolaan lowongan kerja, proses lamaran dengan pipeline "
        "seleksi bertahap, job fair, serta manajemen profil dan CV digital.",
        size=11
    )

    # ── 2. Identifikasi Aktor ──
    heading(doc, "2. Identifikasi Aktor", level=1)
    make_table(doc,
        ["No", "Aktor", "Deskripsi"],
        [
            ["1", "Admin", "Pengelola backoffice pusat karir. Memiliki akses penuh untuk mengelola data master, verifikasi employer, kelola lowongan, job fair, user, dan konten."],
            ["2", "Employer", "Perusahaan yang telah terdaftar dan terverifikasi. Dapat memposting lowongan, mengelola tahap seleksi, mereview pelamar, dan berpartisipasi di job fair."],
            ["3", "Jobseeker (Mahasiswa)", "Pencari kerja / mahasiswa. Dapat mengelola profil & CV, melamar pekerjaan, melihat progress seleksi, dan mengikuti job fair."],
            ["4", "Guest", "Pengunjung yang belum login. Dapat melihat landing page dan daftar lowongan publik."],
        ],
        col_widths=[1, 3, 12.5]
    )

    doc.add_page_break()

    # ── 3. Kebutuhan Fungsional ──
    heading(doc, "3. Kebutuhan Fungsional", level=1)

    # All functional requirement modules
    modules = [
        ("3.1 Modul Autentikasi & Registrasi", [
            ["F-AUTH-01", "Sistem menyediakan halaman registrasi dengan pilihan peran (Employer atau Mahasiswa).", "Guest", "Tinggi"],
            ["F-AUTH-02", "Sistem menyediakan halaman login untuk semua peran pengguna.", "Guest", "Tinggi"],
            ["F-AUTH-03", "Sistem mendukung login melalui akun sosial media (Google) menggunakan OAuth2.", "Guest", "Sedang"],
            ["F-AUTH-04", "Sistem menyediakan fitur lupa password dan reset password melalui email.", "Guest", "Tinggi"],
            ["F-AUTH-05", "Sistem menyediakan fitur logout yang menghapus session pengguna.", "Semua", "Tinggi"],
            ["F-AUTH-06", "Sistem mengarahkan pengguna ke dashboard sesuai peran setelah login.", "Semua", "Tinggi"],
            ["F-AUTH-07", "Sistem mendukung proteksi form dengan CAPTCHA (Google reCAPTCHA) untuk mencegah bot.", "Guest", "Sedang"],
        ]),
        ("3.2 Modul Verifikasi Employer", [
            ["F-VER-01", "Employer yang baru terdaftar wajib mengisi data perusahaan sebelum dapat mengakses fitur lain.", "Employer", "Tinggi"],
            ["F-VER-02", "Setelah mengisi data, status employer menjadi \"pending\" dan seluruh akses selain halaman verifikasi diblokir.", "Employer", "Tinggi"],
            ["F-VER-03", "Admin dapat melihat daftar employer berdasarkan status verifikasi (pending, approved, rejected).", "Admin", "Tinggi"],
            ["F-VER-04", "Admin dapat melihat detail data perusahaan employer yang mengajukan verifikasi.", "Admin", "Tinggi"],
            ["F-VER-05", "Admin dapat menyetujui (approve) pengajuan verifikasi employer.", "Admin", "Tinggi"],
            ["F-VER-06", "Admin dapat menolak (reject) pengajuan verifikasi disertai catatan alasan.", "Admin", "Tinggi"],
            ["F-VER-07", "Employer yang ditolak dapat mengirim ulang data perusahaan untuk diverifikasi kembali.", "Employer", "Tinggi"],
            ["F-VER-08", "Sistem mengirimkan notifikasi ke employer ketika status verifikasi berubah.", "Sistem", "Tinggi"],
        ]),
        ("3.3 Modul Kelola Lowongan Kerja", [
            ["F-JOB-01", "Employer dapat membuat lowongan kerja baru dengan mengisi: nama pekerjaan, alamat, posisi, requirement, deskripsi, ekspektasi gaji, tipe waktu kerja, dan deadline.", "Employer", "Tinggi"],
            ["F-JOB-02", "Employer wajib mengisi minimal 1 tahap seleksi (step) saat membuat lowongan.", "Employer", "Tinggi"],
            ["F-JOB-03", "Employer dapat melihat daftar semua lowongan miliknya beserta jumlah pelamar.", "Employer", "Tinggi"],
            ["F-JOB-04", "Employer dapat mengedit lowongan. Jika sudah ada progress, tahap seleksi tidak dapat diubah.", "Employer", "Tinggi"],
            ["F-JOB-05", "Employer dapat menutup lowongan (status \"closed\") sehingga tidak menerima lamaran baru.", "Employer", "Tinggi"],
            ["F-JOB-06", "Employer dapat membuka kembali lowongan yang telah ditutup.", "Employer", "Sedang"],
            ["F-JOB-07", "Admin dapat melihat seluruh lowongan dengan filter status dan pencarian.", "Admin", "Tinggi"],
            ["F-JOB-08", "Admin dapat menghapus lowongan secara soft delete, dengan syarat tidak ada lamaran pending.", "Admin", "Tinggi"],
            ["F-JOB-09", "Admin dapat memulihkan (restore) lowongan yang telah dihapus.", "Admin", "Sedang"],
            ["F-JOB-10", "Lowongan yang di-soft-delete tidak muncul di publik namun riwayat lamaran tetap tersimpan.", "Sistem", "Tinggi"],
        ]),
        ("3.4 Modul Lamaran & Pipeline Seleksi", [
            ["F-APP-01", "Jobseeker dapat melamar pekerjaan yang berstatus \"active\". Sistem mencegah lamaran ke lowongan yang ditutup.", "Jobseeker", "Tinggi"],
            ["F-APP-02", "Sistem memvalidasi kelengkapan profil sebelum melamar: wajib memiliki Riwayat Pendidikan dan Bahasa.", "Jobseeker", "Tinggi"],
            ["F-APP-03", "Sistem mencegah jobseeker melamar lowongan yang sama lebih dari satu kali.", "Sistem", "Tinggi"],
            ["F-APP-04", "Setelah lamaran terkirim, sistem mengirimkan notifikasi ke employer.", "Sistem", "Tinggi"],
            ["F-APP-05", "Employer dapat melihat daftar semua pelamar pada setiap lowongan miliknya.", "Employer", "Tinggi"],
            ["F-APP-06", "Employer dapat melihat CV/profil lengkap pelamar yang telah melamar ke lowongannya.", "Employer", "Tinggi"],
            ["F-APP-07", "Employer dapat mengunduh CV pelamar dalam format PDF.", "Employer", "Sedang"],
            ["F-APP-08", "Employer dapat mengisi progress setiap tahap seleksi (lulus/tidak lulus + catatan).", "Employer", "Tinggi"],
            ["F-APP-09", "Tahap seleksi harus diisi berurutan. Tidak dapat mengisi tahap ke-N sebelum tahap ke-(N-1) selesai.", "Sistem", "Tinggi"],
            ["F-APP-10", "Setelah semua tahap lulus, status lamaran otomatis menjadi \"accepted\".", "Sistem", "Tinggi"],
            ["F-APP-11", "Jika salah satu tahap tidak lulus, status lamaran otomatis menjadi \"rejected\".", "Sistem", "Tinggi"],
            ["F-APP-12", "Lamaran yang sudah final (accepted/rejected) tidak dapat diubah lagi.", "Sistem", "Tinggi"],
            ["F-APP-13", "Sistem mengirimkan notifikasi ke jobseeker setiap ada perubahan progress seleksi.", "Sistem", "Tinggi"],
            ["F-APP-14", "Jobseeker dapat melihat daftar semua lamaran beserta statusnya.", "Jobseeker", "Tinggi"],
            ["F-APP-15", "Jobseeker dapat melihat detail progress tahap seleksi untuk setiap lamarannya.", "Jobseeker", "Tinggi"],
        ]),
        ("3.5 Modul Job Fair", [
            ["F-JF-01", "Admin dapat membuat job fair baru (nama, deskripsi, lokasi, tanggal mulai/selesai, status, kuota).", "Admin", "Tinggi"],
            ["F-JF-02", "Admin dapat mengedit dan menghapus data job fair.", "Admin", "Tinggi"],
            ["F-JF-03", "Admin dapat melihat daftar peserta yang mendaftar di setiap job fair.", "Admin", "Tinggi"],
            ["F-JF-04", "Admin dapat menyetujui atau menolak pendaftaran peserta job fair, disertai notifikasi.", "Admin", "Tinggi"],
            ["F-JF-05", "Employer dapat melihat daftar job fair yang berstatus \"active\".", "Employer", "Tinggi"],
            ["F-JF-06", "Employer dapat mendaftarkan lowongan ke job fair. Sistem validasi: active, belum dimulai, kuota tersedia, belum terdaftar.", "Employer", "Tinggi"],
            ["F-JF-07", "Employer dapat membatalkan pendaftaran lowongan dari job fair.", "Employer", "Sedang"],
            ["F-JF-08", "Employer dapat melihat status pendaftaran lowongannya di setiap job fair.", "Employer", "Tinggi"],
            ["F-JF-09", "Sistem mengirimkan notifikasi ke semua admin ketika ada pendaftaran baru.", "Sistem", "Sedang"],
            ["F-JF-10", "Jobseeker dapat melihat daftar job fair yang sedang aktif.", "Jobseeker", "Tinggi"],
            ["F-JF-11", "Jobseeker dapat melihat lowongan yang sudah approved dan masih active di job fair.", "Jobseeker", "Tinggi"],
        ]),
        ("3.6 Modul Profil & CV Jobseeker", [
            ["F-PROF-01", "Jobseeker dapat mengelola data profil pribadi: nama, jenis kelamin, tanggal lahir, tipe, telepon, alamat.", "Jobseeker", "Tinggi"],
            ["F-PROF-02", "Jobseeker dapat mengelola riwayat pendidikan (CRUD).", "Jobseeker", "Tinggi"],
            ["F-PROF-03", "Jobseeker dapat mengelola data bahasa yang dikuasai.", "Jobseeker", "Tinggi"],
            ["F-PROF-04", "Jobseeker dapat mengelola riwayat kerja.", "Jobseeker", "Sedang"],
            ["F-PROF-05", "Jobseeker dapat mengelola data organisasi.", "Jobseeker", "Sedang"],
            ["F-PROF-06", "Jobseeker dapat mengelola data prestasi/penghargaan.", "Jobseeker", "Sedang"],
            ["F-PROF-07", "Jobseeker dapat mengelola data pelatihan/sertifikasi.", "Jobseeker", "Sedang"],
            ["F-PROF-08", "Jobseeker dapat mengelola data rekomendasi/referensi.", "Jobseeker", "Sedang"],
            ["F-PROF-09", "Sistem menampilkan persentase kelengkapan profil di dashboard.", "Sistem", "Sedang"],
            ["F-PROF-10", "Jobseeker dapat mengunduh CV dalam format PDF dari data profil.", "Jobseeker", "Tinggi"],
        ]),
        ("3.7 Modul Profil Employer", [
            ["F-EMP-01", "Employer dapat melihat profil perusahaan miliknya.", "Employer", "Tinggi"],
            ["F-EMP-02", "Employer dapat mengedit data perusahaan.", "Employer", "Tinggi"],
            ["F-EMP-03", "Sistem menampilkan persentase kelengkapan profil perusahaan di dashboard.", "Sistem", "Sedang"],
        ]),
        ("3.8 Modul Dashboard", [
            ["F-DASH-01", "Dashboard admin menampilkan ringkasan data sistem.", "Admin", "Tinggi"],
            ["F-DASH-02", "Dashboard employer menampilkan: jumlah lowongan, statistik lamaran, lamaran terbaru, job fair aktif, kelengkapan profil.", "Employer", "Tinggi"],
            ["F-DASH-03", "Dashboard jobseeker menampilkan: kelengkapan profil, statistik lamaran, lowongan terbaru.", "Jobseeker", "Tinggi"],
        ]),
        ("3.9 Modul Notifikasi", [
            ["F-NOTIF-01", "Sistem mengirimkan notifikasi in-app saat terjadi event penting.", "Sistem", "Tinggi"],
            ["F-NOTIF-02", "Pengguna dapat melihat daftar notifikasi dan jumlah yang belum dibaca.", "Semua", "Tinggi"],
            ["F-NOTIF-03", "Pengguna dapat menandai satu notifikasi sebagai sudah dibaca.", "Semua", "Tinggi"],
            ["F-NOTIF-04", "Pengguna dapat menandai semua notifikasi sebagai sudah dibaca sekaligus.", "Semua", "Sedang"],
        ]),
        ("3.10 Modul Landing Page & Halaman Publik", [
            ["F-PUB-01", "Sistem menampilkan landing page dengan informasi umum pusat karir.", "Guest", "Tinggi"],
            ["F-PUB-02", "Sistem menampilkan daftar lowongan yang berstatus \"active\" secara publik dengan pagination.", "Guest", "Tinggi"],
        ]),
        ("3.11 Modul Backoffice: Kelola Data Master", [
            ["F-MASTER-01", "Admin dapat mengelola (CRUD) data Jenjang Pendidikan.", "Admin", "Sedang"],
            ["F-MASTER-02", "Admin dapat mengelola (CRUD) data Fakultas.", "Admin", "Sedang"],
            ["F-MASTER-03", "Admin dapat mengelola (CRUD) data Program Studi (Prodi).", "Admin", "Sedang"],
        ]),
        ("3.12 Modul Backoffice: Kelola User & Security", [
            ["F-USER-01", "Admin dapat mengelola (CRUD) data user.", "Admin", "Tinggi"],
            ["F-USER-02", "Admin dapat mengelola (CRUD) data admin.", "Admin", "Tinggi"],
            ["F-USER-03", "Admin dapat mengelola (CRUD) data role.", "Admin", "Tinggi"],
            ["F-USER-04", "Admin dapat mengelola (CRUD) data permission.", "Admin", "Tinggi"],
            ["F-USER-05", "Admin dapat mengatur relasi role dan permission.", "Admin", "Tinggi"],
            ["F-USER-06", "Admin dapat mengelola (CRUD) data konselor.", "Admin", "Sedang"],
        ]),
        ("3.13 Modul Backoffice: Kelola Konten & Email", [
            ["F-CMS-01", "Admin dapat mengelola (CRUD) grup konten.", "Admin", "Rendah"],
            ["F-CMS-02", "Admin dapat mengelola (CRUD) kategori konten.", "Admin", "Rendah"],
            ["F-CMS-03", "Admin dapat mengelola (CRUD) konten/artikel.", "Admin", "Rendah"],
            ["F-CMS-04", "Admin dapat mengelola template email.", "Admin", "Rendah"],
            ["F-CMS-05", "Admin dapat mengirim email melalui sistem.", "Admin", "Rendah"],
        ]),
    ]

    for mod_title, rows in modules:
        heading(doc, mod_title, level=2)
        make_table(doc,
            ["ID", "Kebutuhan Fungsional", "Aktor", "Prioritas"],
            rows,
            col_widths=[2.2, 9.8, 2.2, 2.2]
        )
        doc.add_paragraph()

    doc.add_page_break()

    # ── 4. Kebutuhan Non-Fungsional ──
    heading(doc, "4. Kebutuhan Non-Fungsional", level=1)

    nf_rows = [
        ["NF-01", "Keamanan Autentikasi", "Security", "Sistem menggunakan session-based authentication dengan password yang di-hash menggunakan Bcrypt. Session di-regenerate setelah login."],
        ["NF-02", "Proteksi CSRF", "Security", "Setiap form POST/PUT/PATCH/DELETE dilindungi token CSRF yang divalidasi otomatis oleh middleware."],
        ["NF-03", "Otorisasi Berbasis Peran", "Security", "Akses dibatasi berdasarkan role (admin, employer, mahasiswa) menggunakan Spatie Laravel Permission."],
        ["NF-04", "Proteksi Bot", "Security", "Form registrasi dan login dilindungi Google reCAPTCHA."],
        ["NF-05", "Validasi Input", "Security", "Seluruh input pengguna divalidasi di sisi server menggunakan Form Request."],
        ["NF-06", "Soft Delete", "Reliability", "Data lowongan yang dihapus tidak hilang permanen (soft delete), riwayat lamaran tetap terjaga."],
        ["NF-07", "Responsivitas", "Usability", "Antarmuka web menggunakan Bootstrap 5 yang responsif (desktop dan mobile)."],
        ["NF-08", "Kompatibilitas Browser", "Usability", "Sistem dapat diakses melalui browser modern (Chrome, Firefox, Safari, Edge)."],
        ["NF-09", "Feedback Interaktif", "Usability", "Sistem memberikan feedback visual berupa popup SweetAlert2 untuk setiap aksi penting."],
        ["NF-10", "Interaktivitas Form", "Usability", "Form dinamis menggunakan Livewire sehingga tidak memerlukan reload halaman."],
        ["NF-11", "Server-Side Pagination", "Performance", "Tabel data besar menggunakan server-side DataTables."],
        ["NF-12", "Teknologi", "Maintain.", "Laravel 10 (PHP 8.1+), Blade, Bootstrap 5, Livewire 3, MySQL/MariaDB."],
        ["NF-13", "Arsitektur", "Maintain.", "Arsitektur MVC sesuai konvensi Laravel, dengan pemisahan middleware, form request, dan service."],
        ["NF-14", "Export Dokumen", "Functionality", "Sistem mampu menghasilkan file PDF (CV) dan file Excel (data export)."],
    ]

    make_table(doc,
        ["ID", "Kebutuhan", "Kategori", "Deskripsi"],
        nf_rows,
        col_widths=[1.5, 3.5, 2, 9.5]
    )

    doc.add_page_break()

    # ── 5. Deskripsi Use Case ──
    heading(doc, "5. Deskripsi Use Case", level=1)

    use_cases = [
        {
            "id": "UC-01", "title": "Registrasi Pengguna",
            "fields": [
                ("Aktor", "Guest"),
                ("Deskripsi", "Guest mendaftarkan akun baru sebagai Employer atau Mahasiswa."),
                ("Pre-condition", "Guest belum memiliki akun."),
                ("Post-condition", "Akun terdaftar, user otomatis login dan diarahkan ke halaman sesuai peran."),
                ("Trigger", "Guest membuka halaman registrasi."),
            ],
            "main": [
                "Guest memilih peran: Employer atau Mahasiswa.",
                "Guest mengisi email dan password (+ konfirmasi password).",
                "Jika memilih Mahasiswa, Guest juga memilih tipe jobseeker.",
                "Guest submit form.",
                "Sistem memvalidasi data (email unik, password minimal 8 karakter).",
                "Sistem membuat akun User dan assign role sesuai pilihan.",
                "Jika Mahasiswa: sistem otomatis membuat record Jobseeker.",
                "Sistem me-login-kan user dan redirect ke dashboard.",
            ],
            "alt": [
                "5a. Validasi gagal (email sudah terdaftar, password terlalu pendek): sistem menampilkan pesan error.",
            ],
        },
        {
            "id": "UC-02", "title": "Verifikasi Employer",
            "fields": [
                ("Aktor", "Employer, Admin"),
                ("Deskripsi", "Employer mengisi data perusahaan untuk diverifikasi oleh Admin."),
                ("Pre-condition", "Employer sudah login, belum terverifikasi."),
                ("Post-condition", "Employer berstatus approved/rejected."),
                ("Trigger", "Employer mengakses halaman manapun (middleware redirect ke verifikasi)."),
            ],
            "main": [
                "Sistem menampilkan form verifikasi (nama, deskripsi, tipe industri, alamat, telepon, website).",
                "Employer mengisi dan submit form.",
                "Status employer berubah menjadi \"pending\".",
                "Admin membuka halaman daftar verifikasi employer.",
                "Admin melihat detail data perusahaan.",
                "Admin menekan tombol \"Approve\".",
                "Status berubah menjadi \"approved\". Notifikasi dikirim ke employer.",
                "Employer kini dapat mengakses seluruh fitur.",
            ],
            "alt": [
                "6a. Admin menekan tombol \"Reject\" dan mengisi catatan alasan.",
                "6b. Status berubah menjadi \"rejected\". Notifikasi dikirim ke employer.",
                "6c. Employer dapat mengirim ulang data yang sudah diperbaiki.",
            ],
        },
        {
            "id": "UC-03", "title": "Membuat Lowongan Kerja",
            "fields": [
                ("Aktor", "Employer"),
                ("Deskripsi", "Employer membuat lowongan kerja baru lengkap dengan tahap seleksi."),
                ("Pre-condition", "Employer sudah login dan terverifikasi (approved)."),
                ("Post-condition", "Lowongan tersimpan dengan status \"active\" dan minimal 1 tahap seleksi."),
                ("Trigger", "Employer menekan tombol \"Buat Lowongan\"."),
            ],
            "main": [
                "Sistem menampilkan form lowongan.",
                "Employer mengisi data lowongan.",
                "Employer menambahkan minimal 1 tahap seleksi.",
                "Employer submit form.",
                "Sistem memvalidasi data.",
                "Lowongan tersimpan dengan status \"active\".",
                "Redirect ke daftar lowongan dengan pesan sukses.",
            ],
            "alt": [
                "5a. Validasi gagal (field kosong, tahap seleksi kosong): sistem menampilkan pesan error.",
            ],
        },
        {
            "id": "UC-04", "title": "Melamar Pekerjaan",
            "fields": [
                ("Aktor", "Jobseeker"),
                ("Deskripsi", "Jobseeker melamar pekerjaan yang tersedia."),
                ("Pre-condition", "Jobseeker sudah login, profil memiliki Riwayat Pendidikan dan Bahasa."),
                ("Post-condition", "Lamaran tersimpan (status: pending), notifikasi terkirim ke employer."),
                ("Trigger", "Jobseeker menekan tombol \"Lamar\"."),
            ],
            "main": [
                "Jobseeker melihat daftar lowongan berstatus \"active\".",
                "Jobseeker memilih lowongan dan menekan tombol \"Lamar\".",
                "Sistem memeriksa: lowongan masih active, profil lengkap, belum pernah melamar.",
                "Sistem membuat record Application (status: pending).",
                "Sistem mengirimkan notifikasi ke employer.",
                "Sistem menampilkan pesan sukses.",
            ],
            "alt": [
                "3a. Lowongan sudah ditutup: pesan error \"Lowongan sudah ditutup\".",
                "3b. Profil belum lengkap: pesan error dan redirect ke edit profil.",
                "3c. Sudah pernah melamar: pesan error \"Sudah melamar\".",
            ],
        },
        {
            "id": "UC-05", "title": "Mengelola Progress Seleksi",
            "fields": [
                ("Aktor", "Employer"),
                ("Deskripsi", "Employer mengisi progress tahap seleksi untuk setiap pelamar secara berurutan."),
                ("Pre-condition", "Ada lamaran masuk, lamaran belum berstatus final."),
                ("Post-condition", "Progress tersimpan, status lamaran ter-update otomatis jika semua tahap selesai."),
                ("Trigger", "Employer membuka halaman progress pelamar."),
            ],
            "main": [
                "Employer membuka daftar pelamar pada sebuah lowongan.",
                "Employer memilih pelamar dan menekan \"Lihat Progress\".",
                "Sistem menampilkan semua tahap seleksi. Hanya current step yang bisa diedit.",
                "Employer mengisi hasil tahap aktif: lulus atau tidak lulus, disertai catatan.",
                "Employer submit form.",
                "Sistem menyimpan progress.",
                "Sistem menjalankan syncStatusFromProgress(): jika gagal -> rejected; jika semua lulus -> accepted; jika belum selesai -> pending.",
                "Sistem mengirimkan notifikasi ke jobseeker.",
            ],
            "alt": [
                "3a. Lamaran sudah final: sistem menampilkan progress sebagai read-only.",
                "5a. Employer mengisi tahap bukan current step: sistem menolak dengan pesan error.",
            ],
        },
        {
            "id": "UC-06", "title": "Mendaftarkan Lowongan ke Job Fair",
            "fields": [
                ("Aktor", "Employer"),
                ("Deskripsi", "Employer mendaftarkan lowongan ke job fair yang sedang aktif."),
                ("Pre-condition", "Employer terverifikasi, job fair berstatus \"active\" dan belum dimulai."),
                ("Post-condition", "Pendaftaran tersimpan (status: pending), notifikasi terkirim ke admin."),
                ("Trigger", "Employer membuka detail job fair dan menekan \"Daftarkan Lowongan\"."),
            ],
            "main": [
                "Employer melihat daftar job fair aktif.",
                "Employer membuka detail job fair.",
                "Employer memilih lowongan dari daftar miliknya.",
                "Employer menekan tombol \"Daftar\".",
                "Sistem memeriksa: active, belum dimulai, kuota tersedia, belum terdaftar.",
                "Sistem menyimpan pendaftaran (status: pending).",
                "Sistem mengirimkan notifikasi ke semua admin.",
                "Sistem menampilkan pesan \"Menunggu persetujuan admin\".",
            ],
            "alt": [
                "5a. Tanggal mulai sudah lewat: pesan error \"Pendaftaran sudah ditutup\".",
                "5b. Kuota penuh: pesan error \"Kuota job fair sudah penuh\".",
                "5c. Lowongan sudah terdaftar: pesan error \"Lowongan sudah terdaftar\".",
            ],
        },
        {
            "id": "UC-07", "title": "Mengelola Profil & Download CV",
            "fields": [
                ("Aktor", "Jobseeker"),
                ("Deskripsi", "Jobseeker mengelola data profil dan mengunduh CV otomatis dalam format PDF."),
                ("Pre-condition", "Jobseeker sudah login."),
                ("Post-condition", "Data profil tersimpan / file PDF terunduh."),
                ("Trigger", "Jobseeker membuka halaman profil."),
            ],
            "main": [
                "Jobseeker membuka halaman \"Edit Profil\".",
                "Sistem menampilkan form: informasi pribadi, riwayat pendidikan, bahasa, riwayat kerja, organisasi, prestasi, pelatihan, rekomendasi.",
                "Jobseeker mengubah/menambah/menghapus data.",
                "Jobseeker menekan \"Simpan\".",
                "Sistem menyimpan seluruh perubahan.",
                "Redirect ke halaman profil dengan pesan sukses.",
            ],
            "alt": [
                "1a. Download CV: Jobseeker menekan \"Download CV PDF\", sistem men-generate file PDF dari data profil menggunakan DomPDF, browser mengunduh file.",
            ],
        },
        {
            "id": "UC-08", "title": "Mengelola Job Fair (Admin)",
            "fields": [
                ("Aktor", "Admin"),
                ("Deskripsi", "Admin membuat, mengedit, menghapus job fair dan mengelola peserta."),
                ("Pre-condition", "Admin sudah login."),
                ("Post-condition", "Data job fair tersimpan, status peserta ter-update."),
                ("Trigger", "Admin membuka halaman kelola job fair."),
            ],
            "main": [
                "Admin menekan \"Buat Job Fair Baru\".",
                "Admin mengisi: nama, deskripsi, lokasi, tanggal mulai/selesai, status, kuota.",
                "Admin submit form.",
                "Sistem memvalidasi (tanggal selesai >= mulai, kuota >= 1 jika diisi).",
                "Job fair tersimpan.",
            ],
            "alt": [
                "Kelola Peserta: Admin buka detail job fair -> lihat daftar pendaftaran -> Approve/Reject -> notifikasi ke employer.",
            ],
        },
        {
            "id": "UC-09", "title": "Mengelola Lowongan (Admin)",
            "fields": [
                ("Aktor", "Admin"),
                ("Deskripsi", "Admin melihat, mencari, menghapus, dan memulihkan lowongan dari seluruh employer."),
                ("Pre-condition", "Admin sudah login."),
                ("Post-condition", "Data lowongan ter-update sesuai aksi."),
                ("Trigger", "Admin membuka halaman \"Kelola Lowongan\"."),
            ],
            "main": [
                "Sistem menampilkan daftar lowongan dari semua employer.",
                "Admin memfilter berdasarkan tab (Semua / Active / Closed / Terhapus).",
                "Admin mencari berdasarkan nama, posisi, atau nama perusahaan.",
                "Admin menekan \"Hapus\" pada lowongan.",
                "Sistem memeriksa: jika ada lamaran pending, tolak.",
                "Jika tidak ada pending: lowongan di-soft-delete.",
                "Admin dapat menekan \"Pulihkan\" pada tab Terhapus.",
            ],
            "alt": [
                "4a. Masih ada lamaran pending: pesan error, hapus ditolak.",
            ],
        },
        {
            "id": "UC-10", "title": "Melihat Lowongan di Job Fair (Jobseeker)",
            "fields": [
                ("Aktor", "Jobseeker"),
                ("Deskripsi", "Jobseeker melihat lowongan yang tersedia di job fair."),
                ("Pre-condition", "Jobseeker sudah login, job fair berstatus \"active\"."),
                ("Post-condition", "-"),
                ("Trigger", "Jobseeker membuka halaman job fair."),
            ],
            "main": [
                "Jobseeker melihat daftar job fair aktif.",
                "Jobseeker memilih job fair.",
                "Sistem menampilkan lowongan yang sudah approved dan masih active.",
                "Jobseeker dapat melamar lowongan langsung (mengikuti alur UC-04).",
            ],
            "alt": [],
        },
    ]

    for uc in use_cases:
        heading(doc, f"{uc['id']}: {uc['title']}", level=2)
        add_use_case_table(doc, uc["fields"])
        doc.add_paragraph()

        para(doc, "Skenario Utama:", bold=True, size=10)
        for i, step in enumerate(uc["main"], 1):
            numbered(doc, f"{step}")

        if uc["alt"]:
            doc.add_paragraph()
            para(doc, "Skenario Alternatif:", bold=True, size=10)
            for alt in uc["alt"]:
                bullet(doc, alt)

        doc.add_paragraph()

    doc.add_page_break()

    # ── Lampiran: Matriks Aktor ──
    heading(doc, "Lampiran: Matriks Aktor vs Modul", level=1)

    matrix_rows = [
        ["Autentikasi & Registrasi",    "-", "-", "-", "v", "-"],
        ["Verifikasi Employer",          "v", "v", "-", "-", "v"],
        ["Kelola Lowongan",              "v", "v", "-", "-", "v"],
        ["Lamaran & Pipeline Seleksi",   "-", "v", "v", "-", "v"],
        ["Job Fair",                     "v", "v", "v", "-", "v"],
        ["Profil & CV Jobseeker",        "-", "-", "v", "-", "v"],
        ["Profil Employer",              "-", "v", "-", "-", "v"],
        ["Dashboard",                    "v", "v", "v", "-", "-"],
        ["Notifikasi",                   "v", "v", "v", "-", "v"],
        ["Landing Page & Publik",        "-", "-", "-", "v", "-"],
        ["Data Master",                  "v", "-", "-", "-", "-"],
        ["User & Security",              "v", "-", "-", "-", "-"],
        ["Konten & Email",               "v", "-", "-", "-", "-"],
    ]

    make_table(doc,
        ["Modul", "Admin", "Employer", "Jobseeker", "Guest", "Sistem"],
        matrix_rows,
        col_widths=[5, 2, 2.5, 2.5, 2, 2.5]
    )

    # Save
    path = os.path.join(DOCS_DIR, "Kebutuhan-Fungsional.docx")
    doc.save(path)
    print(f"  -> {path}")
    return path


# ═════════════════════════════════════════════════════════════════════════

if __name__ == "__main__":
    print("Generating Word documents...")
    build_persiapan_sidang()
    build_kebutuhan_fungsional()
    print("Done!")
