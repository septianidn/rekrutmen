<?php

namespace App\Http\Controllers;

use App\Http\Requests\RekomendasiStoreRequest;
use App\Http\Requests\RekomendasiUpdateRequest;
use App\Models\Rekomendasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    public function index(Request $request): Response
    {
        $rekomendasis = Rekomendasi::all();

        return view('rekomendasi.index', compact('rekomendasis'));
    }

    public function create(Request $request): Response
    {
        return view('rekomendasi.create');
    }

    public function store(RekomendasiStoreRequest $request): Response
    {
        $rekomendasi = Rekomendasi::create($request->validated());

        $request->session()->flash('rekomendasi.id', $rekomendasi->id);

        return redirect()->route('rekomendasi.index');
    }

    public function show(Request $request, Rekomendasi $rekomendasi): Response
    {
        return view('rekomendasi.show', compact('rekomendasi'));
    }

    public function edit(Request $request, Rekomendasi $rekomendasi): Response
    {
        return view('rekomendasi.edit', compact('rekomendasi'));
    }

    public function update(RekomendasiUpdateRequest $request, Rekomendasi $rekomendasi): Response
    {
        $rekomendasi->update($request->validated());

        $request->session()->flash('rekomendasi.id', $rekomendasi->id);

        return redirect()->route('rekomendasi.index');
    }

    public function destroy(Request $request, Rekomendasi $rekomendasi): Response
    {
        $rekomendasi->delete();

        return redirect()->route('rekomendasi.index');
    }
}
