<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobseekerStoreRequest;
use App\Http\Requests\JobseekerUpdateRequest;
use App\Models\Application;
use App\Models\Bahasa;
use App\Models\Job;
use App\Models\Jobseeker;
use App\Models\JobseekerType;
use App\Models\Organisasi;
use App\Models\Pelatihan;
use App\Models\Prestasi;
use App\Models\Rekomendasi;
use App\Models\RiwayatKerja;
use App\Models\RiwayatPendidikan;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobseekerController extends Controller
{
    public function index(Request $request)
    {
        
        $jobseekers = Jobseeker::all();

        return view('frontoffice.jobseeker.index', compact('jobseekers'));
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

        // Update user contact info
        $user->update($request->only(['first_name', 'last_name', 'phone_number', 'street_addr']));

        // Update jobseeker personal info
        $jobseeker->update($request->only(['first_name', 'last_name', 'jenis_kelamin', 'ttl', 'jobseeker_type_id']));

        // Sync riwayat pendidikan
        $jobseeker->riwayatPendidikans()->delete();
        foreach ($request->input('pendidikan', []) as $edu) {
            if (!empty($edu['instansi'])) {
                $jobseeker->riwayatPendidikans()->create($edu);
            }
        }

        // Sync riwayat kerja
        $jobseeker->riwayatKerjas()->delete();
        foreach ($request->input('kerja', []) as $work) {
            if (!empty($work['keterangan'])) {
                $jobseeker->riwayatKerjas()->create($work);
            }
        }

        // Sync organisasi
        $jobseeker->organisasis()->delete();
        foreach ($request->input('organisasi', []) as $org) {
            if (!empty($org['nama_organisasi'])) {
                $jobseeker->organisasis()->create($org);
            }
        }

        // Sync prestasi
        $jobseeker->prestasis()->delete();
        foreach ($request->input('prestasi', []) as $award) {
            if (!empty($award['nama_penghargaan'])) {
                $jobseeker->prestasis()->create($award);
            }
        }

        // Sync pelatihan
        $jobseeker->pelatihans()->delete();
        foreach ($request->input('pelatihan', []) as $training) {
            if (!empty($training['nama_pelatihan'])) {
                $jobseeker->pelatihans()->create($training);
            }
        }

        // Sync bahasa
        $jobseeker->bahasas()->delete();
        foreach ($request->input('bahasa', []) as $lang) {
            if (!empty($lang['bahasa'])) {
                $jobseeker->bahasas()->create($lang);
            }
        }

        // Sync rekomendasi
        $jobseeker->rekomendasis()->delete();
        foreach ($request->input('rekomendasi', []) as $ref) {
            if (!empty($ref['nama_perekomendasi'])) {
                $jobseeker->rekomendasis()->create($ref);
            }
        }

        return redirect()->route('jobseeker.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function joblist(){
        $jobs = Job::paginate(3);
        $appliedJobIds = [];

        if (Auth::user()->jobseeker) {
            $appliedJobIds = Application::where('jobseeker_id', Auth::user()->jobseeker->id)
                ->pluck('job_id')
                ->toArray();
        }

        return view('frontoffice.jobseeker.job-list', compact('jobs', 'appliedJobIds'));
    }

    public function applyJob(Job $job)
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
                ->with('job.employer')
                ->latest()
                ->get();
        }

        return view('frontoffice.jobseeker.my-applications', compact('applications'));
    }
}
