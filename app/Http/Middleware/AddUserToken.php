<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AddUserToken
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est authentifié
        if (Auth::user()) {
            // Récupère le token d'accès
            $token = Auth::user()->createToken('Personal Access Token')->plainTextToken ? Auth::user()->createToken('Personal Access Token')->plainTextToken : null;
            // Partage le token avec toutes les vues
            View::share('userToken', $token);
            // dd($token);
        }

        return $next($request);
    }
}
