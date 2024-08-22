<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Eventiz\EventController;
use App\Http\Controllers\Eventiz\PaymentController;
use App\Http\Controllers\Eventiz\Auth\GoogleController;
use App\Http\Controllers\Eventiz\Auth\FacebookMetaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google/login', [GoogleController::class, 'loginWithGoogle']);


//Define Role_id Session
Route::get('/session/{role_id}', function () {
    session(['role_id' => request('role_id')]);
    // return redirect()->route('login.facebook');
});

Route::get('login/facebook', [FacebookMetaController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookMetaController::class, 'handleFacebookCallback']);


// for test
Route::get('/tes_form', function () {
    return view('tes_form');
});
Route::post('addquote/{eventId}', [EventController::class, 'storeQuote']); // Add Quote 