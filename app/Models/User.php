<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'address',
        'avatar',
        'email',
        'password',
        'role',
        'privacyPolicy',
        'status',
        'phoneNumber'
    ];

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
        'password' => 'hashed',
    ];

    protected $primaryKey='id';

    public function driverInfo()
    {
        return $this->hasOne(DriverInfo::class);
    }

    public function mechanicInfo()
    {
        return $this->hasMany(MechanicInfo::class, 'user_id');
    }

    public function shopOwnerInfo()
    {
        return $this->hasOne(ShopOwnerInfo::class);
    }
}
