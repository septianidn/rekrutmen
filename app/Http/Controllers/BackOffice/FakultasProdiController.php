<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\FakultasDataTable;
use App\DataTables\FakultasProdiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\FakultasProdiRequest;
use App\Http\Requests\FakultasRequest;
use App\Models\Fakultas;
use App\Models\FakultasProdi;

class FakultasProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FakultasProdiDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('fakultasprodi.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $returnView = 'backoffice.datamaster.fakultasprodi.form';
        $buttonAddTitle = 'Fakultas Prodi';
        return $dataTable->render('global.datatablewithmodal', compact('pageTitle','auth_user','assets', 'buttonAddTitle', 'returnView'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FakultasProdiRequest $request)
    {
        
       $fakultasprodi = FakultasProdi::create($request->all());

       return redirect()->route('fakultasprodi.index')->withSuccess(__('message.fakultasprodi_msg_added',['name' => __('fakultasprodi.store')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FakultasProdiRequest $request, $id)
    {
        // dd($request->all());
        $fakultasprodi = FakultasProdi::findOrFail($id);

        $fakultasprodi->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('fakultasprodi.index')->withSuccess(__('message.fakultasprodi_msg_updated',['name' => __('Update Fakultas Prodi')]));
        }
        return redirect()->back()->withSuccess(__('message.fakultasprodi_msg_updated',['name' => 'Data Fakultas Prodi']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fakultasprodi = FakultasProdi::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('fakultasprodi.title')]);

        if($fakultasprodi!='') {
            $fakultasprodi->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('fakultasprodi.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
