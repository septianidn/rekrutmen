<?php

namespace App\Http\Controllers\FrontOffice;
use App\Http\Controllers\Controller;
use App\Models\Job;

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

    public function vacancy(Request $request)
    {
        $jobs = Job::with('employer')->latest()->paginate(9);
        return view('frontoffice.vacancy', compact('jobs'));
    }
}
