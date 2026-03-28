<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobseekerStoreRequest;
use App\Http\Requests\JobseekerUpdateRequest;
use App\Models\Job;
use App\Models\Jobseeker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view('frontoffice.jobseeker.profile');
    }

    public function joblist(){

        $jobs = Job::paginate(3);
        

        return view('frontoffice.jobseeker.job-list', compact('jobs'));
    }
}
