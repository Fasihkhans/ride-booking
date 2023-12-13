<?php

namespace App\Interfaces;

use App\Models\Booking;

interface IBookingRepository
{
    static public function create(array $data);

    static public function find(int $id);

    static public function findWithStops(int $id);

    static public function findDriverForBooking(int $vehicleId,int $driverId);
    static public function updateStatus(int $status,int $id);

    static public function assignDriver(int $driverId,int $vehicleId, int $id);

    static public function findDriverCurrentBooking(int $driverId);
    static public function findCurrentBooking(int $userId);

    static public function updateBookingStatus(string $status,int $id);
    public function update(Booking $bookig,array $data);

}
