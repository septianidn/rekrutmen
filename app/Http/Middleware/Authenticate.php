<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if($request->routeIs('kuesioner.*')){
                $uri = $request->getRequestUri();
                $replacement = str_replace('/tracerstudy/kuesioner/', '', $uri);
                return route('kuesioner.tracerstudy-login.create', $replacement);
            }
            elseif($request->routeIs('backoffice.*')){
                return route('login');
            }
        }
    }
}
