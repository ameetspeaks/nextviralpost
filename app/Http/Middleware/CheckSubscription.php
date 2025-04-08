<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    protected $excludedRoutes = [
        'subscription.select',
        'subscription.trial',
        'subscription.purchase',
        'subscription.manage',
        'subscription.analytics',
        'subscription.cancel',
        'post-generator.index' // Add this to allow access to post generator without subscription
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip subscription check for excluded routes
        if (in_array($request->route()->getName(), $this->excludedRoutes)) {
            return $next($request);
        }

        $user = $request->user();

        if (!$user || !$user->activeSubscription) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Please subscribe to access this feature.'
                ], 402);
            }
            
            return redirect()->route('subscription.select')
                ->with('error', 'Please subscribe to access this feature.');
        }

        return $next($request);
    }
} 