<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolesRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $view = view('role-permission.form-role')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
       
        $request['name'] =  str_replace(' ', '_', strtolower($request->title));
        $request['guard_name'] = 'web';

        $roles = Role::create($request->all());

       return redirect()->route('backoffice.role-permission.index')->withSuccess(__('message.roles_msg_added',['name' => __('roles.store')]));
   
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
        $data = Role::find($id);
        $request = $request->all();
        $view = view('role-permission.form-role', compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request, $id)
    {

        $request['name'] =  str_replace(' ', '_', strtolower($request->title));
        $request['guard_name'] = 'web';

        $role = Role::findOrFail($id);

        $role->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.role-permission.index')->withSuccess(__('message.role_msg_updated',['name' => __('Update Role')]));
        }
        return redirect()->back()->withSuccess(__('message.role_msg_updated',['name' => 'Data Role']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('role.title')]);

        if($role!='') {
            $role->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('role.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
