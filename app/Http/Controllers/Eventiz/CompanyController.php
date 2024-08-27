<?php

namespace App\Http\Controllers\Eventiz;

use Exception;
use App\Models\Event;
use App\Models\Review;
use App\Models\Company;
use App\Models\Services;
use App\Mail\SuccessMail;
use App\Rules\SameSizeAs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    //

    public function createCompanyForm(Request $request){
        
        $user = $request->user();
        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'Store company form',
                'user' => $user
                // 'Session Datas' => session()->all()
            ]); 
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Not connected, Please Login!'
            ]); 
        }
        
    }

    public function storeCompany(Request $request){
    
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        if($user && $user->role_id == 2){
            try{

                $request->validate([
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
                    'subscriptions_id' => $request->subscriptions_id,
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

    // Store Company Images for the profiles    
    public function storeCompanyImages(Request $request){
    
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        $userCompany = Company::where('users_id',$user->id)->first();

        if($user && $user->role_id == 2){
            try{

                $request->validate([
                    'images.*' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:5120', // Validation pour plusieurs images
                ]);

                // /*
                $imageData = [];
                $companyName = preg_replace('/\s+/', '_', $user->name);
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $fileName = $companyName . '_' . time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('companiesImages', $fileName, 'public');

                        // $imageData[] = [
                        //     'file_name' => $fileName,
                        //     'file_path' => $filePath,
                        //     'file_type' => $file->getClientMimeType(),
                        //     'file_size' => $file->getSize(),
                        // ];

                        
                        $imageData[] = [
                            'file_path' => $filePath
                        ];
                    }

                    $userCompany->update([
                        'images' => $imageData
                    ]);
                }else {
                    return response()->json([
                        'message'=> 'Error',
                        'error'=> 'Upload error, check your file(s) and try again',
                    ], 500);
                }
                // */
            } catch (Exception $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'You\'re been upload your company\'s images!.'
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
    
    //Company's services list
    public function storeCompanyServices(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
    
        if ($user && $user->role_id == 2) {
            // Récupération de l'entreprise de l'utilisateur
            $userCompany = Company::where('users_id', $user->id)->first();
    
            if ($userCompany) {
                try {
                    // Validation des données
                    $dataValidate = $request->validate([
                        'servicename' => 'bail|array|min:1', // Le tableau doit contenir au moins 1 élément
                        'servicename.*' => 'bail|string|min:1|required', // Valider chaque élément du tableau
                        'type' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        'type.*' => 'bail|required|string', // Valider chaque élément du tableau
                        'rate' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        'rate.*' => 'bail|required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Valider chaque élément du tableau
                        'duration' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        'duration.*' => 'bail|required|string', // Valider chaque élément du tableau
                        'service_price' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        'service_price.*' => 'bail|required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Valider chaque élément du tableau
                        'is_pay_by_hour' => ['bail', 'array', new SameSizeAs('servicename')], // yes or no
                        'is_pay_by_hour.*' => 'bail|required|string|min:2', // Valider chaque élément du tableau
                        'subdetails' => 'bail|string|nullable',
                        'travel' => 'bail|string|nullable',
                    ]);
    
                    // Accéder aux valeurs avec une valeur par défaut vide si la clé n'existe pas
                    $subdetails = $dataValidate['subdetails'] ?? "";
                    $travel = $dataValidate['travel'] ?? "";
    
                } catch (ValidationException $e) {
                    // Retourner les erreurs de validation
                    return response()->json([
                        'message' => 'Validation Error',
                        'errors' => $e->errors(),
                    ], 422);
                }
    
                // Boucle sur les services pour créer les devis
                foreach ($dataValidate['servicename'] as $index => $service) {
                    Services::create([
                        'company_id' => $userCompany->id, // Utilisation de l'entreprise de l'utilisateur
                        'servicename' => $service,
                        'type' => $dataValidate['type'][$index],
                        'rate' => $dataValidate['rate'][$index],
                        'duration' => $dataValidate['duration'][$index],
                        'service_price' => $dataValidate['service_price'][$index],
                        'is_pay_by_hour' => $dataValidate['is_pay_by_hour'][$index],
                        'subdetails' => $subdetails, // Utilisation de la valeur par défaut si la clé n'existe pas
                        'travel' => $travel, // Utilisation de la valeur par défaut si la clé n'existe pas
                    ]);
                }
    
                return response()->json([
                    'message' => 'Success',
                    'error' => 'Your services list has been registered!'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You need to be a vendor to add a service list!'
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'You need to be a vendor to add a service list!'
            ], 403);
        }
    }

    // View self company info as vendor 
    public function companyInformation(){
        $user = Auth::user();
        $company = Company::where('users_id', $user->id)->first();
        
        if ($company) {
            $companyWithoutUser = $company->makeHidden(['user']);
            $companyUser =  $user;
            $filesPath = [];
            foreach ($companyWithoutUser['images'] as $files) {
                $filesPath[] = asset('storage/'. $files['file_path']);
            }
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
                'Company Images:' => $filesPath,
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

    // View my reviews
    public function viewMyReviews(){
        $user = Auth::user();
        $myReview = Review::where('review_cible', $user->id)->orderBy('start_for_cibe', 'desc')->get();

        if(count($myReview) > 0){
            return response()->json([
               'status' => 200,
               'message' => 'My Reviews',
                'Reviews' => $myReview
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'My Reviews',
                 'Reviews' => 'No reviews yet !'
            ], 200);  // Not Found
        }

    }

    
    public function myEventStatistics(){
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        if($user){
            $pastEvents = Event::whereDate('start_date', '<', now()->format('Y-m-d'))
            ->where(function($query) use ($user) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($user->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($user->id)]);
            })->get();
            $futureEvents = Event::whereDate('start_date', '>', now()->format('Y-m-d'))
            ->where(function($query) use ($user) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($user->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($user->id)]);
            })->get();
            $currentEvents = Event::whereDate('start_date', '=', now()->format('Y-m-d'))
            ->where(function($query) use ($user) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($user->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($user->id)]);
            })->get();
            $activeEvents = Event::where('status', 'Yes')
            ->where(function($query) use ($user) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($user->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($user->id)]);
            })->get();

            return response()->json([
                'message'=> 'Success',
                 'Past Events ('. count($pastEvents) .')'=> count($pastEvents) > 0 ? $pastEvents : 0,
                 'Future Events ('. count($futureEvents) .')'=> count($futureEvents) > 0 ? $futureEvents : 0,
                 'Current Events ('. count($currentEvents) .')'=> count($currentEvents) > 0 ? $currentEvents : 0,
                 'Active Events ('. count($activeEvents) .')'=> count($activeEvents) > 0 ? $activeEvents : 0
             ], 200);
        }else{
            return response()->json([
               'message'=> 'Error',
                'error'=> 'You\'re not authorised to do this action!'
            ], 401);
        }
    }
    
}
