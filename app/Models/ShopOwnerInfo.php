<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOwnerInfo extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'shopName',
        'shopPhone',
        'shopAddress',
        'shopLong',
        'shopLat',
        'shopDescription',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
