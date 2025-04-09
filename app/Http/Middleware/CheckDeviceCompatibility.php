<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeviceCompatibility
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/(android|iphone|ipad|mobile)/i', $userAgent);

        $allowedRoutes = ['device-compatibility', 'register', 'onboarding'];

        if ($isMobile && !$request->is($allowedRoutes)) {
            return redirect()->route('device.compatibility');
        }

        return $next($request);
    }
} 