<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgressStoreRequest;
use App\Http\Requests\ProgressUpdateRequest;
use App\Models\Progress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Request $request): Response
    {
        $progress = Progress::all();

        return view('progress.index', compact('progress'));
    }

    public function create(Request $request): Response
    {
        return view('progress.create');
    }

    public function store(ProgressStoreRequest $request): Response
    {
        $progress = Progress::create($request->validated());

        $request->session()->flash('progress.id', $progress->id);

        return redirect()->route('progress.index');
    }

    public function show(Request $request, Progress $progress): Response
    {
        return view('progress.show', compact('progress'));
    }

    public function edit(Request $request, Progress $progress): Response
    {
        return view('progress.edit', compact('progress'));
    }

    public function update(ProgressUpdateRequest $request, Progress $progress): Response
    {
        $progress->update($request->validated());

        $request->session()->flash('progress.id', $progress->id);

        return redirect()->route('progress.index');
    }

    public function destroy(Request $request, Progress $progress): Response
    {
        $progress->delete();

        return redirect()->route('progress.index');
    }
}
