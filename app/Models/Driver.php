<?php

namespace App\Models;

use App\Casts\DriverStatusCast;
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
        'is_online',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'is_online' => 'boolean',
    ];

    public function driverVehicles()
    {
        return $this->hasMany(DriverVehicles::class);
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