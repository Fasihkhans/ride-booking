<?php

namespace App\Interfaces;

use App\Models\UserRating;

interface IUserRatingRepository
{
    public function create(array $data);

    public function update(array $data,int $id);

    public function getUserAverageRating(int $userId);
}
