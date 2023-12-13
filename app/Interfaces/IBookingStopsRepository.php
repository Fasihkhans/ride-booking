<?php

namespace App\Interfaces;

use App\Models\BookingStops;

interface IBookingStopsRepository
{
    static public function create(array $data);

    static public function findLatestStops(int $userId);

    static public function updateIsFav(bool $isFav,int $id);

    public function update(BookingStops $bookig,array $data);

}
