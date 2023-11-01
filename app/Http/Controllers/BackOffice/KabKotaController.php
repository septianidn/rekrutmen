<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\KabKotaDataTable;
use App\DataTables\ProvinsiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Http\Requests\KabKotaRequest;
use App\Http\Requests\ProvinsiRequest;
use App\Models\KabupatenKota;
use App\Models\Provinsi;

class KabKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KabKotaDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('kabkota.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('backoffice.kabkota.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Pedia" data-placement="top" title="Tambah Data">Tambah Data Pedia</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }
    
    public function create(KabKotaRequest $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.zona.kabkota.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KabKotaRequest $request)
    {
        
       $kabkota = Provinsi::create($request->all());

       return redirect()->route('backoffice.kabkota.index')->withSuccess(__('message.kabkota_msg_added',['name' => __('kabkota.store')]));
    }

    public function edit(Request $request, $id)
    {  
        $data = KabupatenKota::find($id);
        $view = view('backoffice.datamaster.zona.kabkota.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KabKotaRequest $request, $id)
    {
        // dd($request->all());
        $kabkota = KabupatenKota::findOrFail($id);

        $kabkota->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.kabkota.index')->withSuccess(__('message.kabkota_msg_updated',['name' => __('Update Data Pedia')]));
        }
        return redirect()->back()->withSuccess(__('message.kabkota_msg_updated',['name' => 'Data Pedia']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kabkota = KabupatenKota::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('kabkota.title')]);

        if($kabkota!='') {
            $kabkota->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('kabkota.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
