<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerStoreRequest;
use App\Models\Application;
use App\Models\Employer;
use App\Models\EmployerChangeRequest;
use App\Models\IndustriType;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\User;
use App\Services\NotificationService;
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
        $pendingRequest = $employer && $employer->isVerified()
            ? $employer->pendingChangeRequest()
            : null;

        return view('frontoffice.employer.profile.edit', compact(
            'assets', 'employer', 'user', 'industriTypes', 'pendingRequest'
        ));
    }

    public function update(Request $request)
    {
        $rules = [
            'nama_perusahaan'      => 'required|string|max:50',
            'deskripsi_perusahaan' => 'required|string',
            'industriType_id'      => 'required|exists:industri_type,id',
            'alamat_perusahaan'    => 'nullable|string|max:150',
            'telp_perusahaan'      => 'nullable|string|max:20',
            'website'              => 'nullable|string|max:255',
            'logo'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen_legalitas'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ];

        $user     = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        if ($employer && $employer->isVerified()) {
            return $this->updateVerified($request, $employer, $rules);
        }

        $request->validate($rules);

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

    protected function updateVerified(Request $request, Employer $employer, array $rules): RedirectResponse
    {
        if ($employer->pendingChangeRequest()) {
            return redirect()->route('employer.profile.edit')
                ->with('error', 'Anda sudah memiliki permintaan perubahan yang sedang ditinjau. Tunggu keputusan admin sebelum mengajukan perubahan baru.');
        }

        $proposedGated = [];

        if ($request->filled('nama_perusahaan') && $request->nama_perusahaan !== $employer->nama_perusahaan) {
            $proposedGated['nama_perusahaan'] = $request->nama_perusahaan;
        }
        if ($request->filled('alamat_perusahaan') && $request->alamat_perusahaan !== $employer->alamat_perusahaan) {
            $proposedGated['alamat_perusahaan'] = $request->alamat_perusahaan;
        }
        $hasGatedFile = $request->hasFile('logo') || $request->hasFile('dokumen_legalitas');

        $rules['reason'] = (!empty($proposedGated) || $hasGatedFile)
            ? 'required|string|max:1000'
            : 'nullable|string|max:1000';

        $request->validate($rules);

        $employer->update($request->only([
            'deskripsi_perusahaan', 'industriType_id', 'telp_perusahaan', 'website',
        ]));

        if (empty($proposedGated) && !$hasGatedFile) {
            return redirect()->route('employer.profile')
                ->with('success', 'Profil berhasil diperbarui.');
        }

        if ($request->hasFile('logo')) {
            $proposedGated['logo'] = $request->file('logo')->store('change-requests/logos', 'public');
        }
        if ($request->hasFile('dokumen_legalitas')) {
            $proposedGated['dokumen_legalitas'] = $request->file('dokumen_legalitas')
                ->store('change-requests/dokumen-legalitas');
        }

        $changeRequest = EmployerChangeRequest::create([
            'employer_id' => $employer->id,
            'payload'     => $proposedGated,
            'reason'      => $request->input('reason'),
            'status'      => EmployerChangeRequest::STATUS_PENDING,
        ]);

        $admins = User::role('admin')->pluck('id');
        foreach ($admins as $adminId) {
            NotificationService::send(
                $adminId,
                'employer_change_request',
                'Permintaan Perubahan Profil Employer',
                "{$employer->nama_perusahaan} mengajukan perubahan profil yang memerlukan persetujuan.",
                route('backoffice.employer-change-request.show', $changeRequest)
            );
        }

        return redirect()->route('employer.profile')
            ->with('success', 'Permintaan perubahan profil dikirim ke admin. Profil saat ini tetap aktif sampai keputusan diterima.');
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
