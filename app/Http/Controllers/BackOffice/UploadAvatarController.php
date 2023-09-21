<?php

namespace App\Http\Controllers\BackOffice;
use App\Http\Controllers\Controller;
use App\DataTables\AdminProdiDataTable;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Http\File;
use App\Models\Prodi;
use App\Models\TemporaryFiles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class UploadAvatarController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tmpUpload(Request $request)
    {
      
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/profile_image/tmp/' . $folder, $filename);

            TemporaryFiles::create([
                'folder' => $folder,
                'filename' => $filename
            ]);

            return $folder;

        }

        return ''; 
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        $user = User::find(1);
    
        if (!$user) {
            return Response::json(['error' => 'User not found'], 404);
        }
    
        // Mengambil media 'profile_image' dari model User
        $profileImage = $user->getFirstMedia('profile_image');
    
        if (!$profileImage) {
            return Response::json(['error' => 'Profile image not found'], 404);
        }
    
        // Dapatkan URL berkas gambar profil
        $imageUrl = $profileImage->getUrl();
    
        // Dapatkan informasi yang diperlukan untuk header
        $file_name = $profileImage->file_name;
        $file_size = $profileImage->size;
        $file_type = $profileImage->mime_type;
        $unique_file_id = $profileImage->id;
    
        // Buat respons dengan header yang sesuai dan konten berkas
        $response = response()->stream(function () use ($imageUrl) {
            echo file_get_contents($imageUrl);
        }, 200);
    
       // Atur header Content-Type
    $response->headers->set('Content-Type', $file_type);

    // Atur header Content-Disposition
    $response->headers->set('Content-Disposition', "inline; filename=\"$file_name\"");

    // Atur header Content-Length
    $response->headers->set('Content-Length', $file_size);

    // Atur header X-Content-Transfer-Id
    $response->headers->set('X-Content-Transfer-Id', $unique_file_id);

    // Atur header Access-Control-Expose-Headers
    $response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition, Content-Length, X-Content-Transfer-Id');

    dd($response);
   
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tmpDelete(Request $request)
    {
    
        $tmp_file = TemporaryFiles::where('folder', request()->getContent())->first();
        if( $tmp_file){
            Storage::deleteDirectory('public/profile_image/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response('');
        }
    }
}
