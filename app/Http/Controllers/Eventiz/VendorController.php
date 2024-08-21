<?php

namespace App\Http\Controllers\Eventiz;

use App\Models\User;
use App\Models\Review;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\VendorCategories;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    //
    public function vendorCategoriesList(){
        $vendorCategories = VendorCategories::all();
        return response()->json($vendorCategories);
    }

    public function vendorCategoryList($id){
        $vendor = Company::where('vendor_categories_id', 'LIKE', '%'. $id .'%')->get();
        return response()->json($vendor);
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
        // $companyVendor = User::where('id', $company->users_id)->get();
        return response()->json($company);
    }
}
