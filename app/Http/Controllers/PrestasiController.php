<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrestasiStoreRequest;
use App\Http\Requests\PrestasiUpdateRequest;
use App\Models\Prestasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    public function index(Request $request): Response
    {
        $prestasis = Prestasi::all();

        return view('prestasi.index', compact('prestasis'));
    }

    public function create(Request $request): Response
    {
        return view('prestasi.create');
    }

    public function store(PrestasiStoreRequest $request): Response
    {
        $prestasi = Prestasi::create($request->validated());

        $request->session()->flash('prestasi.id', $prestasi->id);

        return redirect()->route('prestasi.index');
    }

    public function show(Request $request, Prestasi $prestasi): Response
    {
        return view('prestasi.show', compact('prestasi'));
    }

    public function edit(Request $request, Prestasi $prestasi): Response
    {
        return view('prestasi.edit', compact('prestasi'));
    }

    public function update(PrestasiUpdateRequest $request, Prestasi $prestasi): Response
    {
        $prestasi->update($request->validated());

        $request->session()->flash('prestasi.id', $prestasi->id);

        return redirect()->route('prestasi.index');
    }

    public function destroy(Request $request, Prestasi $prestasi): Response
    {
        $prestasi->delete();

        return redirect()->route('prestasi.index');
    }
}
