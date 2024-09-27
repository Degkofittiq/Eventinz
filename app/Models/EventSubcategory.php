<?php

namespace App\Models;

use App\Models\EventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSubcategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function eventType(){ // eventType
        return $this->belongsTo(EventType::class, 'event_types_id');
    }
}
