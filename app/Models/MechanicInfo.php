<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicInfo extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'mechanicShopOwnerId',
        'mechanicAddress',
        'mechanicPhone',
        'mechanicRating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
