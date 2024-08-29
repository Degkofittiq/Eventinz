<?php

namespace App\Models;

use App\Models\ServicesCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorCategories extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function servicesCategory()
    {
        return $this->hasMany(ServicesCategory::class, 'id');
    }
}
