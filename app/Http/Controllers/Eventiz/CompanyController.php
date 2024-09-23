<?php

namespace App\Http\Controllers\Eventiz;

use Exception;
use App\Models\Event;
use App\Models\Review;
use App\Models\Company;
use App\Models\Services;
use App\Mail\SuccessMail;
use App\Rules\SameSizeAs;
use App\Models\PaymentTaxe;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\VarriablesLimit;
use App\Models\VendorCategories;
use App\Models\VendorServiceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\CurrencyConversionService;

class CompanyController extends Controller
{
    //
    private $currencyConversionService;
    private $currentCurrency = 'USD';
    private $symbol = '$';

    public function __construct( CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }


    public function vendorClasses(){
        $data = [];
        $vendorClasses = VendorServiceType::all()->makeHidden(['created_at', 'updated_at']);
        foreach ($vendorClasses as $vendorClass) {
            $vendorClassData = $vendorClass->toArray(); // Convertir en tableau
            $vendorClassData['features'] = json_decode($vendorClass->features); // Décoder les 'features'
            $data[] = $vendorClassData;
        }
        return response()->json($data);
    }

    public function vendorClass(Request $request, $vendorClassId){
        $vendorClass = VendorServiceType::find($vendorClassId);
        if($vendorClass){
            $vendorClassData = $vendorClass->makeHidden(['created_at', 'updated_at'])->toArray(); // Convertir en tableau
            $vendorClassData['features'] = json_decode($vendorClass->features); // Décoder les 'features'
            return response()->json($vendorClassData);
        }else{
            return response()->json([
                'error' => 'Vendor class not found'
            ]);
        }
    }


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

        if($user && $user->role_id != 1){
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

    // Subscription
    public function subscriptionList(){
        // get all subscription list
        $singleServiceSubscriptions = Subscription::where('vendor_service_types_id', 1)->get();
        $multipleServiceSubscriptions = Subscription::where('vendor_service_types_id', 2)->get();

        return response()->json([
            'status' => 200,
            'Single Service' => $singleServiceSubscriptions,
            'Multiple Service' => $multipleServiceSubscriptions
        ]);
    }
  
    public function getCurrentCorrency() {
        $userLocation = Auth::user()->location ?? "United States";
        $url = 'https://restcountries.com/v3.1/all';

        // Initialiser cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        // Gestion des erreurs cURL
        if ($response === false) {
            die('Erreur cURL : ' . curl_error($ch));
        }

        curl_close($ch);

        // Décodage du JSON
        $countries = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Erreur de décodage JSON : ' . json_last_error_msg());
        }

        // Vérifier si $countries est un tableau
        if (!is_array($countries)) {
            die('Erreur: Les données des pays ne sont pas au format attendu.');
        }

        // Trier les pays
        usort($countries, function ($a, $b) {
            return strcmp($a['name']['common'], $b['name']['common']);
        });

        // Parcourir les pays
        foreach ($countries as $country) {
            $countryName = $country['name']['common'];
            $currencyCode = isset($country['currencies']) ? array_key_first($country['currencies']) : 'N/A';
            $currencySymbol = isset($country['currencies'][$currencyCode]['symbol']) ? $country['currencies'][$currencyCode]['symbol'] : 'N/A';

            if (strtolower($countryName) == strtolower($userLocation)) {
                // Assigner les valeurs aux propriétés
                $this->currentCurrency = $currencyCode;
                $this->symbol = $currencySymbol;
                break;
            }
        }

        return [
            'currency' => $this->currentCurrency,
            'symbol' => $this->symbol
        ];
    }

    // Fonction pour accéder à la devise et au symbole
    public function testCurrency() {

        // Call the getCurrentCorrency function to get values 
        $currencyData = $this->getCurrentCorrency();

        // Get currency and Symbol
        $currentCurrency = $currencyData['currency'];
        $symbol = $currencyData['symbol'];

        // Use values
        // return "Devise actuelle : " . $this->currentCurrency . ", Symbole : " . $this->symbol;
    }

    public function subscriptionChoose(Request $request, $subscriptionId){
        $subcription = Subscription::where('id',  $subscriptionId)->first();

        // dd($taxe->value);
        if ($subcription) {
            
            $subcription = $subcription->makeHidden(['created_at', 'updated_at']);
            $taxe = PaymentTaxe::where('id',1)->first();

            // Call the getCurrentCorrency function to get values 
            $currencyData = $this->getCurrentCorrency();
    
            // Get currency and Symbol
            $currentCurrency = $currencyData['currency'];
            $symbol = $currencyData['symbol'];
            $subcription['priceConvert'] = round($this->currencyConversionService->convert($subcription['price'] , 'USD', $this->currentCurrency),2);
            $subcription['conversionCurrency'] =  $this->currentCurrency;

            if ($taxe) {
                $subcription['taxe'] = round($subcription['price'] * ($taxe->value / 100), 2);
                $subcription['taxeConvert'] = round($this->currencyConversionService->convert($subcription['taxe'] , 'USD', $this->currentCurrency),2);
            }else {
                $subcription['taxe'] = 0;
            }
            return response()->json([
                'status' => 200,
                'Subscription choose' => $subcription
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' =>  'Subscription not found'
            ],400);
        }
        
    }

    //update Company Location
    public function updateCompanyLocation(Request $request){
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        $userCompany = Company::where('users_id',$user->id)->first();

        if($user && $user->role_id != 1){
            try{
                $locationValidation = $request->validate([
                    'country' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'city' => 'required|string|max:100',
                ]);
                
                $userCompany->update([
                    'country' => $locationValidation['country'],
                    'state' => $locationValidation['state'],
                    'city' => $locationValidation['city']
                ]);
               
                // */
            } catch (Exception $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'You\'re been update company\'s Location!.'
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
    
    public function storeCompanyImages(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        $userCompany = Company::where('users_id', $user->id)->first();
        if (!$userCompany) {
            return response()->json([
                'status' => 400,
                'message' => "You don't have company yet."
            ], 400);
        }
        $validationLimit = VarriablesLimit::where('name', 'images')->first();
        
        // Vérifier que l'utilisateur est connecté et qu'il n'a pas un rôle administrateur (role_id != 1)
        if ($user && $user->role_id != 1) {
            try {
                // Limite du nombre d'images, avec une valeur par défaut de 10 si non spécifiée
                $maxImages = $validationLimit->value ?? 10;
    
                // Récupérer les images existantes de l'entreprise (si elles existent)
                $existingImages = [];
                if ($userCompany->images) {
                    $existingImages = json_decode($userCompany->images, true) ?? [];
                }
                
                // Validation pour le nombre total d'images (existantes + nouvelles)
                if (count($existingImages) + count($request->file('images', [])) > $maxImages) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Vous ne pouvez pas télécharger plus de $maxImages images au total."
                    ], 400);
                }
    
                // Valider les fichiers d'images
                $request->validate([
                    'images.*' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:5120', // Validation pour plusieurs images
                ]);
    
                $companyName = preg_replace('/\s+/', '_', $user->name);
    
                // Vérifier la présence d'images
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $fileName = $companyName . '_' . uniqid() . '_' . $file->getClientOriginalName();
    
                        // Stocker l'image dans S3
                        $filePath = Storage::disk('s3')->putFileAs('companiesImages', $file, $fileName);
                        // Récupérer l'URL complète du fichier sur S3
                        $fullUrl = Storage::disk('s3')->url($filePath);
    
                        // Ajouter les données de l'image aux existantes
                        $existingImages[] = [
                            'file_path' => json_decode($fullUrl)
                        ];
                    }
    
                    // Mettre à jour le champ `images` de la compagnie avec toutes les images (anciennes + nouvelles) en JSON
                    $userCompany->update([
                        'images' => $existingImages //  Encodage en JSON
                    ]);
    
                    // Réponse de succès
                    return response()->json([
                        'status' => 200,
                        'message' => 'Images uploadées avec succès pour votre entreprise !'
                    ], 200);
                } else {
                    // Aucune image n'a été trouvée dans la requête
                    return response()->json([
                        'status' => 400,
                        'message' => 'Aucune image à télécharger. Veuillez vérifier vos fichiers.'
                    ], 400);
                }
            } catch (Exception $e) {
                // Gestion des erreurs
                return response()->json([
                    'status' => 500,
                    'message' => 'Erreur lors du téléchargement des images.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } elseif ($user && $user->role_id != 2) {
            // L'utilisateur n'est pas un vendeur (vendor)
            return response()->json([
                'status' => 401,
                'message' => 'Accès non autorisé. Vous devez être un vendeur !'
            ], 401); // Unauthorized
        } else {
            // L'utilisateur n'est pas connecté
            return response()->json([
                'status' => 401,
                'message' => 'Accès non autorisé. Vous devez être connecté !'
            ], 401); // Unauthorized
        }
    }
    
    
    

    public function storeCompanyTagline(Request $request){

        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        $userCompany = Company::where('users_id',$user->id)->first();
        $validationLimit = VarriablesLimit::where('name', 'tagline')->first();

        if($user && $user->role_id != 1){
            try{
                
                $taglineValidation = $request->validate([
                    'tagline' => 'required|string|max:' . ($validationLimit->value ?? '255'), // Validation pour Tagline
                ]);
                

                $userCompany->update([
                    'tagline' => $taglineValidation['tagline']
                ]);
               
                // */
            } catch (Exception $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'You\'re been update company\'s Tagline!.'
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
    
        if ($user && $user->role_id != 1) {
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
                        // 'duration' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        // 'duration.*' => 'bail|required|string', // Valider chaque élément du tableau
                        // 'service_price' => ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                        // 'service_price.*' => 'bail|required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Valider chaque élément du tableau
                        // 'is_pay_by_hour' => ['bail', 'array', new SameSizeAs('servicename')], // yes or no
                        // 'is_pay_by_hour.*' => 'bail|required|string|min:2', // Valider chaque élément du tableau
                        'subdetails' => 'bail|string|nullable',
                        // 'travel' => 'bail|string|nullable',
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
                        // 'duration' => $dataValidate['duration'][$index],
                        // 'service_price' => $dataValidate['service_price'][$index],
                        // 'is_pay_by_hour' => $dataValidate['is_pay_by_hour'][$index],
                        'subdetails' => $subdetails, // Utilisation de la valeur par défaut si la clé n'existe pas
                        // 'travel' => $travel, // Utilisation de la valeur par défaut si la clé n'existe pas
                    ]);
                }
    
                return response()->json([
                    'message' => 'Success',
                    'error' => 'Your services list has been registered!'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You need have a company before add a service list!'
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
        $companyServices = [];
        $companyServicesArray = [];
        $filesPath = [];
        if ($company) {
            $companyServices = Services::where('company_id',$company->id)->get();
        }
        
        if ($company) {
            $companyWithoutUser = $company->makeHidden(['user']);
            $companyUser =  $user;

            if ($company->images) {
                // dd(json_decode($companyWithoutUser['images']));
                foreach (json_decode($companyWithoutUser['images'], true) as $files) {
                    $filesPath[] = $files['file_path'];
                }
            }
            
            $vendorCategoryIds = json_decode($company->vendor_categories_id, true);
            // Récupération des noms des catégories de vendeur
            $company->vendorCategories = VendorCategories::whereIn('id', $vendorCategoryIds)->get();

            if ($company->vendorCategories->isNotEmpty()) {
                $companyServicesArray = $company->vendorCategories->pluck('name')->toArray();
            }

        }

        if($user->role_id != 1 && $company){
            return response()->json([
               'status' => 200,
               'message' => 'Company summary information',
               'company' => [
                'Company Name' => $companyWithoutUser['name'],
                'Company Tagline' => $companyWithoutUser['tagline'],
                'Company country' => $companyWithoutUser['country'],
                'Company State' => $companyWithoutUser['state'],
                'Company Service type' => $companyWithoutUser['vendor_service_types_id'] != 1 ? 'Multiple Service' : 'Single Service', //single or multiple
                'Company Vendor categories' => $companyServicesArray,
                'Company Current subscriptions' => $companyWithoutUser['subscriptions_id'],
                'Company Subscription start date' => $companyWithoutUser['subscription_start_date'],
                'Company Subscription end date' => $companyWithoutUser['subscription_end_date'],
                'Company Images' => !empty($filesPath) ? $filesPath : "No files yet",
                'Company Services' => $companyServices
            ],
               'Company Vendor' => [
                'username' => $companyUser['username'],
                'profile_image' => $companyUser['profile_image'],
                'location' => $companyUser['location'],
                ]
            ]); 
        }elseif ($user->role_id != 1 && !$company) {
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

    public function storeCompanySubdetails(Request $request){

            // Récupérer l'utilisateur authentifié
            $user = Auth::user();
        
            if ($user && $user->role_id != 1) {
                // Récupération de l'entreprise de l'utilisateur
                $userCompany = Company::where('users_id', $user->id)->first();
                
                if ($userCompany) {
                    try {
                        // Validation des données
                        $dataValidate = $request->validate([
                            'subdetails' => 'bail|string|nullable|max:255'
                        ]);
        
                    } catch (ValidationException $e) {
                        // Retourner les erreurs de validation
                        return response()->json([
                            'message' => 'Validation Error',
                            'errors' => $e->errors(),
                        ], 422);
                    }
                        
                    $companyServices = Services::where('company_id', $userCompany->id)->get();
                    foreach ($companyServices as $companyService) {       
                        $companyService->update([
                            'subdetails' => $dataValidate['subdetails']
                        ]);
                    }

                    return response()->json([
                        'message' => 'Success',
                        'error' => 'Your services subdetails has been registered!'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Unauthorized',
                        'error' => 'You need have a company before add a service subdetails!'
                    ], 403);
                }
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You need to be a vendor to add a service subdetails!'
                ], 403);
            }
        }

    // View my reviews
    public function viewMyTopReviews(){
        $user = Auth::user();
        $myTopReview = Review::where('review_cible', $user->id)->orderBy('start_for_cibe', 'desc')->limit(4)->get();

        // Reviews Users and cibles
        foreach ($myTopReview as $eachTopReview) {
            // Accéder au nom d'utilisateur via la relation user
            $eachTopReview['Author Name'] = $eachTopReview->user->username;
            $eachTopReview['Cible Name'] = $eachTopReview->cibleUser->username;
        }  
        
        //The method send response without others infomation about the user
        // $myTopReview = Review::where('review_cible', $user->id)
        // ->with(['user:id,username', 'cibleUser:id,username']) // Sélectionne uniquement les champs 'id' et 'username'
        // ->orderBy('start_for_cibe', 'desc')
        // ->limit(4)
        // ->get();

        // Reviews Users and cibles
        // foreach ($myTopReview as $eachTopReview) {
        //     $eachTopReview['Author Name'] = $eachTopReview->user->username;
        //     $eachTopReview['Cible Name'] = $eachTopReview->cibleUser->username;
        //     // Supprimez l'instance complète du User si vous ne la souhaitez pas dans la réponse
        //     unset($eachTopReview->user);
        //     unset($eachTopReview->cibleUser);
        // }      

        $reviewStarts = DB::table('reviews')
            ->select('start_for_cibe')
            ->where('review_cible', $user->id)
            ->get();

        $allMyReviews = Review::where('review_cible', $user->id)->get();

        // All review averages
        $reviewMoyenne = 0;
        if (count($allMyReviews)) {
            $reviewMoyenne = $reviewStarts->sum('start_for_cibe') / count($allMyReviews);
        }
        // $myTopReview = Review::where('review_cible', $user->id)->orderBy('start_for_cibe', 'desc')limit(5)->get();

        if(count($myTopReview) > 0){
            return response()->json([
               'status' => 200,
               'message' => 'My Reviews',
                'Reviews' => $myTopReview,
                'Moyenne' => $reviewMoyenne
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'My Reviews',
                 'Reviews' => 'No reviews yet !'
            ], 200);  // Not Found
        }

    }
    
    // View my reviews
    public function viewMyReviews(){
        $user = Auth::user();
        // $myReview = Review::where('review_cible', $user->id)->groupBy('start_for_cibe')->get();
        $myReview = DB::select("
            SELECT 
                MAX(`event_id`) as event_id,
                MAX(`user_id`) as user_id,
                MAX(`review_cible`) as review_cible,
                MAX(`review_content`) as review_content,
                MAX(`date_review`) as date_review,
                `start_for_cibe`,
                MAX(`status`) as status,
                MAX(`created_at`) as created_at
            FROM `reviews`
            WHERE `review_cible` = ?
            GROUP BY `start_for_cibe`",[$user->id]);


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

    public function reviewsByStart(){
        $user = Auth::user();

        $reviewsByStarts =  DB::table('reviews')
            ->select('start_for_cibe as Starts' , DB::raw('COUNT(start_for_cibe) as Total'))
            ->where('review_cible', $user->id)
            ->groupBy('start_for_cibe')
            ->orderBy('start_for_cibe')
            ->get();
            
            $array = [];
            // Initialiser toutes les valeurs de 0 à 5 à 0
            for ($i = 0; $i <= 5; $i++) {
                $array["Start $i"] = 0;
            }

        // Parcourir les résultats et assigner les valeurs correspondantes
        foreach ($reviewsByStarts as $reviewsByStart) {
            $array["Start {$reviewsByStart->Starts}"] = $reviewsByStart->Total;
        }

        if(count($reviewsByStarts) > 0){
            return response()->json([
               'status' => 200,
               'message' => 'My Reviews',
                'Reviews' => $array
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'My Reviews',
                 'Reviews' => 'No reviews yet !'
            ], 200);  // Not Found
        }

    }

    public function updateMyReviewsStatus(Request $request){
        $user = Auth::user();
        $myReviews = Review::where('review_cible', $user->id)->orderBy('start_for_cibe', 'desc')->limit(4)->get();
        $myfirstTopReview = Review::where('review_cible', $user->id)->orderBy('start_for_cibe', 'desc')->first();

        // dd($myfirstTopReview->status);

        if(count($myReviews) > 0){
            if ($myfirstTopReview->status == "" || $myfirstTopReview->status == "hide" ) {

                foreach ($myReviews as $myReview) {
                    $myReview->update([
                        "status" => "show"
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Top reviews are been hide',
                    'myfirstTopReview'=> $myfirstTopReview
                ]);
            } else {

                foreach ($myReviews as $myReview) {
                    $myReview->update([
                        "status" => "hide"
                    ]);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Top reviews are been hide',
                    'myfirstTopReview'=> $myfirstTopReview
                ]);
            }
            
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
        $companyAssoc = Company::where('users_id',$user->id)->first();
        if (!$companyAssoc) {
            dd('Not company yet');
        }

        // dd($companyAssoc->vendor_categories_id);
        if($user){
            $pastEvents = Event::whereDate('start_date', '<', now()->format('Y-m-d'))
            ->where(function($query) use ($user,$companyAssoc) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
            })->get();
            $futureEvents = Event::whereDate('start_date', '>', now()->format('Y-m-d'))
            ->where(function($query) use ($user,$companyAssoc) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
            })->get();
            $currentEvents = Event::whereDate('start_date', '=', now()->format('Y-m-d'))
            ->where(function($query) use ($user,$companyAssoc) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
            })->get();
            $activeEvents = Event::where('status', 'Yes')
            ->where(function($query) use ($user,$companyAssoc) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
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
