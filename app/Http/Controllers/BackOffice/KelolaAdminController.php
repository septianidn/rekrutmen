<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\AdminDataTable;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use App\Http\Requests\AdminRequest;

use Spatie\Permission\Models\Role;


use App\Models\TemporaryFiles;

class KelolaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('admin.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('backoffice.kelola-admin.create').'" class="btn btn-sm btn-primary" role="button">Tambah Admin</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status', 1)
        ->where('name', 'not like', 'mahasiswa')
        ->get()
        ->pluck('title', 'id');


        return view('backoffice.kelolaadmin.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $request['user_type'] = 'admin' ;

        $temporaryFile = TemporaryFiles::where('folder', $request->profile_image)->first();

        //crate user dulu
        $user = User::create($request->all());

        if($temporaryFile){
            $user->addMedia(storage_path('app/public/profile_image/tmp/' . $request->profile_image . '/' . $temporaryFile->filename))
            ->toMediaCollection('profile_image');
            rmdir(storage_path('app/public/profile_image/tmp/' . $request->profile_image));
            $temporaryFile->delete();
        }

        $user->assignRole('admin');




        return redirect()->route('backoffice.kelola-admin.index')->withSuccess(__('message.admin_msg_added',['name' => __('konsoler.store')]));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;

        $roles = Role::where('status', 1)
        ->where('name', 'not like', 'mahasiswa')
        ->get()
        ->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('backoffice.kelolaadmin.form', compact('data','id', 'roles', 'profileImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;

        $request['user_type'] = 'admin';
        // User user data...
        $userUpdate = $user->fill($request->all())->update();

        //jika berhasil update, assign role
        if ($userUpdate) {
            $user->assignRole('admin');
        }

        $temporaryFile = TemporaryFiles::where('folder', $request->profile_image)->first();

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            if($temporaryFile){
                $user->addMedia(storage_path('app/public/profile_image/tmp/' . $request->profile_image . '/' . $temporaryFile->filename))
                ->toMediaCollection('profile_image');
                rmdir(storage_path('app/public/profile_image/tmp/' . $request->profile_image));
                $temporaryFile->delete();
            }
        }

        if(auth()->check()){
            return redirect()->route('backoffice.kelola-admin.index')->withSuccess(__('message.msg_updated',['name' => __('message.user')]));
        }
        return redirect()->back()->withSuccess(__('message.msg_updated',['name' => 'My Profile']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('users.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }

    public function deletedSelected(Request $request)
    {
        if(request()->ajax()){
        $selectedIds = $request->input('selectedIds');

        $users = User::whereIn('id', $selectedIds);

        if ($users->exists()) {
            $users->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('users.title')]);
        } else {
            $message = 'No records found for deletion.';
        }

        return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);

        }


    }
}
