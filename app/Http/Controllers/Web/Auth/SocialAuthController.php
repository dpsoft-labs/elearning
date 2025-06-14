<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Jobs\Welcome_mailJob;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToTwitter(): RedirectResponse
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('social_id', $user->id)->orWhere('email', $user->email)->first();

        // return json_encode($user->token);
        if ($existingUser) {
            // Check if the email is not verified yet, then update it to mark it as verified.
            if (!$existingUser->email_verified_at) {
                $existingUser->email_verified_at = now();
                $existingUser->save();
            }
            // Log in the existing user.
            auth()->login($existingUser, true);
        } else {
            $name = $user->name;
            $nameParts = explode(' ', $name);
            if (count($nameParts) >= 2) {
                $firstname = $nameParts[0];
                $lastname = implode(' ', array_slice($nameParts, 1));
            } else {
                $firstname = $lastname = $name;
            }
            $newUser = new User();
            $newUser->firstname = $firstname;
            $newUser->lastname = $lastname;
            $newUser->email = $user->email;
            $newUser->social_id = $user->id;
            $newUser->password = bcrypt(request(Str::random())); // Set some random password
            $newUser->email_verified_at = now();
            $newUser->save();

            $username = $newUser->firstname;
            $email = $newUser->email;
            Welcome_mailJob::dispatch($username, $email);

            // Log in the new user.
            auth()->login($newUser, true);
        }

        // Redirect to url as requested by user, if empty use /dashboard page as generated by Jetstream
        return redirect()->intended('/home');
    }

    public function handleFacebookCallback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->user();

        $existingUser = User::where('social_id', $user->id)->orWhere('email', $user->email)->first();

        if ($existingUser) {
            // Check if the email is not verified yet, then update it to mark it as verified.
            if (!$existingUser->email_verified_at) {
                $existingUser->email_verified_at = now();
                $existingUser->save();
            }
            // Log in the existing user.
            auth()->login($existingUser, true);
        } else {
            $name = $user->name;
            $nameParts = explode(' ', $name);
            if (count($nameParts) >= 2) {
                $firstname = $nameParts[0];
                $lastname = implode(' ', array_slice($nameParts, 1));
            } else {
                $firstname = $lastname = $name;
            }
            $newUser = new User();
            $newUser->firstname = $firstname;
            $newUser->lastname = $lastname;
            $newUser->email = $user->email;
            $newUser->social_id = $user->id;
            $newUser->password = bcrypt(request(Str::random())); // Set some random password
            $newUser->email_verified_at = now();
            $newUser->save();

            $username = $newUser->firstname;
            $email = $newUser->email;
            Welcome_mailJob::dispatch($username, $email);

            // Log in the new user.
            auth()->login($newUser, true);
        }

        // Redirect to url as requested by user, if empty use /dashboard page as generated by Jetstream
        return redirect()->intended('/home');
    }
    public function handleTwitterCallback(): RedirectResponse
    {

        $user = Socialite::driver('twitter')->user();


        $existingUser = User::where('social_id', $user->id)->orWhere('email', $user->email)->first();

        if ($existingUser) {
            // Check if the email is not verified yet, then update it to mark it as verified.
            if (!$existingUser->email_verified_at) {
                $existingUser->email_verified_at = now();
                $existingUser->save();
            }
            // Log in the existing user.
            auth()->login($existingUser, true);
        } else {
            $name = $user->name;
            $nameParts = explode(' ', $name);
            if (count($nameParts) >= 2) {
                $firstname = $nameParts[0];
                $lastname = implode(' ', array_slice($nameParts, 1));
            } else {
                $firstname = $lastname = $name;
            }
            $newUser = new User();
            $newUser->firstname = $firstname;
            $newUser->lastname = $lastname;
            $newUser->email = $user->email;
            $newUser->social_id = $user->id;
            $newUser->password = bcrypt(request(Str::random())); // Set some random password
            $newUser->email_verified_at = now();
            $newUser->save();

            $username = $newUser->firstname;
            $email = $newUser->email;
            Welcome_mailJob::dispatch($username, $email);

            // Log in the new user.
            auth()->login($newUser, true);
        }
        return redirect()->intended('home');
    }
}