<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function rights_types()
    {
        return $this->belongsTo(RightsType::class);
    }
}
