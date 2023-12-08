<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_no',
        'license_expiry',
        'license_img_url',
    ];

    protected $casts = [
        'license_expiry' => 'date',
    ];

    public function driverVehicles()
    {
        return $this->hasMany(DriveVehicles::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}