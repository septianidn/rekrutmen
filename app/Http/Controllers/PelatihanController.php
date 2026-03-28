<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelatihanStoreRequest;
use App\Http\Requests\PelatihanUpdateRequest;
use App\Models\Pelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelatihanController extends Controller
{
    public function index(Request $request): Response
    {
        $pelatihans = Pelatihan::all();

        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(Request $request): Response
    {
        return view('pelatihan.create');
    }

    public function store(PelatihanStoreRequest $request): Response
    {
        $pelatihan = Pelatihan::create($request->validated());

        $request->session()->flash('pelatihan.id', $pelatihan->id);

        return redirect()->route('pelatihan.index');
    }

    public function show(Request $request, Pelatihan $pelatihan): Response
    {
        return view('pelatihan.show', compact('pelatihan'));
    }

    public function edit(Request $request, Pelatihan $pelatihan): Response
    {
        return view('pelatihan.edit', compact('pelatihan'));
    }

    public function update(PelatihanUpdateRequest $request, Pelatihan $pelatihan): Response
    {
        $pelatihan->update($request->validated());

        $request->session()->flash('pelatihan.id', $pelatihan->id);

        return redirect()->route('pelatihan.index');
    }

    public function destroy(Request $request, Pelatihan $pelatihan): Response
    {
        $pelatihan->delete();

        return redirect()->route('pelatihan.index');
    }
}
