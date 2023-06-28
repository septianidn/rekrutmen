<?php

namespace App\Http\Controllers\FrontOffice;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        
        return view('frontoffice.landing-page');
    }

   
}
