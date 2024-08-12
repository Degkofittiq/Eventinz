<?php

namespace App\Http\Controllers\Eventiz\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => encrypt('my-google')
            ]
        );

        // Générer un token pour l'API
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }


    public function loginWithGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Rechercher l'utilisateur par email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Générer un token pour l'API
                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json(['token' => $token, 'user' => $user]);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
