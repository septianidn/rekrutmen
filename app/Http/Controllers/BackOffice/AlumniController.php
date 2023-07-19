<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\AlumniDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AlumniDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('alumni.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $returnView = 'backoffice.alumni.form';
        $buttonAddTitle = 'Alumni';
        return $dataTable->render('global.datatablewithmodal', compact('pageTitle','auth_user','assets', 'buttonAddTitle', 'returnView'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlumniRequest $request)
    {
        
       $alumni = Alumni::create($request->all());

       return redirect()->route('databasealumni.index')->withSuccess(__('message.alumni_msg_added',['name' => __('databasealumni.store')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlumniRequest $request, $id)
    {
        // dd($request->all());
        $alumni= Alumni::findOrFail($id);

        $alumni->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('databasealumni.index')->withSuccess(__('message.alumni_msg_updated',['name' => __('Update Alumni')]));
        }
        return redirect()->back()->withSuccess(__('message.fakultas_msg_updated',['name' => 'Data Alumni']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Alumni::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('alumni.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('alumni.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
