<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSeeker
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
        if ($request->user()->user_type === 'seeker') {
            return $next($request);
        }
        return redirect()->route('dashboard')->with('errorMessage', 'Not authorized to access this page');
    }
}
