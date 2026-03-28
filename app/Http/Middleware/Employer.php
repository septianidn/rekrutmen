<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Employer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            
            
            if(! Auth::guard('employer')->check()){
                throw ValidationException::withMessages(["message" => "Silahkan login sebagai Employer"]);
                    return redirect()->route('landingpage');
            }
            else{
                return $next($request);
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }
    }
}
