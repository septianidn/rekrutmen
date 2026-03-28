<?php

namespace App\Http\Controllers;

use App\Http\Requests\StepStoreRequest;
use App\Http\Requests\StepUpdateRequest;
use App\Models\Step;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StepController extends Controller
{
    public function index(Request $request): Response
    {
        $steps = Step::all();

        return view('step.index', compact('steps'));
    }

    public function create(Request $request): Response
    {
        return view('step.create');
    }

    public function store(StepStoreRequest $request): Response
    {
        $step = Step::create($request->validated());

        $request->session()->flash('step.id', $step->id);

        return redirect()->route('step.index');
    }

    public function show(Request $request, Step $step): Response
    {
        return view('step.show', compact('step'));
    }

    public function edit(Request $request, Step $step): Response
    {
        return view('step.edit', compact('step'));
    }

    public function update(StepUpdateRequest $request, Step $step): Response
    {
        $step->update($request->validated());

        $request->session()->flash('step.id', $step->id);

        return redirect()->route('step.index');
    }

    public function destroy(Request $request, Step $step): Response
    {
        $step->delete();

        return redirect()->route('step.index');
    }
}
