<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Find or create user
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'full_name' => $socialUser->getName(),
                    'firebase_uid' => $socialUser->getId(),
                    'is_profile_complete' => false,
                ]);
            }

            // Store social media tokens
            $user->update([
                $provider . '_token' => $socialUser->token,
                $provider . '_refresh_token' => $socialUser->refreshToken,
                $provider . '_expires_in' => $socialUser->expiresIn,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social media authentication failed.');
        }
    }

    public function postToSocialMedia(Request $request, $provider)
    {
        $user = Auth::user();
        $content = $request->input('content');

        try {
            switch ($provider) {
                case 'facebook':
                    return $this->postToFacebook($user, $content);
                case 'twitter':
                    return $this->postToTwitter($user, $content);
                case 'linkedin':
                    return $this->postToLinkedIn($user, $content);
                default:
                    return response()->json(['error' => 'Unsupported social media platform'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function postToFacebook($user, $content)
    {
        // Implement Facebook posting logic
        // You'll need to use the Facebook Graph API
        return response()->json(['message' => 'Posted to Facebook successfully']);
    }

    protected function postToTwitter($user, $content)
    {
        // Implement Twitter posting logic
        // You'll need to use the Twitter API
        return response()->json(['message' => 'Posted to Twitter successfully']);
    }

    protected function postToLinkedIn($user, $content)
    {
        // Implement LinkedIn posting logic
        // You'll need to use the LinkedIn API
        return response()->json(['message' => 'Posted to LinkedIn successfully']);
    }
} 