<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppContentController;
use App\Http\Controllers\Eventiz\OtpController;
use App\Http\Controllers\Eventiz\EventController;
use App\Http\Controllers\Eventiz\VendorController;
use App\Http\Controllers\Eventiz\CompanyController;
use App\Http\Controllers\Eventiz\PaymentController;
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

//Define Role_id Session
Route::get('/session/{role_id}', function () {
    session(['role_id' => request('role_id')]);
    // return redirect()->route('login.facebook');
});


// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Auth routes
Route::post('register', [AuthController::class, 'register']);
// Route::post('resendotp', [AuthController::class, 'resendOTP']);
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
Route::post('/login', [AuthController::class, 'login']);

// Resend OTP

Route::post('/userresendotp', [AuthController::class, 'userResendOTP']);//send the new otp

// Forgot password and reset password
Route::post('password/email', [AuthController::class, 'forgotPassword']);
Route::post('password/resetOTP', [AuthController::class, 'verifyResetOTP']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);

Route::get('/allappcontent', [AppContentController::class, 'allAppContent']);

Route::middleware(['api', 'web','auth:sanctum'])->group(function () {
    // Route::post('/send-otp', [OtpController::class, 'sendOtp']); Hors Service
    

    // Update personal profile
    Route::get('/profile', [AuthController::class, 'viewProfile']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);

    // // Update password
    // Route::patch('/password', [AuthController::class, 'updatePassword']);

    // Store a company
    Route::get('/storecompany', [CompanyController::class, 'createCompanyForm']);
    Route::post('/storecompany', [CompanyController::class, 'storeCompany']);
    Route::post('/storecompanyimages', [CompanyController::class, 'storeCompanyImages']);
    Route::post('/storecompanyservices', [CompanyController::class, 'storeCompanyServices']);
    Route::post('/storecompanysubdetails', [CompanyController::class, 'storeCompanySubdetails']);
    Route::post('/storecompanytagline', [CompanyController::class, 'storeCompanyTagline']);
    Route::post('/updatecompanylocation', [CompanyController::class, 'updateCompanyLocation']);
    
    // Subscription
    Route::get('/vendorssubscriptions', [CompanyController::class, 'subscriptionList']);
    Route::get('/subscriptionchoose/{subscriptionId}', [CompanyController::class, 'subscriptionChoose']);


    // Vendor self company details
    Route::get('/companyinformation', [CompanyController::class, 'companyInformation']);
    
    // Management a Event
    Route::get('/createeventForm', [EventController::class, 'createEventForm']);
    Route::post('/storeevent', [EventController::class, 'storeEvent']);

    Route::get('/myevents', [EventController::class, 'myEvent']); 
    Route::get('/myeventstatistics', [CompanyController::class, 'myEventStatistics']);

    // show Event
    Route::get('event/{eventId}', [EventController::class,'showEvent']);

    
    // payment
    // MTn Momo And Paypal
    Route::post('/process-money-payment', [PaymentController::class, 'initiatePayment']);

    // vendor list
    Route::get('vendorcategorieslist', [VendorController::class, 'vendorCategoriesList']); // All categories vendors
    Route::get('vendorCategoryList/{vendor_id}', [VendorController::class, 'vendorCategoryList']); //Specific category vendors
    // Route::get('vendorlist', [VendorController::class, 'vendorList']); // 
    Route::get('/vendor/{vendor_id}', [VendorController::class, 'showSpecificVendor']);

    //Review storeReview
    Route::post('addreview/{eventId}', [EventController::class, 'storeReview']);
    Route::get('/viewmytopreview', [CompanyController::class, 'viewMyTopReviews']);
    Route::get('/viewmyreview', [CompanyController::class, 'viewMyReviews']);
    // Hide | Show top reviews
    Route::post('/statustopreviews', [CompanyController::class,'updateMyReviewsStatus']);

    // Quote & Bids for events
    Route::post('addquote/{eventId}', [EventController::class, 'storeQuote']); // Add Quote 
    Route::get('showquote/{quoteCode}', [EventController::class, 'showQuote']); // Show Quote 
    Route::get('showbids/{eventId}', [EventController::class, 'showBids']); // show Bids 
    Route::post('removeQuoteItem/{quoteId}', [EventController::class, 'removeQuoteItem']); // Remove Quote Item 
    Route::post('validatequotesbid/{quoteCode}', [EventController::class, 'validateQuotesBid']); // Validate the Quotes Bid 
    Route::post('rejectquotesbid/{quoteCode}', [EventController::class, 'rejectQuotesBid']); // Reject the Quotes Bid 
    Route::post('cancelevent/{enventId}', [EventController::class, 'cancelEvent']); // Cancel one Event
    Route::post('completeevent/{enventId}', [EventController::class, 'completeEvent']); // complete one Event

    // Logout Api
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


//Define Role_id Session
Route::get('/session/{role_id}', function () {
    session(['role_id' => request('role_id')]);
    // return redirect()->route('login.facebook');
});


Route::get('/payment/{method}/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/{method}/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
        

// Google Ath route
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google/login', [GoogleController::class, 'loginWithGoogle']);

// Facebook Api route
Route::get('login/facebook', [FacebookMetaController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [FacebookMetaController::class, 'handleFacebookCallback']);
