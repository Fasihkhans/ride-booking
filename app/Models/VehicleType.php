<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fare',
        'upload_url',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class);
    }
}
