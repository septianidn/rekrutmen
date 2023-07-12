<?php

namespace App\Http\Controllers\BackOffice;


use App\DataTables\ProdiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;

use App\Http\Requests\ProdiRequest;
use App\Models\Prodi;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProdiDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('prodi.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $returnView = 'backoffice.datamaster.prodi.form';
        $buttonAddTitle = 'Prodi';
        return $dataTable->render('global.datatablewithmodal', compact('pageTitle','auth_user','assets', 'buttonAddTitle', 'returnView'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdiRequest $request)
    {
        
       $prodi = Prodi::create($request->all());

       return redirect()->route('prodi.index')->withSuccess(__('message.prodi_msg_added',['name' => __('prodi.store')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdiRequest $request, $id)
    {
        // dd($request->all());
        $prodi = Prodi::findOrFail($id);

        $prodi->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('prodi.index')->withSuccess(__('message.prodi_msg_updated',['name' => __('Update Prodi')]));
        }
        return redirect()->back()->withSuccess(__('message.prodi_msg_updated',['name' => 'Data Prodi']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Prodi::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('prodi.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('prodi.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
