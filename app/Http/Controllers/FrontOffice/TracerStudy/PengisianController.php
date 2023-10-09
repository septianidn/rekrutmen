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
        return view('frontoffice.tracerstudy.pengisian.prolog');
    }

   



   
}
