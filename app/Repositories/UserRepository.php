<?php

namespace App\Repositories;

use App\Helpers\Configuration;
use App\Helpers\Helper;
use App\Interfaces\IUserRepository;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function getById(int $id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function getWhere($column, $match)
    {
        return User::where($column, $match)->first();
    }

    public function generateBearerToken(User $user, bool $revokeExisting)
    {
        if ($revokeExisting) {
            $existingTokens = $user->tokens;
            foreach ($existingTokens as $token) {
                $token->revoke();
            }
        }
        return $user->createToken('Password Grant Client')->accessToken;
    }

    public function logout(User $user, bool $fromEverywhere)
    {
        if ($fromEverywhere) {
            foreach ($user->tokens as $token) {
                $token->revoke();
            }
            return true;
        }
        $user->token()->revoke();
        return true;
    }

    public function hasRole(User $user, string $name)
    {
        return $user->hasRole($name) ? true : false;
    }

    public function getStatus(User $user)
    {
        switch ($user->status){
            case (1):
                return "active";
            case (0):
                return "suspended";
            default:
                return $user->stauts;
        }
    }

    public function allowedLogin(User $user)
    {
        return $user->status;
    }

    public function isVerified(User $user)
    {
        return $user->IsVerified();
    }

    public function hasOAuth(User $user)
    {
        return $user->OAuthAccounts?->count() > 0 ? true : false;
    }

    public function createFromOAuth(array $data)
    {
        return User::create(array_merge($data, ['password' => Helper::randomString(8), 'verified' => '1']));
    }

    public function updatePassword(User $user, string $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        return true;
    }

    public function updateName(User $user, string $name)
    {
        $user->full_name = $name;
        $user->save();
        return true;
    }

    public function validatePassword(User $user, string $password)
    {
        return Hash::check($password, $user->password);
    }
    public function updateStatus(int $userId, string $status)
    {
        $user = User::find($userId);
        $user->status = $status;
        return $user->save();
    }

    public function updateDeviceToken(int $userId, string $deviceToken)
    {
        $user = User::find($userId);
        $user->device_token = $deviceToken;
        return $user->save();
    }
    static public function update(array $data)
    {
        $user = User::find($data['id']);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone_number = $data['phone_number'];
        $user->email = $data['email'];
        $user->status = $data['status'];
        return $user->save();
    }

    public function destory(int $id)
    {
        $user = User::find($id);
        $user->email = 'deleteduser'.$user->id.'@yopmail.com';
        $user->first_name = 'deleted';
        $user->last_name = 'user';
        $user->password = $user->id.'@yopmail.com';
        $user->phone_number = $user->id;
        return $user->save();
    }

    public function updateAggregateRating(int $rating,int $userId)
    {
        $user = User::find($userId);
        $user->aggregate_rating = $rating;
        return $user->save();
    }
}
