<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProsesStoreRequest;
use App\Http\Requests\ProsesUpdateRequest;
use App\Models\Proses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProsesController extends Controller
{
    public function index(Request $request): Response
    {
        $proses = Prose::all();

        return view('prose.index', compact('proses'));
    }

    public function create(Request $request): Response
    {
        return view('prose.create');
    }

    public function store(ProsesStoreRequest $request): Response
    {
        $prose = Prose::create($request->validated());

        $request->session()->flash('prose.id', $prose->id);

        return redirect()->route('prose.index');
    }

    public function show(Request $request, Prose $prose): Response
    {
        return view('prose.show', compact('prose'));
    }

    public function edit(Request $request, Prose $prose): Response
    {
        return view('prose.edit', compact('prose'));
    }

    public function update(ProsesUpdateRequest $request, Prose $prose): Response
    {
        $prose->update($request->validated());

        $request->session()->flash('prose.id', $prose->id);

        return redirect()->route('prose.index');
    }

    public function destroy(Request $request, Prose $prose): Response
    {
        $prose->delete();

        return redirect()->route('prose.index');
    }
}
