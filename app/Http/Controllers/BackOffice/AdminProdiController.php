<?php

namespace App\Http\Controllers\BackOffice;
use App\Http\Controllers\Controller;
use App\DataTables\AdminProdiDataTable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\Kaprodi;
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

        $userRole = Role::findById($request->user_role);
        $userType = $userRole ? $userRole->name : 'admin';
        $request['user_type'] = $userType;

        $user = User::create($request->all());

        storeMediaFile($user,$request->profile_image, 'profile_image');

        $user->assignRole($request->user_role);

        if (isset($request->kaprodi['kode_prodi_id'])) {
            $user->kaprodi()->create($request->kaprodi);
        }


        return redirect()->route('users.index')->withSuccess(__('message.user_msg_added',['name' => __('users.store')]));
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
        $kaprodi = $data->kaprodi; // Mengakses relasi kaprodi

        $nama_prodi = '-';
        if ($kaprodi !== null) {
            $kode_prodi = $kaprodi->kode_prodi_id;
            $jurusan = Prodi::where('kode_prodi', $kode_prodi)->first();
            if ($jurusan !== null) {
                $nama_prodi = $jurusan->nama_prodi;
            } else {
                $nama_prodi = '-';
            }
          
        } else {
           $jurusan = null;
        }

       
      
        $data['user_type'] = $data->roles->pluck('id') ?? null;

        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

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
        $data = User::with('roles')->findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id');
       
        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        $prodi = Prodi::all();


        return view('users.form', compact('data','id', 'roles', 'profileImage' , 'prodi'));
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

        $role = Role::find($request->user_role);

        if(env('IS_DEMO')) {
            if($role->name === 'admin'&& $user->role->user_type === 'admin') {
                return redirect()->back()->with('error', 'Permission denied');
            }
        }
        $user->assignRole($role->name);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;
        $request['user_type'] = Role::findById($request->user_role)->name;


        $titleRoles = Role::where('id', $request['user_role'])->first();
        $kaprodiData = $user->kaprodi()->where('user_id', $user->id)->first();   
       
        if ($kaprodiData != null) {
            if ($titleRoles->name == 'admin') {
                $kaprodiData->delete();
            } 
            else if ($titleRoles->name == 'kaprodi') {  
                $user->kaprodi()->update(['kode_prodi_id' => $request->kaprodi['kode_prodi_id']]);
            }
        } 
        else {
            if ($titleRoles->name === 'kaprodi'){
                $user->kaprodi()->create(['kode_prodi_id' => $request->kaprodi['kode_prodi_id']]);
            }
        }
        
        // User user data...
        $user->fill($request->all())->update();

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        if(auth()->check()){
            return redirect()->route('users.index')->withSuccess(__('message.msg_updated',['name' => __('message.user')]));
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
