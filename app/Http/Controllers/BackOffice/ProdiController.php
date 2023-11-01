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
        $headerAction = '<a data--href="' . route('backoffice.prodi.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Prodi</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $view = view('backoffice.datamaster.prodi.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
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

       return redirect()->route('backoffice.prodi.index')->withSuccess(__('message.prodi_msg_added',['name' => __('prodi.store')]));
    }

    
    public function edit($id)
    {
       
        $data = Prodi::find($id);
        $view = view('backoffice.datamaster.prodi.form',  compact('data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
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
            return redirect()->route('backoffice.prodi.index')->withSuccess(__('message.prodi_msg_updated',['name' => __('Update Prodi')]));
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
