<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\DataPediaDataTable;
use App\DataTables\DataPediasDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Http\Requests\DataPediaSRequest;
use App\Models\DataPediaS;

class DataPediaSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataPediasDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('datapedias.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('datapedias.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Pedia" data-placement="top" title="Tambah Data">Tambah Data Pedia</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }
    
    public function create(DataPediaSRequest $request)
    {
       
        $data = $request->all();
      
        $view = view('backoffice.datamaster.datapedias.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataPediaSRequest $request)
    {
        
       $datapedias = DataPediaS::create($request->all());

       return redirect()->route('datapedias.index')->withSuccess(__('message.datapedias_msg_added',['name' => __('datapedias.store')]));
    }

    public function edit(Request $request, $id)
    {  
        $data = DataPediaS::find($id);
        $view = view('backoffice.datamaster.datapedias.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DataPediaSRequest $request, $id)
    {
        // dd($request->all());
        $datapedias = DataPediaS::findOrFail($id);

        $datapedias->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('datapedias.index')->withSuccess(__('message.datapedias_msg_updated',['name' => __('Update Data Pedia')]));
        }
        return redirect()->back()->withSuccess(__('message.datapedias_msg_updated',['name' => 'Data Pedia']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datapedias = DataPediaS::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('datapedias.title')]);

        if($datapedias!='') {
            $datapedias->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('datapedias.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
