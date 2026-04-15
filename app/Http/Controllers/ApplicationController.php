<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\Jobseeker;
use App\Models\Progress;
use App\Models\Step;
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

    /**
     * Employer screen to review & update an applicant's step progress.
     */
    public function progress(Application $application)
    {
        $employer = Auth::user()->employer;

        if ($application->job->employer_id !== $employer->id) {
            abort(403);
        }

        $application->load([
            'jobseeker.user',
            'job.steps.proses',
            'progress',
        ]);

        $progressMap = $application->progressByStep();

        return view('frontoffice.employer.job.progress', [
            'application' => $application,
            'progressMap' => $progressMap,
        ]);
    }

    /**
     * Create/update a Progress entry for a specific step.
     *
     * Enforces the pipeline state machine:
     *   - application must not be finalized (status still pending)
     *   - only the current (next unpassed) step may be updated
     */
    public function updateProgress(Request $request, Application $application, Step $step)
    {
        $employer = Auth::user()->employer;

        if ($application->job->employer_id !== $employer->id) {
            abort(403);
        }

        if ($step->job_id !== $application->job_id) {
            abort(404);
        }

        $application->load('job.steps');

        if ($application->isFinalized()) {
            return back()->with('error', 'Lamaran sudah final (' . $application->status . '). Tahap tidak dapat diubah.');
        }

        if (!$application->isStepEditable($step)) {
            return back()->with('error', 'Tahap seleksi harus diisi berurutan. Selesaikan tahap sebelumnya terlebih dahulu.');
        }

        $data = $request->validate([
            'lulus' => ['required', 'in:0,1'],
            'catatan' => ['nullable', 'string'],
        ]);

        Progress::updateOrCreate(
            [
                'application_id' => $application->id,
                'step_id' => $step->id,
            ],
            [
                'lulus' => (bool) $data['lulus'],
                'catatan' => $data['catatan'] ?? '',
            ]
        );

        $application->refresh()->load('job.steps', 'progress');
        $application->syncStatusFromProgress();
        $application->refresh();

        $application->load('jobseeker.user', 'job');
        $studentUser = $application->jobseeker->user ?? null;
        if ($studentUser) {
            $prosesName = $step->proses->nama_proses ?? 'Tahap seleksi';
            $status = $data['lulus'] ? 'lulus' : 'tidak lulus';

            if ($application->status === 'accepted') {
                NotificationService::send(
                    $studentUser->id,
                    'application_accepted',
                    'Selamat! Lamaran Diterima',
                    "Anda telah lulus seluruh tahap seleksi untuk posisi {$application->job->nama_pekerjaan}.",
                    route('jobseeker.my-applications')
                );
            } elseif ($application->status === 'rejected') {
                NotificationService::send(
                    $studentUser->id,
                    'application_rejected',
                    'Lamaran Ditolak',
                    "Anda tidak lulus pada tahap {$prosesName} untuk posisi {$application->job->nama_pekerjaan}.",
                    route('jobseeker.my-applications')
                );
            } else {
                NotificationService::send(
                    $studentUser->id,
                    'application_progress',
                    'Update Tahap Seleksi',
                    "Anda {$status} pada tahap {$prosesName} untuk posisi {$application->job->nama_pekerjaan}.",
                    route('jobseeker.my-applications')
                );
            }
        }

        return back()->with('success', 'Progress tahap berhasil diperbarui.');
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
