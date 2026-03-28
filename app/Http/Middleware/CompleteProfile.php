<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $employer = Employer::where('user_id', $user->id)->join('industri_type','industri_type.id', 'employer.industriType_id')->join('users', 'users.id', 'user_id')->first();

        

        // Cek apakah field 'profile_completed' sudah diisi
        if (!$employer) {
            return redirect()->route('employer.cek_verifikasi')->with('error', 'Silakan lengkapi data Anda terlebih dahulu.');
        }
        return $next($request);
    }
}
