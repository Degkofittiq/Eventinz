<?php

namespace App\Models;

use App\Models\VendorServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    protected $guarded = [];

    // 
    public function vendorType(){
        return $this->belongsTo(VendorServiceType::class);
    }
}
