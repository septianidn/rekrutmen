<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengisianController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function prolog(Request $request)
    {
        return view('frontoffice.tracerstudy.pengisian.pengisianv2');
    }

   

    public function show(Request $request, $alias_url)
    {

        $paket_soal = PaketSoal::where('alias_url', $alias_url)->first();
        if($paket_soal){
                $untuk_lulusan = $paket_soal->untuk_lulusan;
                $thn_lulus =  Auth::guard('alumni')->user()->thn_lulus;
            if( $untuk_lulusan == $thn_lulus){
                return view('frontoffice.tracerstudy.pengisian.pengisianv2', compact('paket_soal'));
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
