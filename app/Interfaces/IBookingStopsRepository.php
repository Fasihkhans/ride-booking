<?php

namespace App\Interfaces;

use App\Models\BookingStops;

interface IBookingStopsRepository
{
    static public function create(array $data);

    public function update(BookingStops $bookig,array $data);

}