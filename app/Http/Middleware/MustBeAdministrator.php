<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // handles situations in which auth()->user() returns null
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        
        if (auth()->user()->email !== 'mdrobert80@gmail.com') {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
