<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'shopID',
        'convoID',
        'message'
    ];
}
