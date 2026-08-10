<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobseekerStoreRequest;
use App\Http\Requests\JobseekerUpdateRequest;
use App\Models\Application;
use App\Models\Bahasa;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\Jobseeker;
use App\Models\JobseekerType;
use App\Models\Organisasi;
use App\Models\Pelatihan;
use App\Models\Prestasi;
use App\Models\Rekomendasi;
use App\Models\RiwayatKerja;
use App\Models\RiwayatPendidikan;
use App\Models\Prodi;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class JobseekerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        // Profile completeness
        // Mandatory items marked with (wajib)
        $profileItems = [];
        if ($jobseeker) {
            $profileItems = [
                ['label' => 'Nama Lengkap', 'filled' => $user->first_name && $user->first_name !== '-', 'required' => false],
                ['label' => 'No. Telepon', 'filled' => (bool) $user->phone_number, 'required' => false],
                ['label' => 'Alamat', 'filled' => (bool) $user->street_addr, 'required' => false],
                ['label' => 'Jenis Kelamin', 'filled' => $jobseeker->jenis_kelamin && $jobseeker->jenis_kelamin !== '-', 'required' => false],
                ['label' => 'Riwayat Pendidikan', 'filled' => $jobseeker->riwayatPendidikans()->exists(), 'required' => true],
                ['label' => 'Bahasa', 'filled' => $jobseeker->bahasas()->exists(), 'required' => true],
                ['label' => 'Riwayat Kerja', 'filled' => $jobseeker->riwayatKerjas()->exists(), 'required' => false],
                ['label' => 'Organisasi', 'filled' => $jobseeker->organisasis()->exists(), 'required' => false],
                ['label' => 'Prestasi', 'filled' => $jobseeker->prestasis()->exists(), 'required' => false],
                ['label' => 'Pelatihan', 'filled' => $jobseeker->pelatihans()->exists(), 'required' => false],
                ['label' => 'Rekomendasi', 'filled' => $jobseeker->rekomendasis()->exists(), 'required' => false],
            ];
        }
        $profileTotal = count($profileItems);
        $profileScore = collect($profileItems)->where('filled', true)->count();
        $profilePercent = $profileTotal > 0 ? round(($profileScore / $profileTotal) * 100) : 0;
        $mandatoryComplete = collect($profileItems)->where('required', true)->every('filled', true);

        // Application stats
        $stats = [
            'total' => 0,
            'pending' => 0,
            'accepted' => 0,
            'rejected' => 0,
        ];
        if ($jobseeker) {
            $applications = Application::where('jobseeker_id', $jobseeker->id);
            $stats['total'] = (clone $applications)->count();
            $stats['pending'] = (clone $applications)->where('status', 'pending')->count();
            $stats['accepted'] = (clone $applications)->where('status', 'accepted')->count();
            $stats['rejected'] = (clone $applications)->where('status', 'rejected')->count();
        }

        // Latest jobs
        $latestJobs = Job::open()->with('employer')->latest()->take(6)->get();

        // Applied job IDs (to show badge on latest jobs)
        $appliedJobIds = [];
        if ($jobseeker) {
            $appliedJobIds = Application::where('jobseeker_id', $jobseeker->id)
                ->pluck('job_id')
                ->toArray();
        }

        return view('frontoffice.jobseeker.index', compact(
            'user', 'jobseeker', 'profilePercent', 'profileScore', 'profileTotal',
            'profileItems', 'mandatoryComplete', 'stats', 'latestJobs', 'appliedJobIds'
        ));
    }

    public function create(Request $request): Response
    {
        return view('jobseeker.create');
    }

    public function store(JobseekerStoreRequest $request): Response
    {
        $jobseeker = Jobseeker::create($request->validated());

        $request->session()->flash('jobseeker.id', $jobseeker->id);

        return redirect()->route('jobseeker.index');
    }

    public function show(Request $request, Jobseeker $jobseeker): Response
    {
        return view('jobseeker.show', compact('jobseeker'));
    }

    public function edit(Request $request, Jobseeker $jobseeker): Response
    {
        return view('jobseeker.edit', compact('jobseeker'));
    }

    public function update(JobseekerUpdateRequest $request, Jobseeker $jobseeker): Response
    {
        $jobseeker->update($request->validated());

        $request->session()->flash('jobseeker.id', $jobseeker->id);

        return redirect()->route('jobseeker.index');
    }

    public function destroy(Request $request, Jobseeker $jobseeker): Response
    {
        $jobseeker->delete();

        return redirect()->route('jobseeker.index');
    }

    public function profile(){
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        if ($jobseeker) {
            $jobseeker->load([
                'riwayatPendidikans',
                'riwayatKerjas',
                'prestasis',
                'organisasis',
                'pelatihans',
                'bahasas',
                'rekomendasis',
                'jobseekerType',
            ]);
        }

        return view('frontoffice.jobseeker.profile', compact('user', 'jobseeker'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        if (!$jobseeker) {
            $jobseeker = Jobseeker::create([
                'user_id' => $user->id,
                'first_name' => $user->first_name ?? '-',
                'last_name' => $user->last_name ?? '-',
                'jenis_kelamin' => '-',
                'ttl' => now()->toDateString(),
                'jobseeker_type_id' => 1,
            ]);
        }

        $jobseeker->load([
            'riwayatPendidikans', 'riwayatKerjas', 'prestasis',
            'organisasis', 'pelatihans', 'bahasas', 'rekomendasis',
        ]);

        $jobseekerTypes = JobseekerType::all();

        return view('frontoffice.jobseeker.edit-profile', compact('user', 'jobseeker', 'jobseekerTypes'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        $fileRule = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'];

        // ===== Validasi =====
        // WAJIB   : data pribadi, Riwayat Pendidikan, Bahasa.
        // OPSIONAL: Organisasi, Pengalaman Kerja, Prestasi, Pelatihan, Referensi
        //           (dianjurkan, divalidasi hanya bila diisi). Dokumen bukti opsional.
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'ttl'           => ['required', 'date'],

            // Wajib
            'pendidikan'                => ['required', 'array', 'min:1'],
            'pendidikan.*.jenjang_id'   => ['required', 'integer', 'exists:jenjang,jenjang_id'],
            'pendidikan.*.instansi'     => ['required', 'string', 'max:50'],
            'pendidikan.*.indeks_nilai' => ['required', 'string', 'max:4'],
            'pendidikan.*.keterangan'   => ['required', 'string'],
            'pendidikan.*.dokumen'      => $fileRule,
            'pendidikan.*.kode_prodi_id'=> ['nullable', 'string'],
            'pendidikan.*.prodi_lain'   => ['nullable', 'string', 'max:100'],

            'bahasa'              => ['required', 'array', 'min:1'],
            'bahasa.*.bahasa'     => ['required', 'string', 'max:20'],
            'bahasa.*.keterangan' => ['required', 'string'],
            'bahasa.*.dokumen'    => $fileRule,

            // Opsional (dianjurkan) — divalidasi hanya jika diisi
            'kerja.*.keterangan'           => ['nullable', 'string'],
            'kerja.*.dokumen'              => $fileRule,
            'organisasi.*.nama_organisasi' => ['nullable', 'string', 'max:30'],
            'organisasi.*.jabatan'         => ['nullable', 'string', 'max:20'],
            'organisasi.*.keterangan'      => ['nullable', 'string'],
            'organisasi.*.dokumen'         => $fileRule,
            'prestasi.*.nama_penghargaan'  => ['nullable', 'string', 'max:40'],
            'prestasi.*.tahun'             => ['nullable', 'string', 'max:4'],
            'prestasi.*.dokumen'           => $fileRule,
        ], [
            'jenis_kelamin.in'       => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'ttl.required'           => 'Tanggal lahir wajib diisi.',
            'pendidikan.required'    => 'Riwayat pendidikan wajib diisi minimal 1 data.',
            'pendidikan.min'         => 'Riwayat pendidikan wajib diisi minimal 1 data.',
            'bahasa.required'        => 'Bahasa wajib diisi minimal 1 data.',
            'bahasa.min'             => 'Bahasa wajib diisi minimal 1 data.',
        ]);

        // File baru diunggah -> disimpan; jika tidak, pertahankan file lama.
        $resolveDokumen = function (array $row, string $sec, $i) use ($request) {
            $file = $request->file("$sec.$i.dokumen");
            $row['dokumen'] = $file
                ? $file->store("jobseeker/$sec", 'public')
                : ($row['dokumen_lama'] ?? null);
            unset($row['dokumen_lama']);
            return $row;
        };

        // Update user contact info
        $user->update($request->only(['first_name', 'last_name', 'phone_number', 'street_addr']));

        // Update jobseeker personal info
        $jobseeker->update($request->only(['first_name', 'last_name', 'jenis_kelamin', 'ttl']));

        // Sync riwayat pendidikan
        $jobseeker->riwayatPendidikans()->delete();
        foreach ((array) $request->input('pendidikan', []) as $i => $edu) {
            if (empty($edu['instansi'])) continue;
            // Prodi: FK ke master hanya untuk prodi Unand yang valid; selain itu (non-Unand/kosong) simpan teks.
            $kode = $edu['kode_prodi_id'] ?? null;
            $edu['kode_prodi_id'] = (is_numeric($kode) && Prodi::whereKey((int) $kode)->exists()) ? (int) $kode : null;
            $edu['prodi_lain'] = $edu['kode_prodi_id'] ? null : (trim((string) ($edu['prodi_lain'] ?? '')) ?: null);
            $jobseeker->riwayatPendidikans()->create($resolveDokumen($edu, 'pendidikan', $i));
        }

        // Sync riwayat kerja
        $jobseeker->riwayatKerjas()->delete();
        foreach ((array) $request->input('kerja', []) as $i => $work) {
            if (empty($work['keterangan'])) continue;
            $jobseeker->riwayatKerjas()->create($resolveDokumen($work, 'kerja', $i));
        }

        // Sync organisasi
        $jobseeker->organisasis()->delete();
        foreach ((array) $request->input('organisasi', []) as $i => $org) {
            if (empty($org['nama_organisasi'])) continue;
            $jobseeker->organisasis()->create($resolveDokumen($org, 'organisasi', $i));
        }

        // Sync prestasi
        $jobseeker->prestasis()->delete();
        foreach ((array) $request->input('prestasi', []) as $i => $award) {
            if (empty($award['nama_penghargaan'])) continue;
            $jobseeker->prestasis()->create($resolveDokumen($award, 'prestasi', $i));
        }

        // Sync bahasa
        $jobseeker->bahasas()->delete();
        foreach ((array) $request->input('bahasa', []) as $i => $lang) {
            if (empty($lang['bahasa'])) continue;
            $jobseeker->bahasas()->create($resolveDokumen($lang, 'bahasa', $i));
        }

        // Sync pelatihan (opsional)
        $jobseeker->pelatihans()->delete();
        foreach ((array) $request->input('pelatihan', []) as $training) {
            if (!empty($training['nama_pelatihan'])) {
                $jobseeker->pelatihans()->create($training);
            }
        }

        // Sync rekomendasi (opsional)
        $jobseeker->rekomendasis()->delete();
        foreach ((array) $request->input('rekomendasi', []) as $ref) {
            if (!empty($ref['nama_perekomendasi'])) {
                $jobseeker->rekomendasis()->create($ref);
            }
        }

        return redirect()->route('jobseeker.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function joblist(){
        // Lowongan ditutup tetap ditampilkan (setelah yang aktif); lamaran diblokir di UI dan server.
        $jobs = Job::orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(3);
        $appliedJobIds = [];

        if (Auth::user()->jobseeker) {
            $appliedJobIds = Application::where('jobseeker_id', Auth::user()->jobseeker->id)
                ->pluck('job_id')
                ->toArray();
        }

        return view('frontoffice.jobseeker.job-list', compact('jobs', 'appliedJobIds'));
    }

    public function jobDetail(Job $job)
    {
        $job->load(['employer', 'steps.proses']);

        $applied = false;
        if (Auth::user()->jobseeker) {
            $applied = Application::where('jobseeker_id', Auth::user()->jobseeker->id)
                ->where('job_id', $job->id)
                ->exists();
        }

        return view('frontoffice.jobseeker.job-detail', compact('job', 'applied'));
    }

    public function applyJob(Job $job)
    {
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        if (!$job->isOpen()) {
            return back()->with('error', 'Lowongan ini sudah ditutup dan tidak menerima lamaran baru.');
        }

        // Profile must exist
        if (!$jobseeker) {
            return back()->with('error', 'Anda harus melengkapi profil terlebih dahulu sebelum melamar.')
                         ->with('redirect_profile', route('jobseeker.profile.edit'));
        }

        // Mandatory: riwayat pendidikan & bahasa
        $missing = [];
        if (!$jobseeker->riwayatPendidikans()->exists()) {
            $missing[] = 'Riwayat Pendidikan';
        }
        if (!$jobseeker->bahasas()->exists()) {
            $missing[] = 'Bahasa';
        }

        if (!empty($missing)) {
            $fields = implode(' dan ', $missing);
            return back()->with('error', "Anda harus melengkapi {$fields} di profil sebelum melamar pekerjaan.")
                         ->with('redirect_profile', route('jobseeker.profile.edit'));
        }

        $existing = Application::where('jobseeker_id', $jobseeker->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        Application::create([
            'jobseeker_id' => $jobseeker->id,
            'job_id' => $job->id,
            'tanggal_apply' => now()->toDateString(),
            'status' => 'pending',
        ]);

        // Notify employer
        $job->load('employer.user');
        if ($job->employer && $job->employer->user) {
            NotificationService::send(
                $job->employer->user->id,
                'new_applicant',
                'Pelamar Baru',
                "{$user->first_name} {$user->last_name} melamar posisi {$job->nama_pekerjaan}.",
                route('employer.job.applicants', $job->id)
            );
        }

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }

    public function downloadCvPdf()
    {
        $user = Auth::user();
        $jobseeker = $user->jobseeker;

        if (!$jobseeker) {
            return back()->with('error', 'Profil belum lengkap.');
        }

        $jobseeker->load([
            'riwayatPendidikans', 'riwayatKerjas', 'prestasis',
            'organisasis', 'pelatihans', 'bahasas', 'rekomendasis',
        ]);

        $pdf = Pdf::loadView('frontoffice.jobseeker.cv-pdf', compact('user', 'jobseeker'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'CV_' . str_replace(' ', '_', $user->first_name . '_' . $user->last_name) . '.pdf';

        return $pdf->download($filename);
    }

    public function myApplications()
    {
        $jobseeker = Auth::user()->jobseeker;
        $applications = collect();

        if ($jobseeker) {
            $applications = Application::where('jobseeker_id', $jobseeker->id)
                ->with(['job.employer', 'job.steps.proses', 'progress'])
                ->latest()
                ->get();
        }

        return view('frontoffice.jobseeker.my-applications', compact('applications'));
    }

    public function applicationProgress(Application $application)
    {
        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker || $application->jobseeker_id !== $jobseeker->id) {
            abort(403);
        }

        $application->load(['job.employer', 'job.steps.proses', 'progress']);
        $progressMap = $application->progressByStep();
        $currentStep = $application->currentStep();

        return view('frontoffice.jobseeker.application-progress', compact(
            'application', 'progressMap', 'currentStep'
        ));
    }
}
