<?php

namespace App\Models;

use App\Models\VendorCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicesCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function vendorCategory()
    {
        return $this->belongsTo(VendorCategories::class, 'vendor_categories_id');
    }
    
}
