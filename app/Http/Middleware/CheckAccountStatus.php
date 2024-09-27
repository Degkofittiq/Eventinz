<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
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
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            // Vérifier si le status du compte est 'Activate'
            if (Auth::user()->account_status !== 'Activate') {
                // Vérifier si la route est une route API
                if ($request->is('api/*')) {
                    // Retourner une réponse JSON pour les routes API
                    return response()->json([
                        'error' => 'Your account is Disactivated. Please contact the administrator.'
                    ], 403); // 403 Forbidden
                } else {
                    // Rediriger vers la page de login avec une erreur pour les routes Web
                    return redirect()->route('login')->with('error', 'Your account is Disactivated. Please contact the administrator.');
                }
            }
        }

        return $next($request);
    }
}
