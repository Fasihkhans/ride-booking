<?php

namespace App\Models;

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
}
