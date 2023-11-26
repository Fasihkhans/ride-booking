<?php

namespace App\Interfaces;

use App\Models\Driver;

interface IDriverRepository
{
    public function create(array $data);

    public function update(Driver $driver,array $data);

}
