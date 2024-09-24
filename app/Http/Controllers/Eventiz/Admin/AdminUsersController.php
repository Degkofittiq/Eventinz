<?php

namespace App\Http\Controllers\Eventiz\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Right;
use App\Models\RightsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    // -----
    function generateUniqueUserID()
    {
        do {
            $generic_id = 'EVT-Admin-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('generic_id', $generic_id)->exists());
    
        return $generic_id;
    }

    public function adminUserList(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }

    public function addAdminUserForm(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();
        $roles = Role::where('id',3)->orWhere('id',4)->get();
        // $rights = Right::all();
        $rightTypes = RightsType::with('rights')->get();

        return view('eventinz_admin.adminusers_management.adminusers_create', compact('adminUsers','roles','rightTypes'));
    }

    public function addAdminUser(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();
        
        try{
            $userValidation = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required',
                                'string',
                                'min:8', // La longueur minimale du mot de passe
                                'confirmed', // La confirmation du mot de passe
                                'regex:/[a-z]/', // Doit contenir au moins une lettre minuscule
                                'regex:/[A-Z]/', // Doit contenir au moins une lettre majuscule
                                'regex:/[0-9]/', // Doit contenir au moins un chiffre
                                'regex:/[@$!%*?&]/', // Doit contenir au moins un caractère spécial
                            ],
                'role_id' => 'required|integer',
                'rights' => 'required|array',
                'rights.*' => 'string',
            ]);
        }catch (ValidationException $e) {
            return back()->with('error', 'New admin creation cannot be completed, ' . $e->getMessage() );
        }
        // dd($userValidation);
        // Génération de l'OTP
        $otp = rand(100000, 999999);     

        try {
            // Créer l'utilisateur
            $genericId = $this->generateUniqueUserID();
            $userCreate = User::create([
                'generic_id' => $genericId,
                'name' => $userValidation['name'],
                'username' => $userValidation['username'],
                'email' => $userValidation['email'],
                'password' => Hash::make($userValidation['password']),
                'role_id' => $userValidation['role_id'],
                'rights' => json_encode($userValidation['rights']) ?? json_encode([]),
                'otp' => $otp,
                'is_otp_valid' => "yes",
                'created_at' => Carbon::now(),
                'is_user_online' => "no"
            ]);


            // If creation error, we get the user if the datas are already in storing, and deltete him
            if (!$userCreate) {
                $badUser = User::where('generic_id', $genericId)->first();

                if ($badUser) {
                    $badUser->delete();
                }

                return back()->with('error', 'New admin creation cannot be completed. Please try again !');
            }

            // Else, we send back the success message
            return back()->with('success', 'New Admin created successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'New admin creation cannot be completed, ' . $e->getMessage() );
        }
    }


    public function editAdminUserForm(Request $request, $adminUserId){

        $adminUserFound = User::find($adminUserId);
        if (!$adminUserFound) {
            return back()->with('error', 'Admin user not found');
        }
        $roles = Role::where('id',3)->orWhere('id',4)->get();
        // $rights = Right::all();
        $rightTypes = RightsType::with('rights')->get();

        return view('eventinz_admin.adminusers_management.adminusers_edit', compact('adminUserFound','roles','rightTypes'));
    }

    public function updateAdminUser(Request $request, $adminUserId){
        $adminUsers = User::find($adminUserId);
        if (!$adminUsers) {
            return back()->with('error', 'Admin user not found');
        }
        try{
            $userValidation = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role_id' => 'required|integer',
                'rights' => 'required|array',
                'rights.*' => 'string',
            ]);

            if ($request->password != "") {
                $userValidation['password'] = $request->validate([
                    'password' => ['required',
                                    'string',
                                    'min:8', // La longueur minimale du mot de passe
                                    'confirmed', // La confirmation du mot de passe
                                    'regex:/[a-z]/', // Doit contenir au moins une lettre minuscule
                                    'regex:/[A-Z]/', // Doit contenir au moins une lettre majuscule
                                    'regex:/[0-9]/', // Doit contenir au moins un chiffre
                                    'regex:/[@$!%*?&]/', // Doit contenir au moins un caractère spécial
                                ]
                ]);
            }

            if ($request->email != $adminUsers->email) {
                $userValidation['email'] = $request->validate([
                    'email' => 'required|string|email|max:255|unique:users'
                ]);
            }
            if ($request->username != $adminUsers->username) {
                $userValidation['username'] = $request->validate([
                    'username' => 'required|string|max:255|unique:users'
                ]);
            }
        }catch (ValidationException $e) {
            return back()->with('error', 'New admin update cannot be completed, ' . $e->getMessage() );
        }

        if (!$adminUsers) {
            return back()->with('error', 'New admin update cannot be completed');            
        }

        $adminUsers->update([
            'name' => $userValidation['name'],
            'username' => $userValidation['username'],
            'email' => $userValidation['email'],
            'role_id' => $userValidation['role_id'],
            'rights' => json_encode($userValidation['rights']) ?? json_encode([])
        ]);

        // Si le mot de passe est fourni, le mettre à jour séparément
        if (!empty($request->password)) {
            $adminUsers->update([
                'password' => Hash::make($userValidation['password']),
            ]);
        }
        return back()->with('success', 'New admin update successfull !');      
    }

    public function deleteAdminUserForm(Request $request, $adminUserId){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }

    public function deleteAdminUser(Request $request, $adminUserId){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }

    // rights CRUD, just temporaly
    public function rightsList(){

        $rights = Right::all();

        return view('eventinz_admin.rights_management.rights_list', compact('rights'));
    }
    
    public function addRightForm(){
        $rightsTypes = RightsType::all();

        return view('eventinz_admin.rights_management.rights_create', compact('rightsTypes'));
    }
    
    public function addRight(Request $request){
        $rightValidation = $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255',
            'rights_types_id' =>'required|integer',
        ]);

        try{
            $rightCreate = Right::create([
                'name' => preg_replace('/\s+/', '_', $rightValidation['name']),
                'description' => $rightValidation['description'],
                'rights_types_id' => $rightValidation['rights_types_id'],
            ]);

            if (!$rightCreate) {
                return back()->with('error', 'New right creation cannot be completed. Please try again!');
            }

            return back()->with('success', 'New right created successfully.');
        }catch (Exception $e) {
            return back()->with('error', 'New right creation cannot be completed, '. $e->getMessage() );
        }

    }
    // rightsList-addRightForm-addRight-

}
