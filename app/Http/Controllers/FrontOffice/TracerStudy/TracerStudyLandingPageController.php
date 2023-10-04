<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;


class TracerStudyLandingPageController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        $optionTracerStudy = PaketSoal::select('id', 'untuk_lulusan')
        ->orderBy('untuk_lulusan', 'DESC') // Mengurutkan berdasarkan 'untuk_lulusan' secara ascending (A-Z)
        ->get();
    
        //TODO: ORDER BY TAHUN PELAKSANAAN
        $dataLaporan = LaporanTS::orderBy('created_at', 'DESC')->take(6)->get();
        return view('frontoffice.tracerstudy.tracer-study', compact('dataLaporan','optionTracerStudy'));
    }

    public function laporan(Request $request)
    {
        //TODO: ORDER BY TAHUN PELAKSANAAN
        $dataLaporan = LaporanTS::orderBy('created_at', 'DESC')->paginate(9);
        return view('frontoffice.tracerstudy.laporan-akhir',compact('dataLaporan'));
    }

    
    public function reloadCaptcha() {

        $captcha = Captcha::create();
    
        return response()->json(['captcha' => $captcha]);
    }
    public function login(Request $request)
    {
        // dd($request->untuk_lulusan);
        return view('frontoffice.tracerstudy.pengisian.login');
    }
}
