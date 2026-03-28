<?php

namespace App\Http\Controllers;

use App\Http\Requests\RiwayatKerjaStoreRequest;
use App\Http\Requests\RiwayatKerjaUpdateRequest;
use App\Models\RiwayatKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatKerjaController extends Controller
{
    public function index(Request $request): Response
    {
        $riwayatKerjas = RiwayatKerja::all();

        return view('riwayatKerja.index', compact('riwayatKerjas'));
    }

    public function create(Request $request): Response
    {
        return view('riwayatKerja.create');
    }

    public function store(RiwayatKerjaStoreRequest $request): Response
    {
        $riwayatKerja = RiwayatKerja::create($request->validated());

        $request->session()->flash('riwayatKerja.id', $riwayatKerja->id);

        return redirect()->route('riwayatKerja.index');
    }

    public function show(Request $request, RiwayatKerja $riwayatKerja): Response
    {
        return view('riwayatKerja.show', compact('riwayatKerja'));
    }

    public function edit(Request $request, RiwayatKerja $riwayatKerja): Response
    {
        return view('riwayatKerja.edit', compact('riwayatKerja'));
    }

    public function update(RiwayatKerjaUpdateRequest $request, RiwayatKerja $riwayatKerja): Response
    {
        $riwayatKerja->update($request->validated());

        $request->session()->flash('riwayatKerja.id', $riwayatKerja->id);

        return redirect()->route('riwayatKerja.index');
    }

    public function destroy(Request $request, RiwayatKerja $riwayatKerja): Response
    {
        $riwayatKerja->delete();

        return redirect()->route('riwayatKerja.index');
    }
}
