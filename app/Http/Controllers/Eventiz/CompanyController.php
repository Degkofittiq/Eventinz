<?php

namespace App\Http\Controllers\Eventiz;

use Exception;
use App\Models\Company;
use App\Mail\SuccessMail;
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
            'user' => $user->id,
            // 'Session Datas' => session()->all()
        ]); 
    }

    public function storeCompany(Request $request){
    
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        if($user && $user->role_id == 2){
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

                //Get a subscription Id to process to the payment
                session([
                    'subscriptions_id' => $request->input('subscriptions_id')
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }

            
            $successMsg = 'You\'re been registered with your company! You will receive a confirmation email shortly.';

            // Envoyer un mail de confirmation
            Mail::to($user->email)->send(new SuccessMail($successMsg));

            return response()->json([
                'status' => 200,
                'message' => 'You\'re been registered with your company. Now you will be redirect to payment page.'
            ]); 
        }elseif ($user && $user->role_id != 2) {
            return response()->json([
               'status' => 401,
               'message' => 'Unauthorized, you need to be a vendor!'
            ], 401);  // Unauthorized
        }else{
            return response()->json([
               'status' => 401,
               'message' => 'Unauthorized, you need to be connected!'
            ], 401);  // Unauthorized
        }
    }

    public function companyInformation(){
        $user = Auth::user();
        $company = Company::where('users_id', $user->id)->first();
        
        if ($company) {
            $companyWithoutUser = $company->makeHidden(['user']);
            $companyUser =  $user;
        }


        if($user->role_id == 2 && $company){
            return response()->json([
               'status' => 200,
               'message' => 'Company summary information',
               'company' => [
                'Company Name:' => $companyWithoutUser['name'],
                'Company country:' => $companyWithoutUser['country'],
                'Company State:' => $companyWithoutUser['state'],
                'Company Service type:' => $companyWithoutUser['vendor_service_types_id'] == 2 ? 'Multiple Service' : 'Single Service', //single or multiple
                'Company Vendor categories:' => $companyWithoutUser['vendor_categories_id'],
                'Company Current subscriptions:' => $companyWithoutUser['subscriptions_id'],
                'Company Subscription start date:' => $companyWithoutUser['subscription_start_date'],
                'Company Subscription end date:' => $companyWithoutUser['subscription_end_date'],
            ],
               'Company Vendor' => [
                'username' => $companyUser['username'],
                'profile_image' => $companyUser['profile_image'],
                'location' => $companyUser['location'],
                ]
            ]); 
        }elseif ($user->role_id == 2 && !$company) {
            return response()->json([
               'status' => 404,
               'message' => 'You dont have a company yet, would you like register your company?'
            ], 404);  // Not Found
        }
        else{
            return response()->json([
               'status' => 404,
               'message' => 'You\'re not authorized to do this action, you need to be a vendor!'
            ], 404);  // Not Found
        }
    }
}
