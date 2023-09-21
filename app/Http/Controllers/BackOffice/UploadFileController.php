<?php

namespace App\Http\Controllers\BackOffice;
use App\Http\Controllers\Controller;
use App\DataTables\AdminProdiDataTable;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Http\File;
use App\Models\Prodi;
use App\Models\TemporaryFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tmpUpload(Request $request)
    {
      
        if($request->hasFile('lokasi_laporan')){
            $file = $request->file('lokasi_laporan');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/laporants/tmp/' . $folder, $filename);
           
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
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tmpDelete()
    {
    
        $tmp_file = TemporaryFiles::where('folder', request()->getContent())->first();
        if( $tmp_file){
            Storage::deleteDirectory('public/laporants/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response('');
        }
    }
}
