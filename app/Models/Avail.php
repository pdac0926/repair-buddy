<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avail extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'shop_id',
        'service_id',
        'user_id',
        'shop_name',
        'service_name',
        'service_price',
        'service_description',
        'last_odometer_reading',
        'notes',
        'arrival',
        'status',
        'message',
        'service_new_price',
        'service_price_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
