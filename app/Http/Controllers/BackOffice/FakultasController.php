<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\FakultasDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\FakultasRequest;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FakultasDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('fakultas.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('fakultas.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Fakultas" data-placement="top" title="Tambah Data">Tambah Fakultas</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    
    public function create(Request $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.fakultas.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FakultasRequest $request)
    {
        
       $fakultas = Fakultas::create($request->all());

       return redirect()->route('fakultas.index')->withSuccess(__('message.fakultas_msg_added',['name' => __('fakultas.store')]));
    }

    public function edit(Request $request, $id)
    {  
        $data = Fakultas::find($id);
        $view = view('backoffice.datamaster.fakultas.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FakultasRequest $request, $id)
    {
        // dd($request->all());
        $fakultas = Fakultas::findOrFail($id);

        $fakultas->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('fakultas.index')->withSuccess(__('message.fakultas_msg_updated',['name' => __('Update Fakultas')]));
        }
        return redirect()->back()->withSuccess(__('message.fakultas_msg_updated',['name' => 'Data Fakultas']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Fakultas::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('fakultas.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('fakultas.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
