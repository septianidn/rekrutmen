<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\KategoriKontenDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\KategoriKontenRequest;
use App\Models\KategoriKonten;

class KategoriKontenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KategoriKontenDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('kategorikonten.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
    
        $headerAction = '<a data--href="' . route('backoffice.kategori-konten.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Kategori Konten</a>';

        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    public function create(Request $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.konten.kategorikonten.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriKontenRequest $request)
    {        
       
    
       $kategorikonten = KategoriKonten::create($request->all());

       return redirect()->route('backoffice.kategori-konten.index')->withSuccess(__('message.kategorikonten_msg_added',['name' => __('kategori-konten.store')]));
    }

    public function edit(Request $request, $id)
    {
       
        $data = KategoriKonten::find($id);
        $view = view('backoffice.konten.kategorikonten.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KategoriKontenRequest $request, $id)
    {
        // dd($request->all());
        $kategorikonten = KategoriKonten::findOrFail($id);

        $kategorikonten->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.kategori-konten.index')->withSuccess(__('message.kategorikonten_msg_updated',['name' => __('Update Kategori Konten')]));
        }
        return redirect()->back()->withSuccess(__('message.kategorikonten_msg_updated',['name' => 'Data Kategori Konten']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategorikonten = KategoriKonten::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('kategorikonten.title')]);

        if($kategorikonten!='') {
            $kategorikonten->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('kategorikonten.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
