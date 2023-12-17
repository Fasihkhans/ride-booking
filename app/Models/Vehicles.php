<?php

namespace App\Models;

use App\Casts\VehicleStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type_id',
        'license_no_plate',
        'make',
        'model',
        'year',
        'color',
        'max_capacity',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => VehicleStatusCast::class,
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function vehicleUploads()
    {
        return $this->hasMany(VehicleUploads::class);
    }

    public function vehicleBookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function driverVehicles()
    {
        return $this->hasMany(DriverVehicles::class);
    }
}