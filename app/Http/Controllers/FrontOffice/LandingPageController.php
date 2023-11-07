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
        $assets = ['slider', 'wow'];
        return view('frontoffice.landing-page', compact('assets'));
    }

   
}
