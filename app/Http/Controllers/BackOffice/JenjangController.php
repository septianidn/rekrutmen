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
        $buttonAddTitle = 'Jenjang';
        return $dataTable->render('global.datatablewithmodal', compact('pageTitle','auth_user','assets', 'buttonAddTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('backoffice.datamaster.jenjang.form')->render();
        }
    
        return view('backoffice.datamaster.jenjang.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenjangRequest $request)
    {
        
       $jenjang = Jenjang::create($request->all());

       return redirect()->route('jenjang.index')->withSuccess(__('message.jenjang_msg_added',['name' => __('jenjang.store')]));
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
    public function edit($id)
    {
        $data = Jenjang::findOrFail($id);

        return view('backoffice.datamaster.jenjang.form', compact('data','id'));
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
            return redirect()->route('jenjang.index')->withSuccess(__('message.jenjang_msg_updated',['name' => __('Update Jenjang')]));
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
