<?php

namespace App\Http\Controllers\BackOffice;
use App\DataTables\PaketSoalDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\PaketSoalRequest;
use App\Http\Requests\PertanyaanRequest;
use App\Models\HalamanPertanyaan;
use App\Models\PaketSoal;
use App\Models\Pertanyaan;
use App\Models\PertanyaanGeneral;

class PertanyaanController extends Controller
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
    public function create($idPaketSoal)
    {
        $assets = ['animation'];

        if (request()->ajax()) {
            return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.form', compact('idPaketSoal','assets'))->render();
        }
    
        return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.form', compact('idPaketSoal','assets'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idPaketSoal)
    {
        $data = $request->data;
dd($data);
    
        //   foreach ($data as $halamanData) {
        //         $halaman = HalamanPertanyaan::create([
        //             'urutan' => $halamanData['urutan'],
        //             'paket_soal_id' => $idPaketSoal,
        //             'nama_halaman' => $halamanData['nama_halaman']]);
        
        //         foreach ($halamanData['pertanyaan'] as $pertanyaanData) {
        //             $pertanyaan = Pertanyaan::create([
        //                 'halaman_id' => $halaman->id,
        //                 'kode_soal' => $pertanyaanData['kode_soal'],
        //                 'urutan' => $pertanyaanData['urutan'],
        //                 'pertanyaan' => $pertanyaanData['pertanyaan'],
        //                 'tipe_pertanyaan' => $pertanyaanData['tipe_pertanyaan'],
                        
        //             ]);
        
        //             // Periksa tipe pertanyaan dan simpan data sesuai dengan jenisnya
        //             if ($pertanyaanData['tipe_pertanyaan'] === 'general') {
        //                 $pertanyaanGeneralData = $pertanyaanData['pertanyaan_general'];
        //                 $pertanyaanGeneral = PertanyaanGeneral::create([
        //                     'pertanyaan_id' => $pertanyaan->id,
        //                     'max_character_jawaban' => $pertanyaanGeneralData['max_character_jawaban'],
        //                     // Set atribut lain sesuai kebutuhan
        //                 ]);
        //             } elseif ($pertanyaanData['tipe_pertanyaan'] === 'single') {
        //                 // Proses pertanyaan tipe lain sesuai dengan jenisnya
        //             }
        
        //             // Lanjutkan untuk jenis-jenis pertanyaan lainnya
        //             // ...
        //         }
        //     }
        
            
        
        
      

        return redirect()->route('paket-soal.index')->withSuccess(__('message.pertanyaan_msg_added',['name' => __('paket-soal.store')]));
 
    }

   
    public function edit($idPaketSoal)
    {
        $assets = ['animation'];

        $data = HalamanPertanyaan::with('pertanyaan.pertanyaanGeneral', 'pertanyaan.pertanyaanGeneralOption', 'pertanyaan.pertanyaanGridOption')
        ->where('paket_soal_id', $idPaketSoal)
        ->get()->toArray(); 

        dd($data);
        if (request()->ajax()) {
            return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.form', compact('idPaketSoal','data', 'assets'))->render();
        }
    
        return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.form', compact('idPaketSoal','data', 'assets'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
       

    }

}
