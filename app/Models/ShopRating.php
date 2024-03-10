<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRating extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'shop_id',
        'user_id',
        'service_id',
        'service_name',
        'service_rate',
        'comment'
    ];
}
