<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $user = Auth::user();

        if (!$user) {
            if (request()->is('admin.dashboard')) {
                // Rediriger vers la page de connexion admin
                return redirect()->route('adminlogin'); 
            } else {

                return redirect('login');
            }
        }

        // Assuming the user has a `rights` relationship that returns the rights as a collection
        $userRights = Auth::user()->right;
        
        foreach ($rights as $singleRight) {
            if (!in_array($singleRight, $userRights)) {
                return back()->with("error", "You aren't able to access to this functionnality");
            }
        }
        
        return $next($request);
    }
}
