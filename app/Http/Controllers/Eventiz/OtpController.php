<?php

namespace App\Http\Controllers\Eventiz;

use App\Mail\OTPMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    //


    public function sendOtp(Request $request)
    {

        // Génération de l'OTP
        $otp = rand(100000, 999999);

        // Optionnel: Stockage de l'OTP (par exemple, dans la base de données ou la session)
        // Vous pouvez adapter cela selon vos besoins

        // Envoi de l'email
        Mail::to($request->email)->send(new OTPMail($otp));

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'OTP sent successfully.',
            'otp' => $otp // Optionnel: uniquement à des fins de test
        ]);
    }
}
