<?php

namespace App\Http\Controllers;

use App\Http\Requests\BahasaStoreRequest;
use App\Http\Requests\BahasaUpdateRequest;
use App\Models\Bahasa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BahasaController extends Controller
{
    public function index(Request $request): Response
    {
        $bahasas = Bahasa::all();

        return view('bahasa.index', compact('bahasas'));
    }

    public function create(Request $request): Response
    {
        return view('bahasa.create');
    }

    public function store(BahasaStoreRequest $request): Response
    {
        $bahasa = Bahasa::create($request->validated());

        $request->session()->flash('bahasa.id', $bahasa->id);

        return redirect()->route('bahasa.index');
    }

    public function show(Request $request, Bahasa $bahasa): Response
    {
        return view('bahasa.show', compact('bahasa'));
    }

    public function edit(Request $request, Bahasa $bahasa): Response
    {
        return view('bahasa.edit', compact('bahasa'));
    }

    public function update(BahasaUpdateRequest $request, Bahasa $bahasa): Response
    {
        $bahasa->update($request->validated());

        $request->session()->flash('bahasa.id', $bahasa->id);

        return redirect()->route('bahasa.index');
    }

    public function destroy(Request $request, Bahasa $bahasa): Response
    {
        $bahasa->delete();

        return redirect()->route('bahasa.index');
    }
}
