<?php

namespace App\Http\Controllers;

use App\Http\Requests\RiwayatPendidikanStoreRequest;
use App\Http\Requests\RiwayatPendidikanUpdateRequest;
use App\Models\RiwayatPendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatPendidikanController extends Controller
{
    public function index(Request $request): Response
    {
        $riwayatPendidikans = RiwayatPendidikan::all();

        return view('riwayatPendidikan.index', compact('riwayatPendidikans'));
    }

    public function create(Request $request): Response
    {
        return view('riwayatPendidikan.create');
    }

    public function store(RiwayatPendidikanStoreRequest $request): Response
    {
        $riwayatPendidikan = RiwayatPendidikan::create($request->validated());

        $request->session()->flash('riwayatPendidikan.id', $riwayatPendidikan->id);

        return redirect()->route('riwayatPendidikan.index');
    }

    public function show(Request $request, RiwayatPendidikan $riwayatPendidikan): Response
    {
        return view('riwayatPendidikan.show', compact('riwayatPendidikan'));
    }

    public function edit(Request $request, RiwayatPendidikan $riwayatPendidikan): Response
    {
        return view('riwayatPendidikan.edit', compact('riwayatPendidikan'));
    }

    public function update(RiwayatPendidikanUpdateRequest $request, RiwayatPendidikan $riwayatPendidikan): Response
    {
        $riwayatPendidikan->update($request->validated());

        $request->session()->flash('riwayatPendidikan.id', $riwayatPendidikan->id);

        return redirect()->route('riwayatPendidikan.index');
    }

    public function destroy(Request $request, RiwayatPendidikan $riwayatPendidikan): Response
    {
        $riwayatPendidikan->delete();

        return redirect()->route('riwayatPendidikan.index');
    }
}
