<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\JenjangDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jenjang;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\JenjangRequest;

class JenjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JenjangDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('jenjang.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('backoffice.jenjang.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data Jenjang" data-placement="top" title="Tambah Data">Tambah Data Jenjang</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    public function create(Request $request)
    {
       
        $data = $request->all();
        $view = view('backoffice.datamaster.jenjang.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenjangRequest $request)
    {
        
       $jenjang = Jenjang::create($request->all());

       return redirect()->route('backoffice.jenjang.index')->withSuccess('Data jenjang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
       /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {  
        $data = Jenjang::find($id);
        $view = view('backoffice.datamaster.jenjang.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JenjangRequest $request, $id)
    {
        // dd($request->all());
        $jenjang = Jenjang::findOrFail($id);

        $jenjang->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.jenjang.index')->withSuccess(__('message.jenjang_msg_updated',['name' => __('Update Jenjang')]));
        }
        return redirect()->back()->withSuccess(__('message.jenjang_msg_updated',['name' => 'My Profile']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Jenjang::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('jenjang.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('jenjang.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
