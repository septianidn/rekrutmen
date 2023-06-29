<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TracerStudyLandingPageController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        
        return view('frontoffice.tracerstudy.tracer-study');
    }

   
}
