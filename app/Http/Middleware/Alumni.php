<?php

namespace App\Http\Middleware;

use App\Models\PaketSoal;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Alumni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $record = PaketSoal::where('untuk_lulusan', $request->input('untuk_lulusan'))->firstOrFail();
            $untuk_lulusan = $record->untuk_lulusan;

            if(! Auth::guard('alumni')->check()){
                throw ValidationException::withMessages([
                        'pin' => trans('logintc.loginfirst')
                    ]);
                    return redirect()->route('tracerstudy-login.create', ['untuk_lulusan' => $untuk_lulusan]);
            }
            else{
                return $next($request);
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); 
        }

       
    }
}
