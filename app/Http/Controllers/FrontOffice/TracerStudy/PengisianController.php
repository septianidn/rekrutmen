<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use Illuminate\Http\Request;



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

        if(!$paket_soal){
            abort(404);
        }
        return view('frontoffice.tracerstudy.pengisian.pengisianv2', compact('paket_soal'));
    }


   
}
