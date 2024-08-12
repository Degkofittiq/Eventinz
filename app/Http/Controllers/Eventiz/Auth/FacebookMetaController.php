<?php

namespace App\Http\Controllers\Eventiz\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookMetaController extends Controller
{
    //

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            // Récupérer l'utilisateur de Facebook
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
    
            // Rechercher l'utilisateur par Facebook ID ou email
            $user = User::where('facebook_id', $facebookUser->id)
                ->orWhere('email', $facebookUser->email)
                ->first();
    
            if ($user) {
                // Si l'utilisateur existe, mettre à jour les informations
                $user->update([
                    'facebook_id' => $facebookUser->id,
                    'name' => $facebookUser->name,
                ]);
            } else {
                // Sinon, créer un nouvel utilisateur
                $user = User::create([
                    'facebook_id' => $facebookUser->id,
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'password' => bcrypt(Str::random(24)), // Générer un mot de passe aléatoire
                ]);
            }
    
            // Connecter l'utilisateur
            Auth::login($user);
    
            // Générer un token d'accès pour l'utilisateur connecté
            $token = $user->createToken('MyApp')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
