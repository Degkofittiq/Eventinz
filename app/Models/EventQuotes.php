<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventQuotes extends Model
{
    use HasFactory;
    protected $guarded = [];

        // Déclaration de la relation avec l'entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
