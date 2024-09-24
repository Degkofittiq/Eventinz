<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Right;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  ...$rights
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$rights)
    {
        // return $next($request);
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
        $userRights = json_decode(Auth::user()->rights);

        // $rights = Right::all();
        // dd($rights);
        foreach ($rights as $singleRight) {
            if (!in_array($singleRight, $userRights)) {
                return back()->with("error", "You aren't able to access to this functionnality");
            }
        }
        
        return $next($request);
    }
}
