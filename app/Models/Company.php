<?php

namespace App\Models;

use App\Models\User;
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

    
    // Déclaration de la relation avec les devis
    public function eventQuotes()
    {
        return $this->hasMany(EventQuotes::class, 'company_id');
    }
}
