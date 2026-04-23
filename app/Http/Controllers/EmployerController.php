<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerStoreRequest;
use App\Models\Application;
use App\Models\Employer;
use App\Models\IndustriType;
use App\Models\Job;
use App\Models\JobFair;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $employer = $user->employer;

        $totalJobs = Job::where('employer_id', $employer->id)->count();
        $activeJobs = Job::where('employer_id', $employer->id)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            })->count();

        $jobIds = Job::where('employer_id', $employer->id)->pluck('id');
        $stats = [
            'total'    => Application::whereIn('job_id', $jobIds)->count(),
            'pending'  => Application::whereIn('job_id', $jobIds)->where('status', 'pending')->count(),
            'accepted' => Application::whereIn('job_id', $jobIds)->where('status', 'accepted')->count(),
            'rejected' => Application::whereIn('job_id', $jobIds)->where('status', 'rejected')->count(),
        ];

        $recentApplications = Application::whereIn('job_id', $jobIds)
            ->with(['job', 'jobseeker.user'])
            ->latest()
            ->take(5)
            ->get();

        $activeJobFairs = JobFair::where('status', 'active')
            ->where('tanggal_selesai', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        $profileItems = [
            ['label' => 'Nama Perusahaan',    'filled' => (bool) $employer->nama_perusahaan],
            ['label' => 'Deskripsi Perusahaan','filled' => (bool) $employer->deskripsi_perusahaan],
            ['label' => 'Tipe Industri',       'filled' => (bool) $employer->industriType_id],
            ['label' => 'Alamat',              'filled' => (bool) $employer->alamat_perusahaan],
            ['label' => 'Telepon',             'filled' => (bool) $employer->telp_perusahaan],
            ['label' => 'Website',             'filled' => (bool) $employer->website],
        ];
        $profileScore   = collect($profileItems)->where('filled', true)->count();
        $profileTotal   = count($profileItems);
        $profilePercent = $profileTotal > 0 ? round(($profileScore / $profileTotal) * 100) : 0;

        return view('frontoffice.employer.home', compact(
            'user', 'employer', 'totalJobs', 'activeJobs',
            'stats', 'recentApplications', 'activeJobFairs',
            'profileItems', 'profileScore', 'profileTotal', 'profilePercent'
        ));
    }

    public function index()
    {
        $assets   = ['vanilla-counter', 'glightbox', 'animation', 'wow'];
        $user     = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        return view('frontoffice.employer.profile.profile', compact('assets', 'employer'));
    }

    public function verifikasi()
    {
        $assets        = ['vanilla-counter', 'glightbox', 'animation', 'wow'];
        $user          = Auth::user();
        $employer      = Employer::where('user_id', $user->id)->first();
        $industriTypes = IndustriType::all();

        if ($employer && $employer->isVerified()) {
            return redirect()->route('employer.index');
        }

        return view('frontoffice.employer.verifikasi', compact('assets', 'user', 'employer', 'industriTypes'));
    }

    public function store(EmployerStoreRequest $request)
    {
        $request->validated();

        $user     = Auth::user();
        $existing = Employer::where('user_id', $user->id)->first();

        if ($existing && $existing->verification_status !== 'rejected') {
            return redirect()->route('employer.cek_verifikasi');
        }

        $data = [
            'user_id'              => $user->id,
            'nama_perusahaan'      => $request->nama_perusahaan,
            'deskripsi_perusahaan' => $request->deskripsi_perusahaan,
            'industriType_id'      => $request->id_industri_type,
            'alamat_perusahaan'    => $request->alamat,
            'telp_perusahaan'      => $request->telp,
            'website'              => $request->website,
            'verification_status'  => 'pending',
            'verification_note'    => null,
            'verified_at'          => null,
            'verified_by'          => null,
        ];

        if ($request->hasFile('logo')) {
            if ($existing && $existing->logo) {
                Storage::disk('public')->delete($existing->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('dokumen_legalitas')) {
            if ($existing && $existing->dokumen_legalitas) {
                Storage::delete($existing->dokumen_legalitas);
            }
            $data['dokumen_legalitas'] = $request->file('dokumen_legalitas')->store('dokumen-legalitas');
        }

        if ($existing) {
            $existing->update($data);
        } else {
            Employer::create($data);
        }

        return redirect()->route('employer.cek_verifikasi')
            ->with('success', 'Data perusahaan berhasil dikirim. Mohon menunggu verifikasi admin.');
    }

    public function edit()
    {
        $assets        = ['vanilla-counter', 'glightbox', 'animation', 'wow'];
        $user          = Auth::user();
        $employer      = Employer::where('user_id', $user->id)->first();
        $industriTypes = IndustriType::all();

        return view('frontoffice.employer.profile.edit', compact('assets', 'employer', 'user', 'industriTypes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan'      => 'required|string|max:50',
            'deskripsi_perusahaan' => 'required|string',
            'industriType_id'      => 'required|exists:industri_type,id',
            'alamat_perusahaan'    => 'nullable|string|max:150',
            'telp_perusahaan'      => 'nullable|string|max:20',
            'website'              => 'nullable|string|max:255',
            'logo'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen_legalitas'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $user     = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        $employer->update($request->only([
            'nama_perusahaan', 'deskripsi_perusahaan', 'industriType_id',
            'alamat_perusahaan', 'telp_perusahaan', 'website',
        ]));

        if ($request->hasFile('logo')) {
            if ($employer->logo) {
                Storage::disk('public')->delete($employer->logo);
            }
            $employer->update(['logo' => $request->file('logo')->store('logos', 'public')]);
        }

        if ($request->hasFile('dokumen_legalitas')) {
            if ($employer->dokumen_legalitas) {
                Storage::delete($employer->dokumen_legalitas);
            }
            $employer->update([
                'dokumen_legalitas' => $request->file('dokumen_legalitas')->store('dokumen-legalitas'),
            ]);
        }

        return redirect()->route('employer.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function serveDocument()
    {
        $employer = Auth::user()->employer;

        if (!$employer || !$employer->dokumen_legalitas) {
            abort(404);
        }

        return Storage::download($employer->dokumen_legalitas, basename($employer->dokumen_legalitas));
    }
}
