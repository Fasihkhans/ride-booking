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



}
