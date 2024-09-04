<?php

namespace App\Models;

use App\Models\User;
use App\Models\VendorCategories;
use App\Models\VendorServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'images' => 'array', // Cast la colonne images comme tableau
    ];
    
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    public function serviceType(): HasOne
    {
        return $this->hasOne(VendorServiceType::class, 'id');
    }

    
    public function subscriptionPlan(): HasOne
    {
        return $this->hasOne(Subscription::class, 'id');
    }
    
    public function vendorCategory()
    {
        return $this->hasMany(VendorCategories::class, 'id');
    }

    
    // Déclaration de la relation avec les devis
    public function eventQuotes()
    {
        return $this->hasMany(EventQuotes::class, 'company_id');
    }
}