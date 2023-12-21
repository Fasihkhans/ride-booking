<?php

namespace App\Interfaces;

use App\Models\BookingStops;

interface IBookingStopsRepository
{
    static public function create(array $data);

    static public function findLatestStops(int $userId);

    /**
     * mark isfavourite stop true / false
     *
     * @param bool $isFav
     * @param int $id
     * @return bool
     */
    static public function updateIsFav(bool $isFav,int $id): bool;

    /**
     * Add driver coordinates on pickup point
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $id
     * @return bool
     */
    static public function addDriverPickUpCoordinates(float $latitude,float $longitude,int $id): bool;

    /**
     * Add driver coordinates on dropOff point
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $id
     * @return bool
     */
    static public function addDriverDropOffCoordinates(float $latitude,float $longitude,int $id): bool;

    public function update(BookingStops $bookig,array $data);

}
