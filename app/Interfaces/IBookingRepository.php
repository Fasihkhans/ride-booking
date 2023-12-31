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

    static public function findDriverBookings(int $driverId);
    static public function findCustomerBookings(int $userId);

    static public function findBooking(int $id);
    static public function findDriverActiveBookings(int $driverId);

    static public function findCustomerActiveBookings(int $userId);

    static public function updateBookingStatus(string $status,int $id);

    static public function updateBookingPaymentStatus(string $status,int $id);

    static public function getActiveBookings();
    public function update(Booking $bookig,array $data);

}