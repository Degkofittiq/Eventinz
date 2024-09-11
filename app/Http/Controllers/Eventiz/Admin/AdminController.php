<?php

namespace App\Http\Controllers\Eventiz\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Review;
use App\Models\Company;
use App\Models\Services;
use App\Rules\SameSizeAs;
use App\Models\PaymentTaxe;
use Illuminate\Http\Request;
use App\Models\Paymenthistory;
use App\Models\ServicesCategory;
use App\Models\VendorCategories;
use App\Models\VendorServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\contentTextManagement;
use App\Models\contentImagesManagement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //


    public function loginForm(){
        return view('eventinz_admin.auth.login');
    }

    public function login(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => [
                'required',
                'string',
                'min:8', // La longueur minimale du mot de passe
                'regex:/[a-z]/', // Doit contenir au moins une lettre minuscule
                'regex:/[A-Z]/', // Doit contenir au moins une lettre majuscule
                'regex:/[0-9]/', // Doit contenir au moins un chiffre
                'regex:/[@$!%*?&]/', // Doit contenir au moins un caractère spécial
            ]
        ]);
    
        // Tentative de connexion de l'utilisateur
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Trouver l'utilisateur par son email
        $user = User::where('email', $request->email)->first();
    
        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Mettre à jour le statut de l'utilisateur et connecter l'utilisateur
        $user->update(['is_user_online' => 'yes']);
        Auth::login($user);
    
        // Création du token d'accès
        $token = $user->createToken('Personal Access Token')->plainTextToken;
    
        // Vérifier les rôles de l'utilisateur
        if ($user->role_id == 3 || $user->role_id == 4) {
            // return response()->json(['token' => $token, 'user' => $user]);
            return redirect()->route('admin.dashboard');
        } else {
            // Déconnecter l'utilisateur et mettre à jour le statut
            $user->update(['is_user_online' => 'no',
                'last_time_user_online' => Carbon::now()
            ]);
            Auth::logout();
            return redirect()->route('/')->with('error', 'You\'re not authorized');
        }
    }
    
        
    public function logout(Request $request)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Récupérer le token actuel depuis l'en-tête Authorization
        // $token = $request->bearerToken();
        $user->update(['is_user_online' => 'no','last_time_user_online' => Carbon::now()]);

        Auth::logout($user);
        return redirect()->route('login')->with('success', 'Logged out successfully');

        // if ($token) {
        //     // Trouver et révoquer le token actuel
        //     $personalAccessToken = PersonalAccessToken::findToken($token);

        //     if ($personalAccessToken) {
        //         $personalAccessToken->delete();
        //         return response()->json(['message' => 'Logged out successfully']);
        //     }

        //     return response()->json(['message' => 'Token not found'], 404);
        // }

        // return response()->json(['message' => 'Token not provided'], 400);
    }


    public function index(){
        return view('eventinz_admin.dashboard');
    }

    public function usersList(){
        $users= User::where('role_id',1)->orWhere('role_id',2)->get();
        return view('eventinz_admin.hosts_and_vendors.list_users', compact('users'));
    }

    public function userDetails(Request $request, $userId){
        $userFound = User::find($userId);
         
        
        if($userFound->role_id == 1){
            $allEvents = Event::where('user_id',$userFound->id)->get(); // All 

            $futureEvents = Event::where('user_id',$userFound->id)->where('cancelstatus',$userFound->id)->get(); // Upcomming

            $completedEvents = Event::where('user_id',$userFound->id)->where('cancelstatus','completed')->get(); // completed

            $canceledEvents = Event::where('user_id',$userFound->id)->where('cancelstatus','canceled')->get(); // Canceled

            $activeEvents = Event::where('user_id',$userFound->id)->where('status', 'Yes')->get(); // Active

            $eventStatistics = [
                'message'=> 'Success',
                 'All Events'=> count($allEvents) > 0 ? $allEvents : [],
                 'Future Events'=> count($futureEvents) > 0 ? $futureEvents : [],
                 'Completed Events'=> count($completedEvents) > 0 ? $completedEvents : [],
                 'Canceled Events'=> count($canceledEvents) > 0 ? $canceledEvents : [],
                 'Active Events'=> count($activeEvents) > 0 ? $activeEvents : []
             ];
        }
        if($userFound->role_id == 2){
            $allEvents = Event::where(function($query) use ($userFound) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($userFound->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($userFound->id)]);
            })->get(); // All 

            $futureEvents = Event::whereDate('start_date', '>', now()->format('Y-m-d'))
            ->where(function($query) use ($userFound) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($userFound->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($userFound->id)]);
            })->get(); // Upcomming

            $completedEvents = Event::where('cancelstatus','completed')
            ->where(function($query) use ($userFound) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($userFound->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($userFound->id)]);
            })->get(); // completed

            $canceledEvents = Event::where('cancelstatus','canceled')
            ->where(function($query) use ($userFound) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($userFound->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($userFound->id)]);
            })->get(); // Canceled

            $activeEvents = Event::where('status', 'Yes')
            ->where(function($query) use ($userFound) {
                $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($userFound->id)])
                      ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($userFound->id)]);
            })->get(); // Active

            $eventStatistics = [
                'message'=> 'Success',
                 'All Events'=> count($allEvents) > 0 ? $allEvents : [],
                 'Future Events'=> count($futureEvents) > 0 ? $futureEvents : [],
                 'Completed Events'=> count($completedEvents) > 0 ? $completedEvents : [],
                 'Canceled Events'=> count($canceledEvents) > 0 ? $canceledEvents : [],
                 'Active Events'=> count($activeEvents) > 0 ? $activeEvents : []
             ];
        }


        return view('eventinz_admin.hosts_and_vendors.details_users', compact('userFound','eventStatistics'));
    }
    // Add Category
    public function addCategory(){
        $categories= VendorCategories::all();
        return view('eventinz_admin.vendors_categories.add_category', compact('categories'));
    }
    
    public function listCategory(){
        $categories= VendorCategories::all();
        return view('eventinz_admin.vendors_categories.list_category', compact('categories'));
    }
    
    public function storeCategory(Request $request){
        // dd($request);
        $categoryValidation = $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'category_file' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // dd($categoryValidation);
        
        if ($request->hasFile('category_file')) {
            // dd(1);
            $categoryName = preg_replace('/\s+/', '_', $request->name);
            $file = $request->file('category_file');
            $fileName = $categoryName . '_' . time() . '_' . $file->getClientOriginalName();
            // $filePath = $file->storeAs('categoriesImages', $fileName, 'public');

            // Enregistrer l'image sur S3
            $filePath = Storage::disk('s3')->put('categoriesImages', $request->file('category_file'));
            // Récupérer l'URL complète du fichier sur S3
            $fullUrl = Storage::disk('s3')->url($filePath);

            // Update category image
            $categoryValidation['category_file'] = $fullUrl;
        }
        $categoryCreation = VendorCategories::create([
            'name' => $categoryValidation['name'],
            'description' => $categoryValidation['description'],
            'category_file' => $categoryValidation['category_file'] ?? null,  // Ajout de la gestion de l'absence de fichier
        ]);

        return back()->with('success', 'The new category is been add'.$filePath);
    }

    // Edit Category
    public function editCategory($id){
        $category= VendorCategories::find($id);
        return view('eventinz_admin.vendors_categories.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id){
        $category= VendorCategories::find($id);
        // dd($request);
        $categoryValidation = $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'category_file' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $filePath = null;
        
        if ($request->hasFile('category_file')) {
            $categoryName = preg_replace('/\s+/', '_', $request->name);
            $file = $request->file('category_file');
            $fileName = $categoryName . '_' . time() . '_' . $file->getClientOriginalName();

            // Stocker le fichier sur S3 avec le nom de fichier généré
            $filePath = Storage::disk('s3')->putFileAs('categoriesImages', $file, $fileName);
            // Récupérer l'URL complète du fichier sur S3
            $fullUrl = Storage::disk('s3')->url($filePath);

            // Update category image
            $categoryValidation['category_file'] = $fullUrl;
        }

        // Si le chemin est correct, renvoyez-le, sinon une erreur
        if ($filePath) {

            $category->update($categoryValidation);
            return back()->with('success', 'The category is been update'.$filePath);

        } else {

            $category->update($categoryValidation);
            return back()->with('error', 'Failed to upload the file.');
        }
    }

    // Delete Category form
    public function deleteCategoryForm($id){
        $category = VendorCategories::find($id);
        return view('eventinz_admin.vendors_categories.delete_category', compact('category'));
    }
    
    // Delete Category
    public function deleteCategory($id){
        VendorCategories::find($id)->delete();
        return redirect()->route('admin.list.category')->with('success', 'The category is been deleted');
    }
    
    public function companiesList(){
        $companies = Company::all();

        foreach ($companies as $company) {
            // Décodage de la chaîne JSON
            $vendorCategoryIds = json_decode($company->vendor_categories_id, true);

            // Récupération des noms des catégories de vendeur
            $company->vendorCategories = VendorCategories::whereIn('id', $vendorCategoryIds)->get();
        }


        return view('eventinz_admin.vendors_companies.list_vendors_companies', compact('companies'));
    }
    

    public function editCompany(Request $request, $companyId){
        // 
        $company = Company::find($companyId);


        // foreach ($companies as $company) {
            // Décodage de la chaîne JSON
            $vendorCategoryIds = json_decode($company->vendor_categories_id, true);

            // Récupération des noms des catégories de vendeur
            $company->vendorCategories = VendorCategories::whereIn('id', $vendorCategoryIds)->get();
        // }

        $companyServices = Services::where('company_id',$companyId)->get();
                // foreach ($companyServices as $companyService) {
                //     dd($companyService['servicename']);
                // }
        $servicenames = [
            "Photoshoot",
            "Videography",
            "Editing",
            "Branding",
            "Graphic Design",
            "Logo Design",
        ];   
        // dd(count($companyServices));
        return view('eventinz_admin.vendors_companies.edit_vendors_companies', compact('company','companyServices', "servicenames"));
    }
        
    // Company's services management
    public function updateCompanyServices(Request $request, $companyId)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Récupération de l'entreprise de l'utilisateur
        $companyFound = Company::findOrFail($companyId);

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
            // $travel = $dataValidate['travel'] ?? "No";

        } catch (ValidationException $e) {
            // Retourner les erreurs de validation
            return back()->with('error', 'Company update failed! ' . json_encode($e->errors(), 422));
        }

        // Supprimer les services existants pour la compagnie
        Services::where('company_id', $companyId)->delete();

        // Boucle sur les services pour créer de nouvelles entrées
        foreach ($dataValidate['servicename'] as $index => $serviceName) {
            Services::create([ //servicename-type-rate-subdetails
                'company_id' => $companyId,
                'servicename' => $serviceName,
                'type' => $dataValidate['type'][$index],
                'rate' => $dataValidate['rate'][$index],
                'subdetails' => $subdetails
            ]);
        }

        return back()->with('success', 'Company\'s service(s) list has been updated!');

    }

    // Companies Services Categories Management
    public function servicesCategoriesList(){
        $servicesCategories = ServicesCategory::all();
    
        return view('eventinz_admin.services_categories.list_services_categories', compact('servicesCategories'));
    }

    // addServicesCategory
    public function addServicesCategory(){
        $VendorCategories = VendorCategories::all();
        return view('eventinz_admin.services_categories.add_services_categories', compact('VendorCategories'));
    }

    public function storeServicesCategory(Request $request){
        $dataValidate = $request->validate([
                'vendor_categories_id' =>'required|integer',
                'name' =>'required|string|max:255',
                'description' =>'required|string|max:255'
            ]);

            // dd($dataValidate);
        $dataStoring = ServicesCategory::create([
            'name' => $dataValidate['name'],
            'description' => $dataValidate['description'],
        'vendor_categories_id' => $dataValidate['vendor_categories_id']
        ]);

        if ($dataStoring) {
            
            return redirect()->route('admin.list.servicescategories')->with('success', 'The service category is been added !');
        } else {
            return redirect()->route('admin.list.servicescategories')->with('error', 'Add error, try again!');
        }
        
    }

    public function editServicesCategory(Request $request, $servicesCategoryId){

        $servicesCategoryFound = ServicesCategory::findOrFail($servicesCategoryId);

        if ($servicesCategoryFound) {
            $VendorCategories = VendorCategories::all();
            return view('eventinz_admin.services_categories.edit_services_categories', compact('servicesCategoryFound', 'VendorCategories'));
        } else {
            return view('eventinz_admin.services_categories.list_services_categories')->with('error', 'Services category not found!');
        }
    }

    public function updateServicesCategory(Request $request, $servicesCategoryId){
        $dataValidate = $request->validate([
                'vendor_categories_id' =>'required|integer',
                'name' =>'required|string|max:255',
                'description' =>'required|string|max:255'
            ]);
            $VendorCategories = ServicesCategory::findOrFail($servicesCategoryId);
            // dd($VendorCategories);
            try {
                $servicesCategories = ServicesCategory::all();
                $VendorCategories->update([
                    'name' => $dataValidate['name'],
                    'description' => $dataValidate['description'],
                    'vendor_categories_id' => $dataValidate['vendor_categories_id']
                ]);
                return redirect()->route('admin.list.servicescategories')->with('success', 'The service category is been updated!');
            } catch (\Throwable $th) {
                //throw $th;
            $VendorCategories = VendorCategories::all();
                return view('eventinz_admin.services_categories.edit_services_categories', compact('servicesCategoryFound', 'VendorCategories'))->with('error', 'Update error, try again!');
            }
    }

    public function paymentsList(){
        $paymentsStories = Paymenthistory::all();
        return view('eventinz_admin.payments_stories.list_payment', compact('paymentsStories'));
    }

    public function showPayment(Request $request, $paymentId){

        $paymentFound = Paymenthistory::find($paymentId);
        
        if ($paymentFound) {
            return view('eventinz_admin.payments_stories.show_payment', compact('paymentFound'));
        } else {
            return view('eventinz_admin.payments_stories.list_payment')->with('error', 'Payment not found!');
        }
    }

    // Event Management

    public function adminEventList(){
        $events = Event::all();
        return view('eventinz_admin.events.list_events', compact('events'));
    }

    public function adminEventDetails(Request $request, $eventId){
        $event = Event::find($eventId);
        return view('eventinz_admin.events.details_event', compact('event'));
    }

    public function adminReviewsList(){
        $allReviews = Review::all();
        return view('eventinz_admin.hosts_vendors_reviews.list_reviews', compact('allReviews'));
    }

    public function adminReviewDetails(Request $request, $reviewId){
        $reviewFound = Review::find($reviewId);
        if ($reviewFound) {
            return view('eventinz_admin.hosts_vendors_reviews.details_reviews', compact('reviewFound'));
        } else {
            return back()->with('error', 'Review not found');
        }
        
    }

    public function adminReviewUpdate(Request $request, $reviewId){

        $reviewFound = Review::where('id', $reviewId)->first();
        if ($reviewFound) {

            $reviewFound->update([
                "status" => $request->status
            ]);
            return back()->with('success', 'Review\'s status has been update');

        } else {
            return back()->with('error', 'Review not found');
        }
        
    }


    
    // Content management | addContentTextForm-addContentText-contentTextList-showContentText-updateContentText

    public function addContentTextForm(Request $request){

        return view('eventinz_admin.contents_management.texts.create');
    }

    public function addContentText(Request $request){
        $fieldValidation = $request->validate([
            'name' =>'required|string|max:1000|min:1',
            'page' =>'required|string|max:1000|min:1',
            'content_fr' =>'required|string|max:1000|min:1',
            'content_en' =>'required|string|max:1000|min:1',
        ]);

        $storing = contentTextManagement::create([
            'name' =>  str_replace(" ", "_", strtolower($fieldValidation['name'])),
            'page' => $fieldValidation['page'],
            'content_fr' => $fieldValidation['content_fr'],
            'content_en' => $fieldValidation['content_en'],
        ]);

        if (!$storing) {
            return back()->with('error', 'Add error, try again !');
        }

        return back()->with('success', 'The text has been added !');
    }
    
    public function contentTextList(Request $request){

        $textContents = contentTextManagement::all();
        return view('eventinz_admin.contents_management.texts.list', compact('textContents'));
    }
    
    public function showContentText(Request $request, $contentTextId){

        $contentTextFound = contentTextManagement::find($contentTextId);        
        if (!$contentTextFound) {
            return back()->with('error', 'Content text not found');
        }
        return view('eventinz_admin.contents_management.texts.edit', compact('contentTextFound'));        
    }
    
    public function updateContentText(Request $request, $contentTextId){

        $contentTextFound = contentTextManagement::find($contentTextId);
        if (!$contentTextFound) {
            return back()->with('error', 'Content text not found');
        }

        $fieldValidation = $request->validate([
            // 'name' =>'required|string|max:1000|min:1',
            'page' =>'required|string|max:1000|min:1',
            'content_fr' =>'required|string|max:1000|min:1',
            'content_en' =>'required|string|max:1000|min:1',
        ]);

        $contentTextFound->update([
            // 'name' =>  str_replace(" ", "_", strtolower($fieldValidation['name'])),
            'page' => $fieldValidation['page'],
            'content_fr' => $fieldValidation['content_fr'],
            'content_en' => $fieldValidation['content_en'],
        ]);
        
        return back()->with('success', 'The text has been updated !');    
    }


    // addContentImageForm-addContentImage-contentImageList-showContentImage-updateContentImage

    public function addContentImageForm(Request $request){

        return view('eventinz_admin.contents_management.images.create');
    }

    public function addContentImage(Request $request){
        $fieldsValidations = $request->validate([
            'name' =>'required|string|max:255',
            'page' =>'required|string|max:255',
            'type' =>'required|string|max:255',
            'path' =>'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        if ($request->hasFile('path')) {
            $imageName = preg_replace('/\s+/', '_', $request->name);
            $file = $request->file('path');
            $fileName = $imageName . '_' . time() . '_' . $file->getClientOriginalName();

            // Enregistrer l'image sur S3
            $filePath = Storage::disk('s3')->putFileAs('contentsImages', $file, $fileName);
            // Récupérer l'URL complète du fichier sur S3
            $fullUrl = Storage::disk('s3')->url($filePath);

            // Update category image
            $fieldsValidations['path'] = $fullUrl;
        }

        if (!$filePath) {
            return back()->with('error', 'Image update error, please try again !');
        }

        $contentImagesManagement = contentImagesManagement::create($fieldsValidations);
        return back()->with('success', 'The Image has been added !');
    }
    
    public function contentImageList(Request $request){
        $imageContents = contentImagesManagement::all();
        return view('eventinz_admin.contents_management.images.list', compact('imageContents'));
    }
    
    public function showContentImage(Request $request, $contentImageId){

        $imageContentFound = contentImagesManagement::find($contentImageId);
        return view('eventinz_admin.contents_management.images.edit', compact('imageContentFound'));        
    }
    
    public function updateContentImage(Request $request, $contentImageId){

        $imageContentFound = contentImagesManagement::find($contentImageId);
        if (!$imageContentFound) {
            return back()->with('error', 'Content Image not found');
        }
        $fieldsValidations = $request->validate([
            // 'name' =>'required|string|max:255',
            'page' =>'required|string|max:255',
            'type' =>'required|string|max:255'
        ]);
        
        if ($request->path != ""  && $request->hasFile('path')) {
            $fieldsValidations['path'] = $request->validate([
                'path' =>'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);
            $imageName = preg_replace('/\s+/', '_', $request->name);
            $file = $request->file('path');
            $fileName = $imageName . '_' . time() . '_' . $file->getClientOriginalName();

            // Enregistrer l'image sur S3
            $filePath = Storage::disk('s3')->putFileAs('contentsImages', $file, $fileName);
            // Récupérer l'URL complète du fichier sur S3
            $fullUrl = Storage::disk('s3')->url($filePath);

            // Update category image
            $fieldsValidations['path'] = $fullUrl;

            if (!$filePath) {
                return back()->with('error', 'Image update error, please try again !');
            }
        }


        $imageContentFound->update($fieldsValidations);
        return back()->with('success', 'The Image has been updated !');    
    }

    // listVendorClass-addVendorClassForm-addVendorClass-showVendorClass-updateVendorClass
    // VendorServiceType == Vendor class

    public function listVendorClass(Request $request){
        $vendorClasses = VendorServiceType::all();
        return view('eventinz_admin.vendors_classes.list', compact('vendorClasses'));
    }
    
    public function addVendorClassForm(Request $request){
        return view('eventinz_admin.vendors_classes.create');
    }

    public function addVendorClass(Request $request){
        $fieldValidation = $request->validate([
            'name' =>'required|string|max:255|min:1',
            'description' =>'required|string|min:1|max:255',
            'service_number' =>'required|integer|min:1|max:255',
            'features' => 'required|array',  // Valide que 'features' est un tableau
            'features.*' => 'required|string|max:255'  // Valide chaque élément du tableau 'features'
        ]);
        
        $fieldValidation['features'] = json_encode($fieldValidation['features']);
        
        $storing = VendorServiceType::create($fieldValidation);
        if (!$storing) {
            return back()->with('error', 'Add error, try again !');
        }
        return back()->with('success', 'The vendor class has been added');
    }

    public function showVendorClass(Request $request, $vendorClassId){
        $vendorClassFound = VendorServiceType::find($vendorClassId);
        if (!$vendorClassFound) {
            return back()->with('error', 'Vendor class not found');
        }
        return view('eventinz_admin.vendors_classes.edit', compact('vendorClassFound'));
    }

    public function updateVendorClass(Request $request, $vendorClassId){

        $vendorClassFound = VendorServiceType::find($vendorClassId);

        if (!$vendorClassFound) {
            return back()->with('error', 'Vendor class not found');
        }

        $fieldValidation = $request->validate([
            'name' =>'required|string|max:255|min:1',
            'description' =>'required|string|min:1|max:255',
            'service_number' =>'required|integer|min:1|max:255',
            'features' => 'required|array',  // Valide que 'features' est un tableau
            'features.*' => 'required|string|max:255'  // Valide chaque élément du tableau 'features'
        ]);

        $fieldValidation['features'] = json_encode($fieldValidation['features']);


        $vendorClassFound->update($fieldValidation);
        return back()->with('success', 'The vendor class');
    }

    // Taxe TVA management | listPaymentTaxe-addPaymentTaxeForm-addPaymentTaxe-showPaymentTaxe-updatePaymentTaxe-deletePaymentTaxeForm-deletePaymentTaxe

    public function listPaymentTaxe(Request $request){

        $paymentTaxes = PaymentTaxe::all();

        return view('eventinz_admin.payment_taxes.list', compact('paymentTaxes'));
    }
    
    public function addPaymentTaxeForm(Request $request){
        
        return view('eventinz_admin.payment_taxes.create');
    }
    
    public function addPaymentTaxe(Request $request){
        $request->validate([
        'name' => 'required|string|max:255',
        'value' => 'required|numeric|between:0,100', // La valeur doit être un nombre entre 0 et 100 pour représenter un pourcentage
    ]);

    }
    
    public function showPaymentTaxe(Request $request, $paymentTaxeId){

        $taxeFound = PaymentTaxe::find($paymentTaxeId);

        if (!$taxeFound) {
            return back()->with('error', 'Taxe not found');
        }

    }
    
    public function updatePaymentTaxe(Request $request, $paymentTaxeId){
        $request->validate([
        'name' => 'required|string|max:255',
        'value' => 'required|numeric|between:0,100', // La valeur doit être un nombre entre 0 et 100 pour représenter un pourcentage
    ]);

        $taxeFound = PaymentTaxe::find($paymentTaxeId);
        
        if (!$taxeFound) {
            return back()->with('error', 'Taxe not found');
        }

        return back()->with('success', 'Taxe has been updated');
    }
    
    public function deletePaymentTaxeForm(Request $request, $paymentTaxeId){

        $taxeFound = PaymentTaxe::find($paymentTaxeId);

        if (!$taxeFound) {
            return back()->with('error', 'Taxe not found');
        }

        return view('eventinz_admin.payment_taxes.delete', compact('paymentTaxeId'));
    }
    
    public function deletePaymentTaxe(Request $request, $paymentTaxeId){
        
    }

}
