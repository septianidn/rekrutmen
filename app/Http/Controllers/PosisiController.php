<?php

namespace App\Http\Controllers;

use App\DataTables\PosisiDataTable;
use App\Helpers\AuthHelper;
use App\Http\Requests\PosisiStoreRequest;
use App\Http\Requests\PosisiUpdateRequest;
use App\Models\Posisi;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    /**
     * Daftar posisi (master) dengan DataTables — mengikuti pola datamaster
     * (jenjang/prodi): tabel server-side + form tambah/edit lewat modal.
     */
    public function index(PosisiDataTable $dataTable)
    {
        $pageTitle = 'Data Posisi';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('backoffice.posisi.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Posisi" data-placement="top" title="Tambah Data">Tambah Data Posisi</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function create(Request $request)
    {
        $view = view('backoffice.datamaster.posisi.form')->render();

        return response()->json(['data' => $view, 'status' => true]);
    }

    public function store(PosisiStoreRequest $request)
    {
        Posisi::create($request->validated());

        return redirect()->route('backoffice.posisi.index')
            ->withSuccess('Data posisi berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = Posisi::findOrFail($id);
        $view = view('backoffice.datamaster.posisi.form', compact('request', 'data', 'id'))->render();

        return response()->json(['data' => $view, 'status' => true]);
    }

    public function update(PosisiUpdateRequest $request, $id)
    {
        $posisi = Posisi::findOrFail($id);
        $posisi->fill($request->validated())->update();

        return redirect()->route('backoffice.posisi.index')
            ->withSuccess('Data posisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $posisi = Posisi::findOrFail($id);
        $message = 'Data posisi berhasil dihapus.';
        $posisi->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with('success', $message);
    }
}
