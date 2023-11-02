<?php

namespace App\Http\Controllers\FrontOffice\TracerStudy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginTCRequest;
use App\Models\Alumni;
use App\Models\PaketSoal;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginAlumniController extends Controller
{
 
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $alias_url)
    {    
        try {
            $paket_soal = PaketSoal::where('alias_url', $alias_url)->first();
            if ($paket_soal) {
                $untuk_lulusan = $paket_soal->untuk_lulusan;
                return view('frontoffice.tracerstudy.pengisian.login', compact('untuk_lulusan'));
            } else {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }
    }
    

       /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginTCRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginTCRequest $request, $alias_url) 
    {

        try {
            $checkTC = PaketSoal::where('untuk_lulusan', $request->untuk_lulusan)->firstOrFail();

            $untuk_lulusan = $checkTC->untuk_lulusan;
            $alumni = Alumni::where('pin', $request->pin)->first();
          
            if($alumni !== null && $alumni->thn_lulus !== null){
                if($alumni->thn_lulus !== $untuk_lulusan){
                    throw ValidationException::withMessages([
                        'pin' => trans('logintc.errortahunlulus', [
                            'untuk_lulusan' => $untuk_lulusan,
                           
                        ]),
                    ]);
                }
                else if($alumni->thn_lulus == $untuk_lulusan){

                    $request['email'] = $alumni->email;
                    $request['password'] = $request->pin;
            
                    $request->authenticate();
            
                    $request->session()->regenerate();
            
                    return redirect()->route('kuesioner.tracerstudy-pengisian.index', $alias_url);
    
                }
                else{
                    throw ValidationException::withMessages([
                        'pin' => trans('logintc.errorsystem')
                    ]); 
                }
            }
            else{
                throw ValidationException::withMessages([
                    'pin' => trans('logintc.pinnotfound')
                ]);
            }


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
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('alumni')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('tracerstudy');
    }

    
}
