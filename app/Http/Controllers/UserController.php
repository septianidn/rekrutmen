<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\AdminProdi;
use App\Models\Prodi;
use App\Models\StatusUser;
use App\Models\TemporaryFiles;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('users.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('backoffice.users.create').'" class="btn btn-sm btn-primary" role="button">Tambah User</a>';
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

        return view('users.form', compact('roles', 'prodi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $request['password'] = bcrypt($request->password);
        $roleName = Role::findById($request->user_role)->name ?? 'admin';
        $request['user_type'] = $roleName;

        $temporaryFile = TemporaryFiles::where('folder', $request->profile_image)->first();

        $user = User::create($request->all());
        if($temporaryFile){
            $user->addMedia(storage_path('app/public/profile_image/tmp/' . $request->profile_image . '/' . $temporaryFile->filename))
            ->toMediaCollection('profile_image');
            rmdir(storage_path('app/public/profile_image/tmp/' . $request->profile_image));
            $temporaryFile->delete();
        }
     
     
        $user->assignRole($roleName);

        if (isset($request->adminprodi['kode_prodi_id'])) {
            $user->adminprodi()->create($request->adminprodi);
        }


        return redirect()->route('backoffice.users.index')->withSuccess(__('message.user_msg_added',['name' => __('users.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);

        $profileImage = $data->getFirstMedia('profile_image');

        $adminprodi = $data->adminprodi; 

        $nama_prodi = '-';
        if ($adminprodi !== null) {
            $kode_prodi = $adminprodi->kode_prodi_id;
            $jurusan = Prodi::where('kode_prodi', $kode_prodi)->first();
            if ($jurusan !== null) {
                $nama_prodi = $jurusan->nama_prodi;
            } else {
                $nama_prodi = '-';
            }
          
        } else {
           $jurusan = null;
        }
         
  

        return view('users.profile', compact('data', 'profileImage', 'nama_prodi'));
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
       
        $roles = Role::where('status', 1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        $prodi = Prodi::all();


        return view('users.form', compact('data','id','roles', 'profileImage' , 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        // dd($request->all());
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
            return redirect()->route('backoffice.users.index')->withSuccess(__('message.msg_updated',['name' => __('message.user')]));
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
}
