<?php

namespace App\Interfaces;

use App\Models\Driver;

interface IDriverRepository
{
    static public function create(array $data);

    public function update(Driver $driver,array $data);

}