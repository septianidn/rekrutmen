<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\JobFair;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class JobFairController extends Controller
{
    public function index()
    {
        $jobFairs = JobFair::latest()->get();
        return view('backoffice.job-fair.index', compact('jobFairs'));
    }

    public function create()
    {
        return view('backoffice.job-fair.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'lokasi' => 'required|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,active,completed',
            'kuota' => 'nullable|integer|min:1',
        ]);

        JobFair::create($request->only(['nama', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'status', 'kuota']));

        return redirect()->route('backoffice.job-fair.index')->with('success', 'Job Fair berhasil dibuat.');
    }

    public function show(JobFair $jobFair)
    {
        $jobFair->load(['jobs.employer']);
        return view('backoffice.job-fair.show', compact('jobFair'));
    }

    public function edit(JobFair $jobFair)
    {
        return view('backoffice.job-fair.edit', compact('jobFair'));
    }

    public function update(Request $request, JobFair $jobFair)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'lokasi' => 'required|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,active,completed',
        ]);

        $jobFair->update($request->only(['nama', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'status', 'kuota']));

        return redirect()->route('backoffice.job-fair.index')->with('success', 'Job Fair berhasil diperbarui.');
    }

    public function destroy(JobFair $jobFair)
    {
        $jobFair->delete();
        return redirect()->route('backoffice.job-fair.index')->with('success', 'Job Fair berhasil dihapus.');
    }

    public function updateParticipant(Request $request, JobFair $jobFair, $pivotId)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);

        $pivot = \DB::table('job_fair_job')->where('id', $pivotId)->first();
        \DB::table('job_fair_job')->where('id', $pivotId)->update(['status' => $request->status]);

        // Notify employer
        if ($pivot && $request->status !== 'pending') {
            $employer = Employer::with('user')->find($pivot->employer_id);
            if ($employer && $employer->user) {
                $label = $request->status === 'approved' ? 'disetujui' : 'ditolak';
                NotificationService::send(
                    $employer->user->id,
                    'job_fair_status',
                    "Job Fair: Pendaftaran {$label}",
                    "Pendaftaran lowongan Anda di {$jobFair->nama} telah {$label}.",
                    route('employer.job-fair.show', $jobFair)
                );
            }
        }

        return back()->with('success', 'Status peserta diperbarui.');
    }
}
