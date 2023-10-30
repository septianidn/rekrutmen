<?php

namespace App\Http\Controllers\BackOffice;
use App\DataTables\PaketSoalDataTable;
use App\Enums\TypePertanyaanEnum;
use App\Enums\TypePertanyaanGeneralEnum;
use App\Enums\TypePertanyaanGeneralOptionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\PaketSoalRequest;
use App\Http\Requests\PertanyaanRequest;
use App\Models\HalamanPertanyaan;
use App\Models\PaketSoal;
use App\Models\Pertanyaan;
use App\Models\PertanyaanGeneral;
use App\Models\PertanyaanGeneralOption;
use App\Models\PertanyaanGridOption;
use RecursiveArrayIterator;
use stdClass;

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
    public function store(PertanyaanRequest $request, $idPaketSoal)
    {
        $data = $request->data;
        // dd($data);
        $response = ['success' => [], 'error' => []];
    
          foreach ($data as $halamanData) {
                $halaman = HalamanPertanyaan::create([
                    'urutan' => $halamanData['urutan'],
                    'paket_soal_id' => $idPaketSoal,
                    'nama_halaman' => $halamanData['nama_halaman']]);

                  
        
                foreach ($halamanData['pertanyaan'] as $pertanyaanData) {
                    $wajibDijawab = 0;
                    if(isset($pertanyaanData["wajib_dijawab"])){
                         $wajibDijawab = ($pertanyaanData["wajib_dijawab"] == "on") ? 1 : 0;
                    }

                    switch ($pertanyaanData['tipe_pertanyaan']) {
                        case 'single':
                        case 'mutiple':
                            $tipe_pertanyaan = TypePertanyaanEnum::GENERAL_OPTION;
                            break;
                        case 'general':
                            $tipe_pertanyaan = TypePertanyaanEnum::GENERAL;
                            break;
                        case 'grid_option':
                            $tipe_pertanyaan = TypePertanyaanEnum::GRID_OPTION;
                            break;
                        case 'dropdown':
                            $tipe_pertanyaan = TypePertanyaanEnum::DROPDOWN;
                            break;
                        case 'zone':
                            $tipe_pertanyaan = TypePertanyaanEnum::ZONE;
                            break;
                        default:
                        $tipe_pertanyaan = TypePertanyaanEnum::GENERAL;
                    }
                    
                    $pertanyaan = Pertanyaan::create([
                        'halaman_id' => $halaman->id,
                        'kode_soal' => $pertanyaanData['kode_soal'],
                        'urutan' => $pertanyaanData['urutan'],
                        'pertanyaan' => $pertanyaanData['pertanyaan'],
                        'tipe_pertanyaan' => $tipe_pertanyaan,
                        'wajib_dijawab' => $wajibDijawab,
                        
                    ]);
                    if($pertanyaanData['tipe_pertanyaan'] ===  'paragraph'){
                        $pertanyaanGeneral = PertanyaanGeneral::create([
                            'pertanyaan_id' => $pertanyaan->id,
                            'max_character_jawaban' => 500,
                            'min_character_jawaban' => 500 ,
                            'tipe_pertanyaan_general' => TypePertanyaanGeneralEnum::PARAGRAPH,
                        ]);
                    }
                    
                    if ($pertanyaanData['tipe_pertanyaan'] === 'general' ) {
                        if (isset($pertanyaanData['pertanyaan_general'])) {
                            $pertanyaanGeneralData = $pertanyaanData['pertanyaan_general'];

                            switch ($pertanyaanGeneralData['tipe_pertanyaan_general']) {
                                case 'short_answer':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::SHORT_ANSWER;
                                    break;
                                case 'email':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::EMAIL;
                                    break;
                                case 'tel':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::TEL;
                                    break;
                                case 'url':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::URL;
                                    break;
                                case 'number':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::NUMBER;
                                    break;
                                case 'letters':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::LETTERS;
                                    break;
                                case 'date':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::DATE;
                                    break;
                                case 'time':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::TIME;
                                    break;
                                case 'datetime-local':
                                    $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::DATETIME_LOCAL;
                                break;
                                default:
                                $tipePertanyaanGeneral = TypePertanyaanGeneralEnum::SHORT_ANSWER;
                            }
                           
                            $pertanyaanGeneral = PertanyaanGeneral::create([
                                'pertanyaan_id' => $pertanyaan->id,
                                'max_character_jawaban' => $pertanyaanGeneralData['max_character_jawaban'],
                                'min_character_jawaban' => $pertanyaanGeneralData['min_character_jawaban'],
                                'tipe_pertanyaan_general' => $tipePertanyaanGeneral,
                            ]);
                        }
                    } elseif ($pertanyaanData['tipe_pertanyaan'] === 'single' || $pertanyaanData['tipe_pertanyaan'] === 'mutiple') {
                        if (isset($pertanyaanData['pertanyaan_general_option']) && is_array($pertanyaanData['pertanyaan_general_option'])) {
                            foreach ($pertanyaanData['pertanyaan_general_option'] as $key => $pertanyaanGeneralOptionData) {
                                if (isset ($pertanyaanGeneralOptionData['check_tambahan']) && $pertanyaanGeneralOptionData['check_tambahan'] == 'on') {
                                    $kodetambahan = $pertanyaanGeneralOptionData['kode_input_tambahan'];
                                } else {
                                    $kodetambahan = null;
                                }
                                $urutan = intval($key) + 1;
                                $pertanyaanGeneralOption = PertanyaanGeneralOption::create([
                                    'pertanyaan_id' => $pertanyaan->id,
                                    'urutan' => $urutan,
                                    'kode' => $pertanyaanGeneralOptionData['kode'],
                                    'value' => $pertanyaanGeneralOptionData['value'],
                                    'label' => $pertanyaanGeneralOptionData['label'],
                                    'kode_input_tambahan' => $kodetambahan,
                                    'tipe' => ($pertanyaanData['tipe_pertanyaan'] === 'single') ? TypePertanyaanGeneralOptionEnum::SINGLE : TypePertanyaanGeneralOptionEnum::MUTIPLE,
                                ]);
                            }
                        }
                    } elseif ($pertanyaanData['tipe_pertanyaan'] === 'grid_option') {
                        if (isset($pertanyaanData['pertanyaan_grid_option']) && is_array($pertanyaanData['pertanyaan_grid_option'])) {
                        
                            foreach ($pertanyaanData['pertanyaan_grid_option'] as $pertanyaanGeneralGridOptionData) {
                                $pertanyaanGeneralDataGridOption = PertanyaanGridOption::create([
                                    'pertanyaan_id' => $pertanyaan->id,
                                    'urutan' => $pertanyaanGeneralGridOptionData['urutan'],
                                    'value' => $pertanyaanGeneralGridOptionData['tipe_grid'] == 'row' ? $pertanyaanGeneralGridOptionData['label'] :  $pertanyaanGeneralGridOptionData['value'],
                                    'kode' => $pertanyaanGeneralGridOptionData['tipe_grid'] == 'row' ? $pertanyaanGeneralGridOptionData['value'] :  $pertanyaanGeneralGridOptionData['kode'],
                                    'label' => $pertanyaanGeneralGridOptionData['label'],
                                    'tipe_grid' => $pertanyaanGeneralGridOptionData['tipe_grid'],
                                ]);
                            }
                        }
                    }
                }
            }

            if (!$halaman) {
                $response['error'][] = 'Gagal menyimpan data halaman: ' . $halaman['nama_halaman'];
            } 
            if (!$pertanyaan) {
                $response['error'][] = 'Gagal menyimpan data pertanyaan: ' . $pertanyaanData['pertanyaan'];
            } 
            
            if (empty($response['error'])) {
              
                return response()->json(['success' => $response['success']]);
            } else {
               
                return response()->json(['error' => $response['error']]);
            }
        
    }

   
    public function edit($idPaketSoal)
    {
        $assets = ['animation'];
       
      
        $data = HalamanPertanyaan::with('pertanyaan.pertanyaanGeneral', 'pertanyaan.pertanyaanGeneralOption', 'pertanyaan.pertanyaanGridOption')
        ->where('paket_soal_id', $idPaketSoal)
        ->get()
        ->toArray();

// dd($data);
       
        if (request()->ajax()) {
            return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.formedit', compact('idPaketSoal','data', 'assets'))->render();
        }
    
        return view('backoffice.tracerstudy.admin.paket-soal.pertanyaan.formedit', compact('idPaketSoal','data', 'assets'))->render();
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
