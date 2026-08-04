<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view($request->routeIs('user.*')
            ? 'frontoffice.auth.forgot-password'
            : 'auth.recoverpw');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        }

        // Frontoffice (employer/jobseeker): kembali ke form dengan pesan sukses
        // berbahasa Indonesia. Backoffice tetap memakai halaman konfirmasi bawaan.
        if ($request->routeIs('user.*')) {
            return redirect()->route('user.password.request')
                ->with('status', 'Tautan untuk mengatur ulang kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk Anda.');
        }

        return view('auth.confirm-mail')->with(['status' => __($status), 'email' => $request->email]);
    }
}
