<?php

namespace App\Models;

use App\Models\Right;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RightsType extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function rights()
    {
        return $this->hasMany(Right::class, 'rights_types_id');
    }
}