<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    use HasFactory;

    protected $table = 'user_ratings';

    protected $fillable = [
        'user_id',
        'booking_id',
        'rating',
        'review'
    ];

    protected $cast =[
        'rating' =>'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class,"booking_id");
    }
}
