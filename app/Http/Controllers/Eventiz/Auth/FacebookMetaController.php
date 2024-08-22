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
         // Stocker le role de l'utilisateur
         session([
            'role_id_expiration_time' => now()->addMinutes(10)
        ]);
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            // Récupérer l'utilisateur de Facebook
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
    
            
            // Vérifier si l'role_id a expiré 
            $role_idExpiresAt = session('role_id_expiration_time');

            if (now()->greaterThan($role_idExpiresAt)) {
                return response()->json(['message' => 'Session has expired, you will be redirect'], 400);
            }

            $userType = session('role_id');

            $generic_id = "EVT-" . rand(100000, 999999);
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
                        'generic_id' => $generic_id,
                        'username' => "@".$facebookUser->name,
                        'role_id' =>  session('role_id'),
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

            // Retourner le token et les informations de session
            return response()->json([
                'token' => $token,
                'role_id' => session('role_id'),
                'role_id_expiration_time' => session('role_id_expiration_time')
            ], 200);
    
            // return response()->json(['token' => $token], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
