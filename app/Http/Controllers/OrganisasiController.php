<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganisasiStoreRequest;
use App\Http\Requests\OrganisasiUpdateRequest;
use App\Models\Organisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganisasiController extends Controller
{
    public function index(Request $request): Response
    {
        $organisasis = Organisasi::all();

        return view('organisasi.index', compact('organisasis'));
    }

    public function create(Request $request): Response
    {
        return view('organisasi.create');
    }

    public function store(OrganisasiStoreRequest $request): Response
    {
        $organisasi = Organisasi::create($request->validated());

        $request->session()->flash('organisasi.id', $organisasi->id);

        return redirect()->route('organisasi.index');
    }

    public function show(Request $request, Organisasi $organisasi): Response
    {
        return view('organisasi.show', compact('organisasi'));
    }

    public function edit(Request $request, Organisasi $organisasi): Response
    {
        return view('organisasi.edit', compact('organisasi'));
    }

    public function update(OrganisasiUpdateRequest $request, Organisasi $organisasi): Response
    {
        $organisasi->update($request->validated());

        $request->session()->flash('organisasi.id', $organisasi->id);

        return redirect()->route('organisasi.index');
    }

    public function destroy(Request $request, Organisasi $organisasi): Response
    {
        $organisasi->delete();

        return redirect()->route('organisasi.index');
    }
}
