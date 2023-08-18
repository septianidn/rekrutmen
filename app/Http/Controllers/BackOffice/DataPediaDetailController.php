<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\DataPediaDetailDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Http\Requests\DataPediaDetailRequest;
use App\Models\DataPediaDetail;

class DataPediaDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_datapedia, DataPediaDetailDataTable $dataTable)
    {
        $dataTable->setIdData($id_datapedia); 
        $pageTitle = trans('global-message.list_form_title',['form' => trans('datapedia.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('datapediadetail.create', $id_datapedia) . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Data</a>';
       
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction', 'id_datapedia'));
    }

    
    public function create($id_datapedia, DataPediaDetailRequest $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.datapedia.detail.form', compact('id_datapedia'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataPediaDetailRequest $request)
    {
        
       $datapediadetail = DataPediaDetail::create($request->all());

       return redirect()->route('datapediadetail.index', $request->data_pedia_id)->withSuccess(__('message.datapedia_msg_added',['name' => __('datapedia.store')]));
    }

    public function edit($id_datapedia, $id, Request $request)
    {  
        $data = DataPediaDetail::find($id);
        $view = view('backoffice.datamaster.datapedia.detail.form',  compact('request', 'data', 'id', 'id_datapedia'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, DataPediaDetailRequest $request)
    {
        // dd($request->all());
        $datapedia = DataPediaDetail::findOrFail($id);

        $datapedia->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('datapediadetail.index', $request->data_pedia_id)->withSuccess(__('message.datapediadetail_msg_updated',['name' => __('Update Data Pedia')]));
        }
        return redirect()->back()->withSuccess(__('message.datapediadetail_msg_updated',['name' => 'Data Pedia Detail']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datapediadetail = DataPediaDetail::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('datapediadetail.title')]);

        if($datapediadetail!='') {
            $datapediadetail->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('datapediadetail.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
