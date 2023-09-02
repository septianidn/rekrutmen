<?php

namespace App\Http\Controllers\BackOffice;
use App\Http\Controllers\Controller;
use App\DataTables\AdminProdiDataTable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminProdiRequest;
use App\Models\Prodi;

class AdminProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminProdiDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('adminprodi.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('kelola-admin-prodi.create').'" class="btn btn-sm btn-primary" role="button">Tambah Admin Prodi</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status',1)->get()->pluck('title', 'id');
        $prodi = Prodi::all();


        return view('backoffice.adminprodi.form', compact('roles', 'prodi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProdiRequest $request)
    {
        $request['password'] = bcrypt($request->password);

        $userRole = Role::findById($request->user_role);
        $userType = $userRole ? $userRole->name : 'admin';
        $request['user_type'] = $userType;

        $user = User::create($request->all());

        storeMediaFile($user,$request->profile_image, 'profile_image');

        $user->assignRole($request->user_role);

        if (isset($request->adminprodi['kode_prodi_id'])) {
            $user->adminprodi()->create($request->adminprodi);
        }


        return redirect()->route('kelola-admin-prodi.index')->withSuccess(__('message.adminprodi_msg_added',['name' => __('adminprodi.store')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::with('roles')->findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;
       
        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        $prodi = Prodi::all();


        return view('backoffice.adminprodi.form', compact('data','id', 'roles', 'profileImage' , 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProdiRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;
        $nameRoles = Role::where('id', $request->user_role)->first();
        $request['user_type'] = $nameRoles->name;
        
        $adminprodiData = $user->adminprodi()->where('user_id', $user->id)->first();   
       
        if ($adminprodiData != null) {
            if ($nameRoles->name == 'admin') {
                $adminprodiData->delete();
            } 
            else if ($nameRoles->name == 'adminprodi') {  
                $user->adminprodi()->update(['kode_prodi_id' => $request->adminprodi['kode_prodi_id']]);
            }
        } 
        else {
            if ($nameRoles->name === 'adminprodi'){
                $user->adminprodi()->create(['kode_prodi_id' => $request->adminprodi['kode_prodi_id']]);
            }
        }
        
        // User user data...
        $userUpdate = $user->fill($request->all())->update();
        if ($userUpdate) {
            $user->assignRole(Role::findById($request->user_role)->name);
        }
        

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        if(auth()->check()){
            return redirect()->route('kelola-admin-prodi.index')->withSuccess(__('message.msg_updated',['name' => __('message.user')]));
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
        $message= __('global-message.delete_form', ['form' => __('adminprodi.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('adminprodi.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
