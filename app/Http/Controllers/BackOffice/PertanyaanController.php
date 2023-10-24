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
        $data = $request->all();

        dd($data);
        // foreach ($data['halaman_pertanyaan'] as $urutan => $namaHalaman) {
        //     $halamanPertanyaan = HalamanPertanyaan::create([
        //         'urutan' => $urutan,
        //         'nama_halaman' => $namaHalaman,
        //         'paket_soal_id' => $idPaketSoal
        //     ]);
    
        //     // Iterate over the corresponding "pertanyaan" array
        //     foreach ($data['pertanyaan'][$urutan] as $urutanPertanyaan => $pertanyaanData) {
        //         $pertanyaan = Pertanyaan::create([
        //             'urutan' => $urutanPertanyaan,
        //             'halaman_id' => $halamanPertanyaan->id,
        //             'pertanyaan' => $pertanyaanData['pertanyaan'],
        //             'kode_soal' => $pertanyaanData['kode_soal'],
        //             'tipe_pertanyaan' => $pertanyaanData['tipe_pertanyaan'],
        //         ]);
    
        //         // Check if "pertanyaan_general" exists and insert it
        //         if (isset($data['pertanyaan_general'][$urutanPertanyaan])) {
        //             $pertanyaanGeneralData = $data['pertanyaan_general'][$urutanPertanyaan][1];
    
        //             PertanyaanGeneral::create([
        //                 'pertanyaan_id' => $pertanyaan->id,
        //                 'tipe_pertanyaan_general' => $pertanyaanGeneralData['tipe_pertanyaan_general'],
        //                 'max_character_jawaban' => $pertanyaanGeneralData['max_character_jawaban'],
        //                 'min_character_jawaban' => $pertanyaanGeneralData['min_character_jawaban'],
        //             ]);
        //         }
        //     }
        // }
    

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
