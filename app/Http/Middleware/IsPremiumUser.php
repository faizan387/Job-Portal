<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPremiumUser
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
        // middleware to protect the job creation request
        // if user without trial or subscription tries to access the job creation form
        // then redirect to subscribe route
        if ($request->user()->user_trial > date('Y-m-d') || $request->user()->billing_ends > date('Y-m-d')) {
            return $next($request);
        }
        return redirect()->route('subscribe')->with('infoMessage', 'Kindly subscribe to post a job');
    }
}
