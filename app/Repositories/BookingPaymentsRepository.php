<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Interfaces\IBookingPaymentsRepository;
use App\Models\BookingPayments;

class BookingPaymentsRepository implements IBookingPaymentsRepository
{
    static public function create(array $data)
    {
        return BookingPayments::create($data);
    }

}
