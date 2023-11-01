<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\FakultasDataTable;
use App\DataTables\GrupKontenDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\FakultasRequest;
use App\Http\Requests\GrupKontenRequest;
use App\Models\Fakultas;
use App\Models\GrupKonten;

class GrupKontenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GrupKontenDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('grupkonten.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
    
        $headerAction = '<a data--href="' . route('backoffice.grup-konten.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Grup Konten</a>';

        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    public function create(Request $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.konten.grupkonten.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupKontenRequest $request)
    {        
       
    
       $grupkonten = GrupKonten::create($request->all());

       return redirect()->route('backoffice.grup-konten.index')->withSuccess(__('message.fakultas_msg_added',['name' => __('grup-konten.store')]));
    }

    public function edit(Request $request, $id)
    {
       
        $data = GrupKonten::find($id);
        $view = view('backoffice.konten.grupkonten.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupKontenRequest $request, $id)
    {
        // dd($request->all());
        $grupkonten = GrupKonten::findOrFail($id);

        $grupkonten->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.grup-konten.index')->withSuccess(__('message.grupkonten_msg_updated',['name' => __('Update Grup Konten')]));
        }
        return redirect()->back()->withSuccess(__('message.grupkonten_msg_updated',['name' => 'Data Grup Konten']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupkonten = GrupKonten::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('grupkonten.title')]);

        if($grupkonten!='') {
            $grupkonten->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('grupkonten.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
