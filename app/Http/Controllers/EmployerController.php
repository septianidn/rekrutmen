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
use Illuminate\View\View;

class EmployerController extends Controller
{
    

    public function home()
    {
        $user = Auth::user();
        $employer = $user->employer;

        // Job stats
        $totalJobs = Job::where('employer_id', $employer->id)->count();
        $activeJobs = Job::where('employer_id', $employer->id)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            })->count();

        // Application stats
        $jobIds = Job::where('employer_id', $employer->id)->pluck('id');
        $stats = [
            'total' => Application::whereIn('job_id', $jobIds)->count(),
            'pending' => Application::whereIn('job_id', $jobIds)->where('status', 'pending')->count(),
            'accepted' => Application::whereIn('job_id', $jobIds)->where('status', 'accepted')->count(),
            'rejected' => Application::whereIn('job_id', $jobIds)->where('status', 'rejected')->count(),
        ];

        // Recent applications
        $recentApplications = Application::whereIn('job_id', $jobIds)
            ->with(['job', 'jobseeker.user'])
            ->latest()
            ->take(5)
            ->get();

        // Active job fairs
        $activeJobFairs = JobFair::where('status', 'active')
            ->where('tanggal_selesai', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        // Company profile completeness
        $profileItems = [
            ['label' => 'Nama Perusahaan', 'filled' => (bool) $employer->nama_perusahaan],
            ['label' => 'Deskripsi Perusahaan', 'filled' => (bool) $employer->deskripsi_perusahaan],
            ['label' => 'Tipe Industri', 'filled' => (bool) $employer->industriType_id],
            ['label' => 'Alamat', 'filled' => (bool) $employer->alamat_perusahaan],
            ['label' => 'Telepon', 'filled' => (bool) $employer->telp_perusahaan],
            ['label' => 'Website', 'filled' => (bool) $employer->website],
        ];
        $profileScore = collect($profileItems)->where('filled', true)->count();
        $profileTotal = count($profileItems);
        $profilePercent = $profileTotal > 0 ? round(($profileScore / $profileTotal) * 100) : 0;

        return view('frontoffice.employer.home', compact(
            'user', 'employer', 'totalJobs', 'activeJobs',
            'stats', 'recentApplications', 'activeJobFairs',
            'profileItems', 'profileScore', 'profileTotal', 'profilePercent'
        ));
    }

    public function index()
    {
        $assets = ['vanilla-counter', 'glightbox', 'animation','wow'];

        $user = Auth::user();
        $employer = Employer::with('industriType', 'media')->where('user_id', $user->id)->first();

        return view('frontoffice.employer.profile.profile', compact('assets', 'employer'));
    }

    public function verifikasi(){
        $assets = ['vanilla-counter', 'glightbox', 'animation','wow'];
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        $industriTypes = IndustriType::all();

        if ($employer && $employer->isVerified()) {
            return redirect()->route('employer.index');
        }

        return view('frontoffice.employer.verifikasi', compact('assets', 'user', 'employer', 'industriTypes'));
    }

    public function create(Request $request): Response
    {
        return view('employer.create');
    }

    public function store(EmployerStoreRequest $request)
    {
        $request->validated();

        $user = Auth::user();

        $existing = Employer::where('user_id', $user->id)->first();
        if ($existing && $existing->verification_status !== 'rejected') {
            return redirect()->route('employer.cek_verifikasi');
        }

        $data = [
            'user_id' => $user->id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'deskripsi_perusahaan' => $request->deskripsi_perusahaan,
            'industriType_id' => $request->id_industri_type,
            'alamat_perusahaan' => $request->alamat,
            'telp_perusahaan' => $request->telp,
            'website' => $request->website,
            'verification_status' => 'pending',
            'verification_note' => null,
            'verified_at' => null,
            'verified_by' => null,
        ];

        if ($existing) {
            $existing->update($data);
            $employer = $existing;
        } else {
            $employer = Employer::create($data);
        }

        if ($request->hasFile('logo')) {
            $employer->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('employer.cek_verifikasi')
            ->with('success', 'Data perusahaan berhasil dikirim. Mohon menunggu verifikasi admin.');
    }

    public function show(Request $request, Employer $employer): Response
    {
        return view('employer.show', compact('employer'));
    }

    public function edit()
    {
        $assets = ['vanilla-counter', 'glightbox', 'animation', 'wow'];
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        $industriTypes = IndustriType::all();

        return view('frontoffice.employer.profile.edit', compact('assets', 'employer', 'user', 'industriTypes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:50',
            'deskripsi_perusahaan' => 'required|string',
            'industriType_id' => 'required|exists:industri_type,id',
            'alamat_perusahaan' => 'nullable|string|max:150',
            'telp_perusahaan' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        $employer->update($request->only([
            'nama_perusahaan',
            'deskripsi_perusahaan',
            'industriType_id',
            'alamat_perusahaan',
            'telp_perusahaan',
            'website',
        ]));

        if ($request->hasFile('logo')) {
            $employer->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('employer.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request, Employer $employer): Response
    {
        $employer->delete();

        return redirect()->route('employer.index');
    }
}
