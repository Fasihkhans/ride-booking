<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data);
    public function getById(int $id);
    public function getWhere(string $column, $match);

    public function createFromOAuth(array $data);
    public function generateBearerToken(User $user, bool $revokeExisting);
    public function hasRole(User $user, string $name);
    public function getStatus(User $user);
    public function isVerified(User $user);
    public function hasOAuth(User $user);
    public function updatePassword(User $user, string $password);
    public function updateName(User $user, string $name);
    public function logout(User $user, bool $fromEverywhere);
    public function allowedLogin(User $user);
    public function validatePassword(User $user, string $password);
}
