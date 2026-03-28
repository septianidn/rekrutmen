<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobseekerTypeStoreRequest;
use App\Http\Requests\JobseekerTypeUpdateRequest;
use App\Models\JobseekerType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobseekerTypeController extends Controller
{
    public function index(Request $request): Response
    {
        $jobseekerTypes = JobseekerType::all();

        return view('jobseekerType.index', compact('jobseekerTypes'));
    }

    public function create(Request $request): Response
    {
        return view('jobseekerType.create');
    }

    public function store(JobseekerTypeStoreRequest $request): Response
    {
        $jobseekerType = JobseekerType::create($request->validated());

        $request->session()->flash('jobseekerType.id', $jobseekerType->id);

        return redirect()->route('jobseekerType.index');
    }

    public function show(Request $request, JobseekerType $jobseekerType): Response
    {
        return view('jobseekerType.show', compact('jobseekerType'));
    }

    public function edit(Request $request, JobseekerType $jobseekerType): Response
    {
        return view('jobseekerType.edit', compact('jobseekerType'));
    }

    public function update(JobseekerTypeUpdateRequest $request, JobseekerType $jobseekerType): Response
    {
        $jobseekerType->update($request->validated());

        $request->session()->flash('jobseekerType.id', $jobseekerType->id);

        return redirect()->route('jobseekerType.index');
    }

    public function destroy(Request $request, JobseekerType $jobseekerType): Response
    {
        $jobseekerType->delete();

        return redirect()->route('jobseekerType.index');
    }
}
