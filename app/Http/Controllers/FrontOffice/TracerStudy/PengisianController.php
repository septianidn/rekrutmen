<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;
use App\Models\HalamanPertanyaan;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengisianController extends Controller
{

    public function mulai(Request $request, $alias_url)
    {

        $paket_soal = PaketSoal::where('alias_url', $alias_url)->first();
        if($paket_soal){
                $untuk_lulusan = $paket_soal->untuk_lulusan;
                $thn_lulus =  Auth::guard('alumni')->user()->thn_lulus;
                
            if( $untuk_lulusan == $thn_lulus){

                $data = HalamanPertanyaan::with('pertanyaan.pertanyaanGeneral', 'pertanyaan.pertanyaanGeneralOption', 'pertanyaan.pertanyaanGridOption', 'pertanyaan.pertanyaanZona', 'pertanyaan.pertanyaanDropdown')
                ->where('paket_soal_id', $paket_soal->id)
                ->get()
                ->toArray();

                return view('frontoffice.tracerstudy.pengisian.pengisian', compact('paket_soal', 'data'));

            }
            elseif($untuk_lulusan !== $thn_lulus ){
                abort(403);
            }
        }
        else{
            abort(404);
        }
       
    }


   
}
