<?php

namespace App\Repositories;

use App\Interfaces\IUserRatingRepository;
use App\Models\UserRating;

class UserRatingRepository implements IUserRatingRepository
{

    public function create(array $data)
    {
        return UserRating::create($data);
    }

    public function update(array $data,int $id)
    {
        //
    }

    public function getUserAverageRating(int $userId)
    {
        return UserRating::where('user_id',$userId)->avg('rating');
    }
}
