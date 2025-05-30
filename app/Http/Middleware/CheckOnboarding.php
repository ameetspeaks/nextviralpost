<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip onboarding check for onboarding routes
        if ($request->is('onboarding*')) {
            return $next($request);
        }

        // Redirect to onboarding if not completed
        if ($user && !$user->hasCompletedOnboarding()) {
            return redirect()->route('onboarding.show');
        }

        return $next($request);
    }
} 