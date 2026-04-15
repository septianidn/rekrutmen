<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompleteProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        if (!$employer) {
            return redirect()->route('employer.cek_verifikasi')
                ->with('error', 'Silakan lengkapi data perusahaan Anda terlebih dahulu.');
        }

        if ($employer->verification_status !== 'approved') {
            return redirect()->route('employer.cek_verifikasi');
        }

        return $next($request);
    }
}
