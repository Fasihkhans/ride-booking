<?php

namespace App\Interfaces;

use App\Models\Booking;

interface IBookingRepository
{
    static public function create(array $data);

    static public function find(int $id);

    static public function findWithStops(int $id);

    public function update(Booking $bookig,array $data);

}