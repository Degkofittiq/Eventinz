<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\Paymenthistory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable, CanResetPassword;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'facebook_id',
    //     'google_id',
    //     'role_id',
    //     'vendor_service_types_id',
    //     'vendor_categories_id',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'profile_image' => 'array', // Cast la colonne images comme tableau
    ];
    

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'users_id');
    }
    // 
    
    public function paymenthistory()
    {
        return $this->hasMany(Paymenthistory::class, 'id');
    }

    // 
    public function subscription()
    {
        return $this->hasMany(Subscription::class, 'id');
    }

    // userSupportsAndHelp
    public function userSupportsAndHelp()
    {
        return $this->hasMany(userSupportsAndHelp::class);
    }
}
