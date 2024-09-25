<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventsViewStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Event(){
        return $this->hasMany(Event::class, 'public_or_private');
    }
}
