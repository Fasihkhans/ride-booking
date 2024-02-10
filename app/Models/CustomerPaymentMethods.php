<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class CustomerPaymentMethods extends Model
{
    use HasFactory;
    use Billable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        "user_id",
        "type",
        "name",
        "card_number",
        "stripe_card_reference",
        "is_default",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function bookingPayments()
    {
        return $this->hasMany(BookingPayments::class);
    }
}
