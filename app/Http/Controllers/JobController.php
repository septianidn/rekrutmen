<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Employer;
use App\Models\Proses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::where('employer_id', Auth::user()->employer->id)
            ->withCount('applications')
            ->get();

        return view('frontoffice.employer.job.index', compact('jobs'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        $prosesList = Proses::orderBy('id')->get();

        return view('frontoffice.employer.job.create', compact('employer', 'prosesList'));
    }

    public function store(JobStoreRequest $request)
    {
        $data = $request->validated();

        $job = Job::create([
            'employer_id' => $data['employer_id'],
            'nama_pekerjaan' => $data['nama_pekerjaan'],
            'alamat' => $data['alamat'],
            'posisi' => $data['posisi'],
            'requirement' => $data['requirement'],
            'deskripsi_pekerjaan' => $data['deskripsi_pekerjaan'],
            'ekspektasi_gaji' => $data['ekspektasi_gaji'],
            'worktime' => $data['worktime'],
            'application_deadline' => $data['application_deadline'],
        ]);

        $this->syncSteps($job, $request);

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('employer.job.index')
            ->with('success', 'Lowongan berhasil dibuat beserta tahap seleksinya.');
    }

    public function show(Job $job)
    {
        $this->authorizeJob($job);

        $job->load(['steps.proses', 'employer']);

        return view('frontoffice.employer.job.show', ['jobs' => $job]);
    }

    public function edit(Job $job)
    {
        $this->authorizeJob($job);

        $job->load('steps.proses');
        $prosesList = Proses::orderBy('id')->get();

        return view('frontoffice.employer.job.edit', [
            'jobs' => $job,
            'prosesList' => $prosesList,
        ]);
    }

    public function update(JobUpdateRequest $request, Job $job)
    {
        $this->authorizeJob($job);

        $job->update($request->safe()->except('steps'));

        $this->syncSteps($job, $request);

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('employer.job.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Request $request, Job $job)
    {
        $this->authorizeJob($job);

        $job->delete();

        return redirect()->route('employer.job.index');
    }

    /**
     * Sync the recruitment steps attached to a job.
     *
     * Expects repeating fields from the form:
     *   steps[0][proses_id], steps[0][deskripsi]
     *   steps[1][proses_id], steps[1][deskripsi]
     *   ...
     * Order in the submitted array defines `urutan`.
     *
     * Note: we only re-sync when the job has no existing progress records.
     * If any applicant has already started moving through the pipeline we
     * preserve the existing steps to avoid breaking their progress.
     */
    protected function syncSteps(Job $job, Request $request): void
    {
        $steps = collect($request->input('steps', []))
            ->filter(fn ($s) => !empty($s['proses_id']))
            ->values();

        if ($steps->isEmpty()) {
            return;
        }

        // If any applicant already has progress on this job, don't wipe steps.
        $hasProgress = \App\Models\Progress::whereHas('step', fn ($q) => $q->where('job_id', $job->id))->exists();
        if ($hasProgress) {
            return;
        }

        $job->steps()->delete();

        foreach ($steps as $i => $step) {
            $job->steps()->create([
                'proses_id' => (int) $step['proses_id'],
                'urutan' => $i + 1,
                'deskripsi' => $step['deskripsi'] ?? '',
            ]);
        }
    }

    protected function authorizeJob(Job $job): void
    {
        $employer = Auth::user()->employer;
        if (!$employer || $job->employer_id !== $employer->id) {
            abort(403);
        }
    }
}
