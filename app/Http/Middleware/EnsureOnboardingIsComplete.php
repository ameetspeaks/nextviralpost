<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOnboardingIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->hasCompletedOnboarding()) {
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
} 