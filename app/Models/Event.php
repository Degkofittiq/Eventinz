<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function eventOwner()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'id');
    }

    public function vendorTypes()
    {
        return $this->belongsToMany(VendorType::class, 'vendor_type_event', 'event_id', 'vendor_type_id');
    }

}
