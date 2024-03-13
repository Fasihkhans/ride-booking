<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\UserStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'verified',
        'password',
        'status',
        'profile_photo_path',
        'aggregate_rating'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'verified'
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'gender' => 'boolean',
        'status' => UserStatusCast::class,
    ];
    public function Role()
    {
        return $this->belongsTo(Role::class,'role_id', 'id');
    }

    public function customerPaymentMethods()
    {
        return $this->hasMany(CustomerPaymentMethods::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function IsVerified(){
        return $this->verified;
    }

    public function rating()
    {
        return $this->hasMany(UserRating::class);
    }
}
