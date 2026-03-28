<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndustriTypeStoreRequest;
use App\Http\Requests\IndustriTypeUpdateRequest;
use App\Models\IndustriType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndustriTypeController extends Controller
{
    public function index(Request $request): Response
    {
        $industriTypes = IndustriType::all();

        return view('industriType.index', compact('industriTypes'));
    }

    public function create(Request $request): Response
    {
        return view('industriType.create');
    }

    public function store(IndustriTypeStoreRequest $request): Response
    {
        $industriType = IndustriType::create($request->validated());

        $request->session()->flash('industriType.id', $industriType->id);

        return redirect()->route('industriType.index');
    }

    public function show(Request $request, IndustriType $industriType): Response
    {
        return view('industriType.show', compact('industriType'));
    }

    public function edit(Request $request, IndustriType $industriType): Response
    {
        return view('industriType.edit', compact('industriType'));
    }

    public function update(IndustriTypeUpdateRequest $request, IndustriType $industriType): Response
    {
        $industriType->update($request->validated());

        $request->session()->flash('industriType.id', $industriType->id);

        return redirect()->route('industriType.index');
    }

    public function destroy(Request $request, IndustriType $industriType): Response
    {
        $industriType->delete();

        return redirect()->route('industriType.index');
    }
}
