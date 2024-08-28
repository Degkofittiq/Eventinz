<?php

namespace App\Http\Controllers\Eventiz\Admin;

use App\Models\Company;
use App\Models\Services;
use App\Rules\SameSizeAs;
use Illuminate\Http\Request;
use App\Models\VendorCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //
    public function index(){
        return view('eventinz_admin.content');
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
            $filePath = $file->storeAs('categoriesImages', $fileName, 'public');

            // Update category image
            $categoryValidation['category_file'] = $filePath;
        }
        $categoryCreation = VendorCategories::create([
            'name' => $categoryValidation['name'],
            'description' => $categoryValidation['description'],
            'category_file' => $categoryValidation['category_file'] ?? null,  // Ajout de la gestion de l'absence de fichier
        ]);

        return back()->with('success', 'The new category is been add');
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

        
        if ($request->hasFile('category_file')) {
            // dd(1);
            $categoryName = preg_replace('/\s+/', '_', $request->name);
            $file = $request->file('category_file');
            $fileName = $categoryName . '_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('categoriesImages', $fileName, 'public');

            // Update category image
            $categoryValidation['category_file'] = $filePath;
        }

        // dd($categoryValidation);

        $category->update($categoryValidation);

        return back()->with('success', 'The category is been update');
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

        return view('eventinz_admin.vendors_companies.edit_vendors_companies', compact('company','companyServices'));
    }

    //Company's services management
    public function updateCompanyServices(Request $request, $companyId)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
    
        if ($user && $user->role_id == 3 || $user && $user->role_id == 4) {
            // Récupération de l'entreprise de l'utilisateur
            $companyFound = Company::where('id', $companyId)->first();
    
            if ($companyFound) {
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
                        'is_pay_by_hour.*' => 'bail|required|string|min:1', // Valider chaque élément du tableau
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
                    $companyFound->update([
                        'company_id' => $companyFound->id, // Utilisation de l'entreprise de l'utilisateur
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

}
