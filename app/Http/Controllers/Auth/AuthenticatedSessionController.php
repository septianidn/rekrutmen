<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // $user = Auth::user();

        //     // Redirect based on user role
        //     if ($user->hasRole('admin')) {
        //         return redirect()->route('admin.dashboard');
        //     } elseif ($user->hasRole('vendor')) {
        //         return redirect()->route('vendor.dashboard');
        //     } else {
        //         return redirect()->route('user.dashboard');
        //     }

        // return redirect(RouteServiceProvider::HOME);
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user()->user_type;

            // Redirect based on user role
            if ($user == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user == 'employer') {
                return redirect()->route('employer.profile');
            } elseif ($user == 'mahasiswa') {
                return redirect()->route('jobseeker.index');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/backoffic3');
    }
}
