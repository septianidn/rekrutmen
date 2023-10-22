<?php

namespace App\Http\Controllers\BackOffice;


use App\DataTables\ProvinsiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

use App\Http\Requests\ProvinsiRequest;

use App\Models\Provinsi;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProvinsiDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('provinsi.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('provinsi.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Provinsi" data-placement="top" title="Tambah Data">Tambah Data</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }
    
    public function create(ProvinsiRequest $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.zona.provinsi.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinsiRequest $request)
    {
        
       $provinsi = Provinsi::create($request->all());

       return redirect()->route('provinsi.index')->withSuccess(__('message.provinsi_msg_added',['name' => __('provinsi.store')]));
    }

    public function edit(Request $request, $id)
    {  
        $data = Provinsi::find($id);
        $view = view('backoffice.datamaster.zona.provinsi.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinsiRequest $request, $id)
    {
        // dd($request->all());
        $provinsi = Provinsi::findOrFail($id);

        $provinsi->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('provinsi.index')->withSuccess(__('message.provinsi_msg_updated',['name' => __('Update Data Pedia')]));
        }
        return redirect()->back()->withSuccess(__('message.provinsi_msg_updated',['name' => 'Data Pedia']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('provinsi.title')]);

        if($provinsi!='') {
            $provinsi->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('provinsi.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
