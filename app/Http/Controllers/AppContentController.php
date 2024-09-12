<?php

namespace App\Http\Controllers;

use App\Models\PaymentTaxe;
use Illuminate\Http\Request;
use App\Models\contentTextManagement;
use App\Models\contentImagesManagement;

class AppContentController extends Controller
{
    //

    public function allAppContent(){
        // contentTextManagement-contentImagesManagement
        // $contentTexts = contentTextManagement::all()->makeHidden(['created_at', 'updated_at'])->keyBy('name');
        // $contentImages = contentImagesManagement::all()->makeHidden(['created_at', 'updated_at'])->keyBy('name');
        // $paymentTaxes = PaymentTaxe::all()->makeHidden(['created_at', 'updated_at'])->keyBy('name');

        $contentTexts = contentTextManagement::all()->makeHidden(['created_at', 'updated_at','name'])->keyBy('name');
        $contentImages = contentImagesManagement::all()->makeHidden(['created_at', 'updated_at','name'])->keyBy('name');
        $paymentTaxes = PaymentTaxe::all()->makeHidden(['created_at', 'updated_at','name'])->keyBy('name');

        return response()->json([
            'contentTexts' => $contentTexts,
            'contentImages' => $contentImages,
            'paymentTaxes' => $paymentTaxes
        ]);
    }
}
