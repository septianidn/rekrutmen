<?php

namespace App\Http\Controllers\Auth\EmployerAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\EmployerAuth\LoginEmployerRequest;


class AuthenticatedSessionController extends Controller
{
 
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {    
        try {
    
            
        // return view('frontoffice.tracerstudy.pengisian.login', compact('untuk_lulusan', 'paketSoal','assets'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }
    }
    

       /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\EmployerAuth\LoginTCRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginEmployerRequest $request) 
    {
        
        try {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            // throw ValidationException::withMessages([
            //     'pin' => trans('logintc.errorsystem'),
            // ]);
           dd($e);
        }
        

    }


    public function destroy(Request $request) 
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    
}