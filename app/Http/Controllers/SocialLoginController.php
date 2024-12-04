<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, config('auth.socialite.drivers'), true)) {
            abort(404, 'Social Provider is not supported');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        if (!in_array($provider, config('auth.socialite.drivers'), true)) {
            abort(404, 'Social Provider is not supported');
        }

        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser = new User;
            $newUser->provider_name = $provider;
            $newUser->provider_id = $user->getId();
            $newUser->name = $user->getName();
            $newUser->email = $user->getEmail();
            $newUser->email_verified_at = now();
            $newUser->avatar = $user->getAvatar();
            $newUser->save();

            auth()->login($newUser, true);
        }

        return redirect()->route('dashboard');
    }
}
