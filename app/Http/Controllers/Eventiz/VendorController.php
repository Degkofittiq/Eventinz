<?php

namespace App\Http\Controllers\Eventiz;

use App\Models\User;
use App\Models\Review;
use App\Models\Company;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\VendorCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    //
    public function vendorCategoriesList(){
        $vendorCategories = VendorCategories::all();
        return response()->json($vendorCategories);
    }

    public function vendorCategoryList($id){

        $vendorCategoryId = VendorCategories::find($id);
        if(!$vendorCategoryId){
            return response()->json([
                "Vendors Category not found !"
            ]);
        }

        $user = Auth::user();
        if($user->location != null){
            $vendor = Company::where('vendor_categories_id', 'LIKE', '%'. $id .'%')
            ->where('country',$user->location)
            ->orWhere('state',$user->location)
            ->orWhere('city',$user->location)->get();
            if (count($vendor) < 1) {
                return response()->json([
                    "No vendor yet for this category"
                ]);
            }
            return response()->json([
                $vendor, "For $user->location"
            ]);
        }else{
            $vendor = Company::where('vendor_categories_id', 'LIKE', '%'. $id .'%')->get();
            if (count($vendor) < 1 ) {
                return response()->json([
                    "No vendor yet for this category"
                ]);
            }
            return response()->json([
                $vendor, "All"
            ]);
        }
    }
    /*
        public function vendorList(Request $request){
            $vendorCategoryId = $request->vendorCategoryId;
            dd($vendorCategoryId);
            $vendors = Company::all();

            return response()->json($vendors);
        }
    */
    public function showSpecificVendor($id){
        // dd($id);
        $company = Company::find($id);
        $companyReviews = Review::where('user_id', $company->users_id)->get();
        $companyServices = Services::where('company_id', $company->id)->get();
        $companyVendor = User::where('id', $company->users_id)->first();

        $vendorCategoryIds = json_decode($company->vendor_categories_id, true);
        // Récupération des noms des catégories de vendeur
        $company->vendorCategories = VendorCategories::whereIn('id', $vendorCategoryIds)->get();

        if ($company->vendorCategories->isNotEmpty()) {
            $companyServicesArray = $company->vendorCategories->pluck('name')->implode(', ');
        }

        return response()->json([
            'company:' => $company->name,
            'company Tagline:' => $company->tagline,
            'company Country:' => $company->country,
            'company State:' => $company->state,
            'company City:' => $company->city,
            'company Images:' => $company->images,
            'company Service Type:' => $company->vendor_service_types_id == 1 ?"Single Service" : "Multiple Services",
            'company Services List:' => $companyServices,
            'company Service(s) Categorie:' => $companyServicesArray,
            'company Reviews' => $companyReviews,
            'company Vendor' => $companyVendor->username
        ]);
    }
}
