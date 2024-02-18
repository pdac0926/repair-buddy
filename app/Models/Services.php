<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'shop_id',
        'service_name',
        'service_description',
        'service_price'
    ];
}
