<?php

namespace App\Http\Controllers\Auth\EmployerAuth;

use App\Models\User;
use App\Models\Jobseeker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:employer,mahasiswa',
            'jobseeker_type_id' => 'required_if:role,mahasiswa|nullable|exists:jobseeker_type,id',
        ]);

        $isJobseeker = $request->role === 'mahasiswa';

        $user = User::create([
            'first_name' => '-',
            'last_name' => '-',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $isJobseeker ? 'mahasiswa' : 'employer',
            'status' => 'active',
        ]);

        $user->assignRole($isJobseeker ? 'mahasiswa' : 'employer');

        if ($isJobseeker) {
            Jobseeker::create([
                'user_id' => $user->id,
                'first_name' => '-',
                'last_name' => '-',
                'jobseeker_type_id' => $request->jobseeker_type_id,
            ]);
        }

        Auth::login($user);

        return redirect()->route($isJobseeker ? 'jobseeker.index' : 'employer.cek_verifikasi');
    }

    public function destroy(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    
}