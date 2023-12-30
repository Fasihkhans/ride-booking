<?php

namespace App\Interfaces;

use App\Models\Driver;

interface IDriverRepository
{
    static public function create(array $data);

    static public function getAllActiveDrivers();

    static public function findByUserID(int $userId);

    static public function findByIdWithUser(int $id);

    static public function onlineStatus(bool $status,int $id);

    static public function isOnline(int $id);
    public function update(Driver $driver,array $data);

}