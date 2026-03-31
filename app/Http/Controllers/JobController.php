<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Employer;
use Illuminate\View\View;
use App\Models\IndustriType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
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
//dd($employer);

        return view('frontoffice.employer.job.create', compact('employer'));
    }

    public function store(JobStoreRequest $request)
    {
        $request->validated();
        $job = Job::create(
            [
            'employer_id' => $request->employer_id,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'alamat' => $request->alamat,
            'posisi' => $request->posisi,
            'requirement' => $request->requirement,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'ekspektasi_gaji' => $request->ekspektasi_gaji,
            'worktime' => $request->worktime,
            'application_deadline' => $request->application_deadline,
            ]
        );

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('employer.job.index');
    }

    public function show(Job $job)
    {
        $jobs = Job::findOrFail($job->id);
        return view('frontoffice.employer.job.show', compact('jobs'));
    }

    public function edit( Job $job)
    {
        $jobs = Job::findOrFail($job->id);
        return view('frontoffice.employer.job.edit', compact('jobs'));
    }

    public function update(JobUpdateRequest $request, Job $job)
    {
        $job->update($request->validated());

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('employer.job.index');
    }

    public function destroy(Request $request, Job $job)
    {
        $job->delete();

        return redirect()->route('employer.job.index');
    }
}
