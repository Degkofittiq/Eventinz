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

            $actionMapping = [
                'admin.login' => 'User logged in',
                'admin.logout' => 'User logged out',
                'admin.addlog.supporthelp' => 'User requested support help',
                'admin.delete.category' => 'Category deleted',
                'admin.update.category' => 'Category updated',
                'admin.store.category' => 'New category created',
                'admin.update.company' => 'Company details updated',
                'admin.update.companyservices' => 'Company services updated',
                'admin.delete.companyservices' => 'Company services deleted',
                'admin.store.servicescategory' => 'New services category created',
                'admin.update.servicescategory' => 'Services category updated',
                'admin.store.subscriptionplan' => 'New subscription plan created',
                'admin.update.subscriptionplan' => 'Subscription plan updated',
                'admin.delete.subscriptionplan' => 'Subscription plan deleted',
                'admin.update.event' => 'Event updated',
                'admin.add.eventtype' => 'New event type created',
                'admin.update.eventtype' => 'Event type updated',
                'admin.delete.eventtype' => 'Event type deleted',
                'admin.add.eventsubcategory' => 'New event subcategory created',
                'admin.update.eventsubcategory' => 'Event subcategory updated',
                'admin.delete.eventsubcategory' => 'Event subcategory deleted',
                'admin.update.review' => 'Review updated',
                'admin.resend.otp' => 'OTP resent by Admin',
                'admin.add.contenttext' => 'New content text added',
                'admin.update.contenttext' => 'Content text updated',
                'admin.add.contentimage' => 'New content image added',
                'admin.update.contentimage' => 'Content image updated',
                'admin.add.vendorclass' => 'New vendor class added',
                'admin.update.vendorclass' => 'Vendor class updated',
                'admin.add.paymenttaxe' => 'New payment tax added',
                'admin.update.paymenttaxe' => 'Payment tax updated',
                'admin.delete.paymenttaxe' => 'Payment tax deleted',
                'admin.add.adminuser' => 'New admin user added',
                'admin.update.adminuser' => 'Admin user updated',
                'user.updateAccountStatus' => 'User account status updated',
                'admin.set.datalimit' => 'Data limit set',
                'admin.add.eventviewstatus' => 'New event view status added',
                'admin.update.eventviewstatus' => 'Event view status updated',
                'admin.delete.eventviewstatus' => 'Event view status deleted',
                'admin.add.right' => 'New admin right added',
            ];
            
        // Récupérer le nom de la route actuelle
        $routeName = $request->route()->getName();
        
        // Vérifier si l'action est définie dans la liste
        $actionDescription = isset($actionMapping[$routeName]) ? $actionMapping[$routeName] : 'Action Description not set';

            // Supprimer le champ _token des données envoyées
            $inputData = $request->except('_token');
            if ($request->method() == 'POST') {
                AdminActionLog::create([
                    'user_id' => auth()->user() ? auth()->user()->id : null,
                    'action' => $actionDescription,  // Action lisible par l'utilisateur
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
