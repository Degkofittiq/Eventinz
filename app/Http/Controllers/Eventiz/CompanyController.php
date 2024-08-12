<?php

namespace App\Http\Controllers\Eventiz;

use Exception;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    //

    public function createCompanyForm(Request $request){
        
        $user = $request->user();
        return response()->json([
            'status' => 200,
            'message' => 'Store company form',
            'user' => $user
        ]); 
    }

    public function storeCompany(Request $request){
    
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        if($user){
            try{

                $request->validate([
                    // 'users_id' => 'required|integer',
                    'name' => 'required|string', //company information start here
                    'country' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'vendor_service_types_id' => 'required|integer',
                    'vendor_categories_id' =>[ 
                        'required',
                        'array',
                        'min:1',
                        'max:3',
                        'distinct'
                    ], 
                    'subscriptions_id' => 'required|integer', // Subscription plan
                ]);

                $company = Company::create([
                    'users_id' => $user->id,
                    'name' => $request->name, 
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'vendor_service_types_id' => $request->vendor_service_types_id,
                    'vendor_categories_id' =>  json_encode($request->vendor_categories_id),
                    'subscriptions_id' => $request->subscriptions_id
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }

            // Mail::to($request->email)->send(new ForgotPasswordMail($resetOTP));

            return response()->json([
                'status' => 200,
                'message' => 'You\'re been registered with your company.'
            ]); 
        }else{
            return response()->json([
               'status' => 401,
               'message' => 'Unauthorized, you need to be connected'
            ], 401);  // Unauthorized
        }
    }
}
