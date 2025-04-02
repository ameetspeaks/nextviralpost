<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class FirebaseAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$request->bearerToken()) {
                return response()->json(['message' => 'No token provided'], 401);
            }

            $auth = app('firebase.auth');
            $verifiedIdToken = $auth->verifyIdToken($request->bearerToken());
            $uid = $verifiedIdToken->claims()->get('sub');

            $user = User::where('firebase_uid', $uid)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            Auth::login($user);
            return $next($request);
        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }
} 