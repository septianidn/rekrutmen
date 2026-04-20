<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\JobFair;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobFairController extends Controller
{
    // Employer: list active job fairs
    public function employerIndex()
    {
        $jobFairs = JobFair::where('status', 'active')->latest()->get();
        $employer = Auth::user()->employer;

        // Get already registered job_ids per fair
        $registeredMap = DB::table('job_fair_job')
            ->where('employer_id', $employer->id)
            ->get()
            ->groupBy('job_fair_id');

        return view('frontoffice.employer.job-fair.index', compact('jobFairs', 'employer', 'registeredMap'));
    }

    // Employer: show a fair's detail + register form
    public function employerShow(JobFair $jobFair)
    {
        $employer = Auth::user()->employer;
        $jobs = $employer->jobs;

        $registeredJobIds = DB::table('job_fair_job')
            ->where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->pluck('job_id')
            ->toArray();

        $registrations = DB::table('job_fair_job')
            ->join('job', 'job_fair_job.job_id', '=', 'job.id')
            ->where('job_fair_job.job_fair_id', $jobFair->id)
            ->where('job_fair_job.employer_id', $employer->id)
            ->select('job_fair_job.*', 'job.nama_pekerjaan')
            ->get();

        return view('frontoffice.employer.job-fair.show', compact('jobFair', 'jobs', 'registeredJobIds', 'registrations'));
    }

    // Employer: register a job to a fair
    public function employerRegister(Request $request, JobFair $jobFair)
    {
        $request->validate(['job_id' => 'required|exists:job,id']);

        $employer = Auth::user()->employer;
        $job = $employer->jobs()->findOrFail($request->job_id);

        if (!$jobFair->isActive()) {
            return back()->with('error', 'Job fair ini belum dibuka atau sudah berakhir.');
        }

        if (!$jobFair->tanggal_mulai->isFuture()) {
            return back()->with('error', 'Pendaftaran sudah ditutup: job fair telah dimulai.');
        }

        if ($jobFair->jobs()->wherePivot('job_id', $job->id)->exists()) {
            return back()->with('error', 'Lowongan ini sudah terdaftar di job fair ini.');
        }

        if (!$jobFair->hasCapacity()) {
            return back()->with('error', 'Kuota job fair sudah penuh.');
        }

        $jobFair->jobs()->attach($job->id, [
            'employer_id' => $employer->id,
            'status' => 'pending',
        ]);

        // Notify all admins
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin->id,
                'job_fair_registration',
                'Pendaftaran Job Fair Baru',
                "{$employer->nama_perusahaan} mendaftarkan lowongan {$job->nama_pekerjaan} ke {$jobFair->nama}.",
                route('backoffice.job-fair.show', $jobFair)
            );
        }

        return back()->with('success', 'Lowongan berhasil didaftarkan. Menunggu persetujuan admin.');
    }

    // Employer: cancel registration
    public function employerCancel(JobFair $jobFair, $jobId)
    {
        $employer = Auth::user()->employer;

        $jobFair->jobs()
            ->wherePivot('employer_id', $employer->id)
            ->wherePivot('job_id', $jobId)
            ->detach($jobId);

        return back()->with('success', 'Pendaftaran dibatalkan.');
    }

    // Student: list active job fairs
    public function studentIndex()
    {
        $jobFairs = JobFair::where('status', 'active')->latest()->get();
        return view('frontoffice.jobseeker.job-fair.index', compact('jobFairs'));
    }

    // Student: view fair details with approved jobs
    public function studentShow(JobFair $jobFair)
    {
        $jobs = $jobFair->jobs()
            ->wherePivot('status', 'approved')
            ->where('job.status', 'active')
            ->with('employer')
            ->get();

        $appliedJobIds = [];
        $jobseeker = Auth::user()->jobseeker;
        if ($jobseeker) {
            $appliedJobIds = $jobseeker->applications()->pluck('job_id')->toArray();
        }

        return view('frontoffice.jobseeker.job-fair.show', compact('jobFair', 'jobs', 'appliedJobIds'));
    }
}
