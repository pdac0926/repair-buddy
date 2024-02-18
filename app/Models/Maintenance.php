<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'shop_id',
        'shop_name',
        'service_name',
        'service_description',
        'service_price',
        'service_status'
    ];
}
