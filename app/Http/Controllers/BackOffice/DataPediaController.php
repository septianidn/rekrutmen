<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\DataPediaDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Http\Requests\DataPediaRequest;
use App\Models\DataPedia;

class DataPediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataPediaDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('datapedia.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('backoffice.datapedia.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Pedia" data-placement="top" title="Tambah Data">Tambah Data Pedia</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }
    
    public function create(DataPediaRequest $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.datapedia.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataPediaRequest $request)
    {
        
       $datapedia = DataPedia::create($request->all());

       return redirect()->route('backoffice.datapedia.index')->withSuccess(__('message.datapedia_msg_added',['name' => __('datapedia.store')]));
    }

    public function edit(Request $request, $id)
    {  
        $data = DataPedia::find($id);
        $view = view('backoffice.datamaster.datapedia.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DataPediaRequest $request, $id)
    {
        // dd($request->all());
        $datapedia = DataPedia::findOrFail($id);

        $datapedia->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.datapedia.index')->withSuccess(__('message.datapedia_msg_updated',['name' => __('Update Data Pedia')]));
        }
        return redirect()->back()->withSuccess(__('message.datapedia_msg_updated',['name' => 'Data Pedia']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datapedia = DataPedia::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('datapedia.title')]);

        if($datapedia!='') {
            $datapedia->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('datapedia.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
