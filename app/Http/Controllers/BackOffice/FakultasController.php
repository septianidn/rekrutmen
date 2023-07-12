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
        $returnView = 'backoffice.datamaster.fakultas.form';
        $buttonAddTitle = 'Fakultas';
        return $dataTable->render('global.datatablewithmodal', compact('pageTitle','auth_user','assets', 'buttonAddTitle', 'returnView'));
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
