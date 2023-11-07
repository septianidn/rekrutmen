<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use Illuminate\Http\Request;



class TracerStudyLandingPageController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        $optionTracerStudy = PaketSoal::select('untuk_lulusan', 'alias_url')
        ->orderBy('untuk_lulusan', 'DESC') // Mengurutkan berdasarkan 'untuk_lulusan' secara ascending (A-Z)
        ->get(); 
        //TODO: ORDER BY TAHUN PELAKSANAAN

        $assets = ['vanilla-counter', 'glightbox'];

        $dataLaporan = LaporanTS::orderBy('created_at', 'DESC')->take(6)->get();
        return view('frontoffice.tracerstudy.tracer-study', compact('assets','dataLaporan','optionTracerStudy'));
    }

    public function laporan(Request $request)
    {
        //TODO: ORDER BY TAHUN PELAKSANAAN
        $dataLaporan = LaporanTS::orderBy('created_at', 'DESC')->paginate(9);
        return view('frontoffice.tracerstudy.laporan-akhir',compact('dataLaporan'));
    }



   
}
