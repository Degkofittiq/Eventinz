<?php

namespace App\Models;

use App\Models\Event;
use App\Models\EventSubcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventType extends Model
{
    use HasFactory;
    protected $guarded = [];
    // event_types_id

    public function eventSubcategories(){
        return $this->hasMany(EventSubcategory::class);
    }
}
