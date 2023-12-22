<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInfo extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'driversLicensePhoto',
        'driverCertificatePhoto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
