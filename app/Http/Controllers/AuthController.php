<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use  App\Notifications\PasswordResetNotification;



class AuthController extends Controller
{
    // Check all data input and send otp mail to verify the user identity
    public function register(Request $request)
    {
        try{
            $userValidation = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
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
                // 'vendor_service_types_id' => 'required_if:role_id,2|integer',
                // 'vendor_categories_id' => 'required_if:role_id,2|integer',
            ]);
        }catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }
        
        /*    
            vendor_service_types_id vendor_categories_id
        */

        // Génération de l'OTP
        $otp = rand(100000, 999999);
        $generic_id = "EVT-" . rand(100000, 999999);

        // Envoi de l'OTP par email
        Mail::to($userValidation['email'])->send(new OTPMail($otp));        

        if ($request->role_id == 1) {

            // Stocker les données de l'utilisateur et l'OTP dans la session
            session([
                'otp' => $otp,
                'otp_expiration_time' => now()->addMinutes(10), // Durée de validité de 10 minutes
                'name' => $userValidation['name'],
                'username' => $userValidation['username'],
                'email' => $userValidation['email'],
                'password' => $userValidation['password'],
                'role_id' => $userValidation['role_id'],
                'generic_id' => $generic_id
            ]);
        }else{    

            // Stocker les données de l'utilisateur et l'OTP dans la session
            session([
                'otp' => $otp,
                'otp_expiration_time' => now()->addMinutes(10), // Durée de validité de 10 minutes
                'name' => $userValidation['name'],
                'username' => $userValidation['username'],
                'email' => $userValidation['email'],
                'password' => $userValidation['password'],
                'password' => $userValidation['password'],
                'role_id' => $userValidation['role_id'],
                'generic_id' => $generic_id,
                // 'vendor_service_types_id' => $userValidation['vendor_service_types_id'],
                // 'vendor_categories_id' => $userValidation['vendor_categories_id'],
            ]);
        }

        return response()->json(['message' => 'OTP sent successfully. Please verify the OTP.', 'generic' => $generic_id]);
    }


    //verify OTP and store the user
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        // Vérifier si l'OTP a expiré 
        $otpExpiresAt = session('otp_expiration_time');

        if (now()->greaterThan($otpExpiresAt)) {
            return response()->json(['message' => 'OTP has expired'], 400);
        }

        // Vérifier si l'OTP correspond
        if (session('otp') != $request->otp) {
            return response()->json(['message' => 'OTP is not valid'], 401);
        }

        $userType = session('role_id');

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

        Auth::login($user);

        // Supprimer les données de session après la création de l'utilisateur
        session()->forget(['otp', 'otp_expiration_time']);
        
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'message' => 'OTP is valid. You have been registered successfully.',
            'token' => $token,
            'user' => $user
        ]);
    }


    public function showLoginForm(){
        // return view('auth.login');
        return 'Show login form';
    }

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
    
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;
    
        return response()->json(['token' => $token,'user' => $user]);
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

        return response()->json([
            'user found' => $userFound
        ]);
    }

    // update Profile
    public function updateProfile(Request $request){
        $userId = Auth::user()->id;

        try {       
            try{
                $userValidation = $request->validate([
                    'user_genders_id' => 'string|max:255',
                    'occupation' => 'string|max:255',
                    'location' => 'string',
                    'age' => 'string|max:255',
                    'profile_image' => 'string|max:255',
                ]);

                // Trouve l'utilisateur par email
                $user = User::where('id', $userId)->first();
    
                // Mettre à jour le mot de passe de l'utilisateur
                $user->update($userValidation);

                return response()->json([
                    'message' => 'Success',
                    'success' => "Update Successfull!",
                ], 200);
                
            }catch (ValidationException $e) {        
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }
        }catch (ValidationException $e) {
            return response()->json([
                'message' => 'Update error.',
                'errors' => $e->errors(),
            ], 422);
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
                'userUpdateEmail' => $request->email,
                'resetOTP' => $resetOTP,
                'resetOTP_expiration_time' => now()->addMinutes(10), // Durée de validité de 10 minutes
            ]);

            Mail::to($request->email)->send(new ForgotPasswordMail($resetOTP));

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
            'resetOTP' => 'required|numeric'
        ]);

        // Vérifier si l'OTP resent a expiré 
        $resetOTPExpiresAt = session('resetOTP_expiration_time');
        if (now()->greaterThan($resetOTPExpiresAt)) {
            return response()->json(['message' => 'The reset OTP has expired'], 400);
        }

        // Vérifier si l'OTP correspond
        if (session('resetOTP') != $request->resetOTP) {
            return response()->json(['message' => 'The reset OTP is not valid'], 401);
        }

        return response()->json([
            'message' => 'OTP is valid. You will be redirected to the reset password page!'
        ]);
    }

    // resetPassword
    public function resetPassword(Request $request)
    {

        try{
            $request->validate([
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

        $userEmail = session('userUpdateEmail');
        
        // Trouve l'utilisateur par email
        $user = User::where('email', $userEmail)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Vérifier si l'OTP a expiré
        $resetOTPExpiresAt = session('resetOTP_expiration_time');
        if (now()->greaterThan($resetOTPExpiresAt)) {
            return response()->json(['message' => 'The reset OTP has expired'], 400);
        }

        $hashedPassword = Hash::make($request->password);

        // Mettre à jour le mot de passe de l'utilisateur
        $user->update(['password' => $hashedPassword]);

        Auth::login($user);
        // Supprimer les données de session après la mise à jour du mot de passe
        session()->forget(['resetOTP', 'resetOTP_expiration_time', 'userUpdateEmail']);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'message' => 'Your password was updated successfully.',
            'token' => $token,
            'user' => $user
        ]);
    }


}
