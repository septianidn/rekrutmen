<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembayaranStoreRequest;
use App\Http\Requests\PembayaranUpdateRequest;
use App\Models\Pembayaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index(Request $request): Response
    {
        $pembayarans = Pembayaran::all();

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create(Request $request): Response
    {
        return view('pembayaran.create');
    }

    public function store(PembayaranStoreRequest $request): Response
    {
        $pembayaran = Pembayaran::create($request->validated());

        $request->session()->flash('pembayaran.id', $pembayaran->id);

        return redirect()->route('pembayaran.index');
    }

    public function show(Request $request, Pembayaran $pembayaran): Response
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Request $request, Pembayaran $pembayaran): Response
    {
        return view('pembayaran.edit', compact('pembayaran'));
    }

    public function update(PembayaranUpdateRequest $request, Pembayaran $pembayaran): Response
    {
        $pembayaran->update($request->validated());

        $request->session()->flash('pembayaran.id', $pembayaran->id);

        return redirect()->route('pembayaran.index');
    }

    public function destroy(Request $request, Pembayaran $pembayaran): Response
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index');
    }
}
