<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Alumni;
use App\Models\PaketSoal;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class LoginAlumniController extends Controller
{
 

    public function index(Request $request)
    {
    
        try {
            $record = PaketSoal::where('untuk_lulusan', $request->untuk_lulusan)->firstOrFail();
            $untuk_lulusan = $record->untuk_lulusan;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }
        
        return view('frontoffice.tracerstudy.pengisian.login', compact('untuk_lulusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pin' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'pin.required' => 'Pin harus berisi.',
            'g-recaptcha-response.required' => 'Captcha harus berisi',
        ]);

        try {
            $checkTC = PaketSoal::where('untuk_lulusan', $request->untuk_lulusan)->firstOrFail();
            $untuk_lulusan = $checkTC->untuk_lulusan;

            dd($untuk_lulusan);
       


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }
        

    }


    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    // /**
    //  * Destroy an authenticated session.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }
}
