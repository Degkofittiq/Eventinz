<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Eventiz\OtpController;
use App\Http\Controllers\Eventiz\CompanyController;
use App\Http\Controllers\Eventiz\Auth\GoogleController;
use App\Http\Controllers\Eventiz\Auth\FacebookMetaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api', 'web'])->group(function () {
    // Route::post('/send-otp', [OtpController::class, 'sendOtp']); Hors Service
    
    // Auth routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
        
    Route::post('password/email', [AuthController::class, 'forgotPassword']);
    Route::post('password/resetOTP', [AuthController::class, 'verifyResetOTP']);
    Route::post('password/reset', [AuthController::class, 'resetPassword']);

    // Store a company
    Route::get('/storecompany', [CompanyController::class, 'createCompanyForm']);
    Route::post('/storecompany', [CompanyController::class, 'storeCompany']);

    // subbscriptionsummary and payment
    Route::get('/summarypage', [CompanyController::class, 'summaryinformation']);


});


// Google Ath route
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google/login', [GoogleController::class, 'loginWithGoogle']);

// Facebook Api route
Route::get('login/facebook', [FacebookMetaController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [FacebookMetaController::class, 'handleFacebookCallback']);


// Logout Api
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');