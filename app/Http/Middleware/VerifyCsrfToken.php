<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',  // Exclure toutes les routes API de la protection CSRF
        'register',
        'verify-otp',
        // Ajoutez d'autres routes spécifiques ici si nécessaire
    ];
}
