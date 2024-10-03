<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPMail;
use App\Models\Event;
use App\Models\Company;
use App\Models\BidQuotes;
use App\Models\EventQuotes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use  App\Notifications\PasswordResetNotification;


class AuthController extends Controller
{

    
    function generateUniqueUserID()
    {
        do {
            $generic_id = 'EVT-User-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('generic_id', $generic_id)->exists());
    
        return $generic_id;
    }

    // Check all data input and send otp mail to verify the user identity
    public function register(Request $request)
    {
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
                'phone' => 'nullable|integer',
                // 'vendor_service_types_id' => 'required_if:role_id,2|integer',
                // 'vendor_categories_id' => 'required_if:role_id,2|integer',
            ]);
        }catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }
        
        // Génération de l'OTP
        $otp = rand(100000, 999999);
        // $generic_id = "EVT-" . rand(100000, 999999);

        // Envoi de l'OTP par email
        Mail::to($userValidation['email'])->send(new OTPMail($otp));        

        try {
            // Créer l'utilisateur
            $userCreate = User::create([
                'generic_id' => $this->generateUniqueUserID(),
                'name' => $userValidation['name'],
                'username' => $userValidation['username'],
                'email' => $userValidation['email'],
                'password' => Hash::make($userValidation['password']),
                'role_id' => $userValidation['role_id'],
                'phone' => $userValidation['phone'] ?? null,
                'otp' => $otp
            ]);
            return response()->json(['message' => 'OTP sent successfully. Please verify the OTP.', 'otp' => $otp, 'users' => $userValidation]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error.',
                'Error message' => 'Impossible to register.',
                'errors' => $e->getMessage() 
            ], 422);
        }
    }

    //verify OTP and store the user 
    public function verifyOTP(Request $request)
    {
        $otpValidation = $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|string',
        ]);

        // Vérifier si l'OTP a expiré 
        // $otpExpiresAt = session('otp_expiration_time');

        // if (now()->greaterThan($otpExpiresAt)) {
        //     return response()->json(['message' => 'OTP has expired'], 400);
        // }

        // Vérifier si l'OTP correspond
        // if (session('otp') != $request->otp) {
        //     return response()->json(['message' => 'OTP is not valid'], 401);
        // }

        // $userType = session('role_id');

        /*
            if ($userType == 1) {        
                // Créer l'utilisateur
                $user = User::create([
                    'generic_id' => session('generic_id'),
                    'name' => session('name'),
                    'username' => session('username'),
                    'email' => session('email'),
                    'password' => Hash::make(session('password')),
                    'role_id' => session('role_id')
                ]);
            } else {
                // Créer l'utilisateur
                $user = User::create([
                    'generic_id' => session('generic_id'),
                    'name' => session('name'),
                    'username' => session('username'),
                    'email' => session('email'),
                    'password' => Hash::make(session('password')),
                    'role_id' => session('role_id'),
                    // 'vendor_service_types_id' => session('vendor_service_types_id'),
                    // 'vendor_categories_id' => session('vendor_categories_id')
                ]);
            }
        */

        $user = User::where('email', $otpValidation['email'])->first();

        if ($user->otp == $otpValidation['otp']) {
            $user->update([
                'is_otp_valid' => 'yes',
                'is_user_online' => 'yes'
            ]);
        

            Auth::login($user);
    
            // Supprimer les données de session après la création de l'utilisateur
            // session()->forget(['otp', 'otp_expiration_time']);
            
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            return response()->json([
                'message' => 'OTP is valid. You have been registered successfully.',
                'token' => $token,
                'user' => $user
            ]);
        } else {
                return response()->json(['message' => 'OTP is not valid'], 401);
        }

    }


    //Resend OTP | Only the Admin is able to do this actions

    public function userResendOTPForm(){
        $allusers = User::where('role_id',1)->orWhere('role_id',2)->get();
        return view('eventinz_admin.otps_management.resend_otp', compact('allusers'));
    }

    public function resendOTP(Request $request){
        try{
            $request->validate([
                'email' => 'required|string|email'
            ]);
            // Trouver l'utilisateur par son email
            $user = User::where('email', $request->email)->first();
        }catch (ValidationException $e) {
            return back()->with('error', 'The given data was invalid.');
        }

        if ($user) {

            // Génération de l'OTP
            $otp = rand(100000, 999999);
    
            // Envoi de l'OTP par email
            Mail::to($request->email)->send(new OTPMail($otp));     
            
            // On desactive l'acces au compte en attente de la validation du nouveau OTP
            $user->update(['otp' => $otp, 'is_otp_valid' => 'no']);
            return back()->with('success', 'New OTP sent successfully.');
        } else {
            return back()->with('error', 'User not found');
        }
    }

    public function userResendOTP(Request $request){
        // try{
            $request->validate([
                'email' => 'required|string|email'
            ]);
            // Trouver l'utilisateur par son email
            $user = User::where('email', $request->email)->first();
        // }catch (ValidationException $e) {
        //     return response()->json([
        //         'message' => 'The given data was invalid.',
        //         'errors' => $e->errors(),
        //     ], 422);
        // }

        if ($user) {

            // Génération de l'OTP
            $otp = rand(100000, 999999);
    
            // Envoi de l'OTP par email
            Mail::to($request->email)->send(new OTPMail($otp));     
            
            // On desactive l'acces au compte en attente de la validation du nouveau OTP
            $user->update(['otp' => $otp, 'is_otp_valid' => 'no']);
            // return back()->with('success', 'New OTP sent successfully.');
            return response()->json([
                'message' => 'success',
                'success' => 'New OTP sent successfully to:'.$request->email
            ], 200);
        } else {
            // return back()->with('error', 'User not found');
            return response()->json([
                'message' => 'error',
                'error' => 'User not found',
            ], 400);
        }
    }

    // public function showLoginForm(){
    //     // return view('auth.login');
    //     return 'Show login form';
    // }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => ['required',
                    'string',
                    'min:8', // La longueur minimale du mot de passe
                    'regex:/[a-z]/', // Doit contenir au moins une lettre minuscule
                    'regex:/[A-Z]/', // Doit contenir au moins une lettre majuscule
                    'regex:/[0-9]/', // Doit contenir au moins un chiffre
                    'regex:/[@$!%*?&]/', // Doit contenir au moins un caractère spécial
                ]
            ]);
        }catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Trouver l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->update(['is_user_online' => 'yes']);
        // Connecter l'utilisateur
        Auth::login($user);
        
        $user = Auth::user();
        
        $userHaveCompanyYet = false;
        
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        if ($user->role_id == 2) {
            

            $userCompany = Company::where('users_id',$user->id)->get();
            if (count($userCompany) > 0) {
                # code...
                $userHaveCompanyYet = true;
            }

        }

    
        return response()->json(['token' => $token,'user' => $user, 'userHaveCompanyYet' => $userHaveCompanyYet]);
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
        $token = $request->bearerToken();
        $user->update([
            'is_user_online' => 'no',
            'last_time_user_online' => Carbon::now()
        ]);

        if ($token) {
            // Trouver et révoquer le token actuel
            $personalAccessToken = PersonalAccessToken::findToken($token);

            if ($personalAccessToken) {
                $personalAccessToken->delete();
                return response()->json(['message' => 'Logged out successfully']);
            }

            return response()->json(['message' => 'Token not found'], 404);
        }

        return response()->json(['message' => 'Token not provided'], 400);
    }

    // Update profile
    public function viewProfile(Request $request){
        $userFound = Auth::user();

        if ($userFound->role_id == 1) {
            $activeEvents = Event::where('user_id', $userFound->id)->where('status', 'Yes')->get();
            $pastEvents = Event::where('user_id', $userFound->id)->whereDate('start_date', '<', now()->format('Y-m-d'))->get();
            $futureEvents = Event::where('user_id', $userFound->id)->whereDate('start_date', '>', now()->format('Y-m-d'))->get();
            $canceledEvents = Event::where('user_id', $userFound->id)->where('cancelstatus', 'Canceled')->get();
    
            $userFound['registered_at'] = $userFound['created_at']; 
            $userFound['user_genders_id'] = json_decode($userFound['user_genders_id'], true); 
            $userFound['age'] = json_decode($userFound['age'], true); 
             
            return response()->json([
                'user found' => $userFound->makeHidden(['rights','updated_at','created_at']),
                'Active Events ('. count($activeEvents) .')'=> count($activeEvents) > 0 ? $activeEvents : 0,
                'Past Events ('. count($pastEvents) .')'=> count($pastEvents) > 0 ? $pastEvents : 0,
                'Upcomming Events ('. count($futureEvents) .')'=> count($futureEvents) > 0 ? $futureEvents : 0,
                'Canceled Events ('. count($canceledEvents) .')'=> count($canceledEvents) > 0 ? $canceledEvents : 0,
            ]);
        } else {
            /*
                $companyAssoc = Company::where('users_id',$userFound->id)->first();
                $pastEvents = Event::whereDate('start_date', '<', now()->format('Y-m-d'))
                ->where(function($query) use ($userFound,$companyAssoc) {
                    $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                        ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
                })->get();
                $futureEvents = Event::whereDate('start_date', '>', now()->format('Y-m-d'))
                ->where(function($query) use ($userFound,$companyAssoc) {
                    $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                        ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
                })->get();
                $currentEvents = Event::whereDate('start_date', '=', now()->format('Y-m-d'))
                ->where(function($query) use ($userFound,$companyAssoc) {
                    $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                        ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
                })->get();
                $activeEvents = Event::where('status', 'Yes')
                ->where(function($query) use ($userFound,$companyAssoc) {
                    $query->whereRaw('JSON_CONTAINS(vendor_type_id, ?)', [json_encode($companyAssoc->vendor_categories_id)])
                        ->orWhereRaw('JSON_CONTAINS(vendor_poke, ?)', [json_encode($companyAssoc->id)]);
                })->get();
            */ 

            $allEvents = $futureEvents = $completedEvents = $canceledEvents = $activeEvents = $eventStatistics = [];

            $companyAssoc = Company::where('users_id',$userFound->id)->first();
            if (!$companyAssoc) {
                return response()->json([
                    'message'=> 'error',
                    'error'=> 'Not company yet'
                ], 404);
            }

            $bidAssocs = BidQuotes::where('status','Accepted')->get();
            if (!$bidAssocs) {
                // dd('No Bids yet');
            }

            $eventQuoteAssocs = [];
            foreach ($bidAssocs as $bidAssoc) {
                $eventQuoteAssocs[] = EventQuotes::where('quote_code', $bidAssoc->quote_code)->first();
            }

            if (!empty($eventQuoteAssocs)) {
                $eventQuoteAssocs = array_unique($eventQuoteAssocs);
            }

            // Ces requettes de statistique du cote des vendors se base sur les bids accepte pour la selection des companies via la table event quotes
            foreach ($eventQuoteAssocs as $eventQuoteAssoc) {
                $activeEvents = Event::where('id', $eventQuoteAssoc->event_id)
                ->orWhere('user_id', $userFound->id)->where('status', 'Yes')->get();

                $pastEvents = $currentEvents = [];

                $allEvents = Event::where('id', $eventQuoteAssoc->event_id)->get(); // All 

                $futureEvents = Event::where('id', $eventQuoteAssoc->event_id)
                ->whereDate('start_date', '>', now()->format('Y-m-d'))->get(); // Upcomming

                $completedEvents = Event::where('id', $eventQuoteAssoc->event_id)
                ->where('cancelstatus','completed')->get(); // completed

                $canceledEvents = Event::where('id', $eventQuoteAssoc->event_id)
                ->where('cancelstatus','canceled')->get(); // Canceled

                $activeEvents = Event::where('id', $eventQuoteAssoc->event_id)
                ->where('status', 'Yes')->get(); // Active

                $activeEvents = Event::where('id', $eventQuoteAssoc->event_id)->where('status', 'Yes')->get();
                $pastEvents = Event::where('id', $eventQuoteAssoc->event_id)->whereDate('start_date', '<', now()->format('Y-m-d'))->get();
            }

            $userFound['registered_at'] = $userFound['created_at']; 
            $userFound['user_genders_id'] = json_decode($userFound['user_genders_id'], true); 
            $userFound['age'] = json_decode($userFound['age'], true); 
            return response()->json([
                'message'=> 'Success',
                'user found' => $userFound->makeHidden(['rights','updated_at','created_at']),
                 'Past Events ('. count($pastEvents) .')'=> count($pastEvents) > 0 ? $pastEvents : 0,
                 'Future Events ('. count($futureEvents) .')'=> count($futureEvents) > 0 ? $futureEvents : 0,
                 'Current Events ('. count($currentEvents) .')'=> count($currentEvents) > 0 ? $currentEvents : 0,
                 'Active Events ('. count($activeEvents) .')'=> count($activeEvents) > 0 ? $activeEvents : 0
            ], 200);
        }
        
    }

 
    // update Profile
    public function updateProfile(Request $request){
        $userId = Auth::user()->id;

        try {       
            $userValidation = $request->validate([
                'user_genders_id' => 'nullable|array',  // Valide un tableau
                'user_genders_id.gender' => 'nullable|string|max:255', // Valide la clé 'gender'
                'user_genders_id.status' => 'nullable|string|in:show,hide', // Valide la clé 'status' avec des valeurs spécifiques            
                'occupation' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'age' => 'nullable|array',  // Valide un tableau
                'age.age' => 'nullable|integer|min:0',  // Valide la clé 'age'
                'age.status' => 'nullable|string|in:show,hide', // Valide la clé 'status' avec des valeurs spécifiques            
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'phone' => 'nullable|integer',
            ]);

            // Trouve l'utilisateur par id
            $user = User::find($userId);
            // dd($user);

            if ($request->hasFile('profile_image')) {
                // dd(1);
                $userName = preg_replace('/\s+/', '_', $user->name);
                $file = $request->file('profile_image');
                $fileName = $userName . '_' . time() . '_' . $file->getClientOriginalName();
                // $filePath = $file->storeAs('usersProfileImages', $fileName, 'public');

                $filePath = Storage::disk('s3')->putFileAs('usersProfileImages', $file, $fileName);
                // Récupérer l'URL complète du fichier sur S3
                $fullUrl = Storage::disk('s3')->url($filePath);

                // Update user profile image
                $userValidation['profile_image'] = $fullUrl;
            }
            // Structurer les données dans le format souhaité
            $data = [];
            
            if (!empty($request->profile_image)) {
                $data['profile_image'] = $userValidation['profile_image'] ?? $user->profile_image;
            }
            if (!empty($request->user_genders_id)) {
                $data['user_genders_id'] = json_encode($userValidation['user_genders_id']);
            }
            if (!empty($request->occupation)) {
                $data['occupation'] = $userValidation['occupation'];
            }
            if (!empty($request->location)) {
                $data['location'] = $userValidation['location'];
            }
            if (!empty($request->age)) {
                $data['age'] = json_encode($userValidation['age']);
            }
            if (!empty($request->phone)) {
                $data['phone'] = json_encode($userValidation['phone']);
            }
            
            // Mettre à jour les informations de l'utilisateur
            $user->update($data);

            return response()->json([
                'message' => 'Success',
                'success' => "Update Successful!",
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update error.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // Reset password Link
    public function forgotPassword(Request $request){
        try {
            // Valider les données de la requête
            $request->validate([
                'email' => 'required|string|email|max:255'
            ]);

            // Trouve l'utilisateur par email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Utilisateur non trouvé.'
                ], 404);
            }

            // Crée un OTP de réinitialisation
            $resetOTP = rand(100000, 999999);

            session([
                // 'userUpdateEmail' => $request->email,
                // 'resetOTP' => $resetOTP,
                'resetOTP_expiration_time' => now()->addMinutes(10), // Durée de validité de 10 minutes
            ]);


            Mail::to($request->email)->send(new ForgotPasswordMail($resetOTP));

            $user->update(['otp' => $resetOTP ]);

            return response()->json([
                'status' => 200,
                'message' => 'Un OTP de réinitialisation a été envoyé par email.'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message'=> 'Une erreur est survenue lors de l\'envoi de l\'OTP.',
                'error'=> $e->getMessage(),
            ], 500);
        }
    }

    // Verify the reset OTP
    public function verifyResetOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'resetOTP' => 'required|numeric'
        ]);

        // Vérifier si l'OTP resent a expiré 
        $resetOTPExpiresAt = session('resetOTP_expiration_time');
        if (now()->greaterThan($resetOTPExpiresAt)) {
            return response()->json(['message' => 'The reset OTP has expired'], 400);
        }

        // Vérifier si l'OTP correspond
        // if (session('resetOTP') != $request->resetOTP) {
        //     return response()->json(['message' => 'The reset OTP is not valid'], 401);
        // }
        
        $user = User::where('email', $request->email)->first();

        if ($user->otp == $request->resetOTP) {
            $user->update([
                'is_otp_valid' => 'yes'
            ]);
        
            Auth::login($user);
            
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            return response()->json([
                'message' => 'OTP is valid. You will be redirected to the reset password page!',
                'token' => $token,
                'user' => $user
            ]);
        } else {
                return response()->json(['message' => 'OTP is not valid'], 401);
        }
    }

    // resetPassword
    public function resetPassword(Request $request)
    {

        try{
            $request->validate([
                'email' => 'required|string|email|max:255',
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
        }catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        $userEmail = $request->email;
        
        // Trouve l'utilisateur par email
        $user = User::where('email', $userEmail)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Vérifier si l'OTP a expiré
        // $resetOTPExpiresAt = session('resetOTP_expiration_time');
        // if (now()->greaterThan($resetOTPExpiresAt)) {
        //     return response()->json(['message' => 'The reset OTP has expired'], 400);
        // }

        $hashedPassword = Hash::make($request->password);

        // Mettre à jour le mot de passe de l'utilisateur
        $user->update(['password' => $hashedPassword, 'is_user_online' => 'yes']);

        Auth::login($user);
        // Supprimer les données de session après la mise à jour du mot de passe
        // session()->forget(['resetOTP', 'resetOTP_expiration_time', 'userUpdateEmail']);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'message' => 'Your password was updated successfully.',
            'token' => $token,
            'user' => $user
        ]);
    }

}
