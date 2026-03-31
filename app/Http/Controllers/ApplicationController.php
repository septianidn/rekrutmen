<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\Jobseeker;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function applicants(Job $job)
    {
        $employer = Auth::user()->employer;

        if ($job->employer_id !== $employer->id) {
            abort(403);
        }

        $applications = Application::where('job_id', $job->id)
            ->with('jobseeker.user')
            ->latest()
            ->get();

        return view('frontoffice.employer.job.applicants', compact('job', 'applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $employer = Auth::user()->employer;

        if ($application->job->employer_id !== $employer->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        $statusLabel = match ($request->status) {
            'accepted' => 'diterima',
            'rejected' => 'ditolak',
            'pending' => 'pending',
        };

        // Notify student
        if ($request->status !== 'pending') {
            $application->load('jobseeker.user', 'job');
            $studentUser = $application->jobseeker->user;
            if ($studentUser) {
                $icon = $request->status === 'accepted' ? 'Selamat!' : 'Mohon Maaf';
                NotificationService::send(
                    $studentUser->id,
                    'application_status',
                    "{$icon} Lamaran {$statusLabel}",
                    "Lamaran Anda untuk posisi {$application->job->nama_pekerjaan} telah {$statusLabel}.",
                    route('jobseeker.my-applications')
                );
            }
        }

        return back()->with('success', "Pelamar berhasil di-{$statusLabel}.");
    }

    public function viewCv(Jobseeker $jobseeker)
    {
        $employer = Auth::user()->employer;

        // Verify this jobseeker has applied to one of this employer's jobs
        $hasApplied = Application::where('jobseeker_id', $jobseeker->id)
            ->whereHas('job', fn($q) => $q->where('employer_id', $employer->id))
            ->exists();

        if (!$hasApplied) {
            abort(403);
        }

        $jobseeker->load([
            'user', 'riwayatPendidikans', 'riwayatKerjas', 'prestasis',
            'organisasis', 'pelatihans', 'bahasas', 'rekomendasis', 'jobseekerType',
        ]);

        $user = $jobseeker->user;

        return view('frontoffice.employer.job.view-cv', compact('user', 'jobseeker'));
    }

    public function downloadCv(Jobseeker $jobseeker)
    {
        $employer = Auth::user()->employer;

        $hasApplied = Application::where('jobseeker_id', $jobseeker->id)
            ->whereHas('job', fn($q) => $q->where('employer_id', $employer->id))
            ->exists();

        if (!$hasApplied) {
            abort(403);
        }

        $jobseeker->load([
            'user', 'riwayatPendidikans', 'riwayatKerjas', 'prestasis',
            'organisasis', 'pelatihans', 'bahasas', 'rekomendasis',
        ]);

        $user = $jobseeker->user;

        $pdf = Pdf::loadView('frontoffice.jobseeker.cv-pdf', compact('user', 'jobseeker'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'CV_' . str_replace(' ', '_', $user->first_name . '_' . $user->last_name) . '.pdf';

        return $pdf->download($filename);
    }
}
