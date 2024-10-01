<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userSupportsAndHelp extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function Adminuser(){
        
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function user(){
        
        return $this->belongsTo(User::class, 'users_id');
    }
}
