<?php

namespace App\Http\Controllers\Eventiz\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\VendorServiceType;
use App\Http\Controllers\Controller;

class SubscriptionPlanController extends Controller
{
    //
    public function plansList(){
        $subscriptionPlans = Subscription::all();
        return view('eventinz_admin.subscriptions.vendors_subscriptions.list_subscription', compact('subscriptionPlans'));
    }


    public function planDetails(Request $request, $subscriptionId){
        $subscriptionFound = Subscription::find($subscriptionId);
        $vendorTypes = VendorServiceType::all();
        
        return view('eventinz_admin.subscriptions.vendors_subscriptions.show_subscription', compact('subscriptionFound', 'vendorTypes'));
    }


    public function addPlanForm(){

        $vendorTypes = VendorServiceType::all();
        return view('eventinz_admin.subscriptions.vendors_subscriptions.create_subscription',compact('vendorTypes'));
    }

    public function storePlanForm(Request $request){
        $subscriptionValidation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'vendor_service_types_id' => 'required|integer',
            'features' => 'required|array',  // Valide que 'features' est un tableau
            'features.*' => 'required|string|max:255'  // Valide chaque élément du tableau 'features'
        ]);
        
        $subscription = Subscription::create([
            'name' => $subscriptionValidation['name'],
            'description' => $subscriptionValidation['description'],
            'price' => $subscriptionValidation['price'],
            'duration' => $subscriptionValidation['duration'],
           'vendor_service_types_id' => $subscriptionValidation['vendor_service_types_id'],
           'features' => json_encode($subscriptionValidation['features']) 
        ]);

        return back()->with('success','The plan has been added');
    }

    public function updatePlanForm(Request $request, $subscriptionId){
        $subscriptionValidation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'vendor_service_types_id' => 'required|integer',
            'features' => 'required|array',  // Valide que 'features' est un tableau
            'features.*' => 'required|string|max:255'  // Valide chaque élément du tableau 'features'
        ]);
        
        $subscriptionFound = Subscription::find($subscriptionId);
        // dd($request);
        $subscriptionFound->update($subscriptionValidation);

        return back()->with('success', 'Update is been completed');

    }

    public function deletePlanForm(Request $request, $subscriptionId){
        
        $subscriptionFound = Subscription::find($subscriptionId);


        return view('eventinz_admin.subscriptions.vendors_subscriptions.delete_subscription', compact('subscriptionFound'));
    }

    public function deletePlan(Request $request, $subscriptionId){
        $subscriptionFound = Subscription::find($subscriptionId);
        $subscriptionFound->delete();
        return  redirect()->route('admin.list.subscriptionplans')->with('success', 'The plan has been deleted');
    }
}
