<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosisiStoreRequest;
use App\Http\Requests\PosisiUpdateRequest;
use App\Models\Posisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosisiController extends Controller
{
    public function index(Request $request): Response
    {
        $posisis = Posisi::all();

        return view('posisi.index', compact('posisis'));
    }

    public function create(Request $request): Response
    {
        return view('posisi.create');
    }

    public function store(PosisiStoreRequest $request): Response
    {
        $posisi = Posisi::create($request->validated());

        $request->session()->flash('posisi.id', $posisi->id);

        return redirect()->route('posisi.index');
    }

    public function show(Request $request, Posisi $posisi): Response
    {
        return view('posisi.show', compact('posisi'));
    }

    public function edit(Request $request, Posisi $posisi): Response
    {
        return view('posisi.edit', compact('posisi'));
    }

    public function update(PosisiUpdateRequest $request, Posisi $posisi): Response
    {
        $posisi->update($request->validated());

        $request->session()->flash('posisi.id', $posisi->id);

        return redirect()->route('posisi.index');
    }

    public function destroy(Request $request, Posisi $posisi): Response
    {
        $posisi->delete();

        return redirect()->route('posisi.index');
    }
}
