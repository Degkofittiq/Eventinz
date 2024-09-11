<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contentTextManagement;
use App\Models\contentImagesManagement;

class AppContentController extends Controller
{
    //

    public function allAppContent(){
        // contentTextManagement-contentImagesManagement
        $contentTexts = contentTextManagement::all()->makeHidden(['created_at', 'updated_at']);
        $contentImages = contentImagesManagement::all()->makeHidden(['created_at', 'updated_at']);
        
        return response()->json([
            'contentTexts' => json_decode($contentTexts),
            'contentImages' => json_decode($contentImages),
        ]);
    }
}
