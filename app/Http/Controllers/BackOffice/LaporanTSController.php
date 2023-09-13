<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\LaporanTSDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\laporantsRequest;
use App\Models\LaporanTS;

class LaporanTSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanTSDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('laporants.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
    
        $headerAction = '<a data--href="' . route('laporan-tracer-study.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Laporan Tracer Study</a>';

        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }


    public function create(Request $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.konten.laporants.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanTSRequest $request)
    {        
       
    
       $laporants = LaporanTS::create($request->all());

       return redirect()->route('laporan-tracer-study.index')->withSuccess(__('message.laporants_msg_added',['name' => __('laporan-tracer-study.store')]));
    }

    public function edit(Request $request, $id)
    {
       
        $data = LaporanTS::find($id);
        $view = view('backoffice.konten.laporants.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LaporanTSRequest $request, $id)
    {
        // dd($request->all());
        $laporants = LaporanTS::findOrFail($id);

        $laporants->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('kelola.index')->withSuccess(__('message.laporants_msg_updated',['name' => __('Update Laporan')]));
        }
        return redirect()->back()->withSuccess(__('message.laporants_msg_updated',['name' => 'Data laporants']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $laporants = LaporanTS::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('laporants.title')]);

        if($laporants!='') {
            $laporants->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('laporants.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
