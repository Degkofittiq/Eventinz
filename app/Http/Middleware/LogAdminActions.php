<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\Models\AdminActionLog;

class LogAdminActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Vérifier si la route a le préfixe 'admin'
        if ($request->is('admin/*')) {
            // Exemple : Vous pouvez enregistrer l'action dans les logs ou dans la base de données
            // Log::info('Admin action', [
            //     'user_id' => auth()->user() ? auth()->user()->id : null,
            //     'path' => $request->path(),
            //     'method' => $request->method(),
            //     'input' => $request->all(),
            //     'timestamp' => now(),
            // ]);

            // Supprimer le champ _token des données envoyées
            $inputData = $request->except('_token');
            if ($request->method() == 'POST') {
                AdminActionLog::create([
                    'user_id' => auth()->user() ? auth()->user()->id : null,
                    'path' => $request->path(),
                    'method' => $request->method(),
                    'input' => json_encode($inputData),  
                    'created_at' => now(),
                ]);
            }


            // Vous pouvez aussi enregistrer ces informations dans une base de données
            // \App\Models\AdminActionLog::create([...]);
        }

        return $next($request);
    }
}
