<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //code here
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $view = view('role-permission.form-permission')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $request['name'] =  str_replace(' ', '_', strtolower($request->title));
        $request['guard_name'] = 'web';

        $permission = Permission::create($request->all());

       return redirect()->route('backoffice.role-permission.index')->withSuccess(__('message.permission_msg_added',['name' => __('permission.store')]));
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //code here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = Permission::find($id);
        $request = $request->all();
        $view = view('role-permission.form-permission', compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $request['name'] =  str_replace(' ', '_', strtolower($request->title));
        $request['guard_name'] = 'web';

        $permission = Permission::findOrFail($id);

        $permission->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.role-permission.index')->withSuccess(__('message.permission_msg_updated',['name' => __('Update Permission')]));
        }
        return redirect()->back()->withSuccess(__('message.role_msg_updated',['name' => 'Data Permission']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('permission.title')]);

        if($permission!='') {
            $permission->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('permission.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
