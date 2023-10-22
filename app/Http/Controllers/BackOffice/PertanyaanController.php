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

        // foreach ($data["nama_halaman"] as $urutan => $namaHalaman) {
        //     HalamanPertanyaan::create([
        //         'nama_halaman' => $namaHalaman,
        //         'urutan' => $urutan,
        //         'paket_soal_id' => $idPaketSoal
        // ]);
        // }

        dd($data);

        // $pertanyaanData = $data["pertanyaan"];
        // $kodeSoalData = $data["kode_soal"];
        // $wajibDijawabData = $data["wajib_dijawab"];

//         foreach ($pertanyaanData as $key => $value) {
//             Pertanyaan::create([
//                 'pertanyaan' => $value[1],
//                 'kode_soal' => $kodeSoalData[$key][1],
//                 'wajib_dijawab' => $wajibDijawabData[$key][1] === 'on' ? 1 : 0,
//                 'halaman_id'=> 1
//             ]);
// }

    }

   
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
    public function update()
    {
       

    }

}
