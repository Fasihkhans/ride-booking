<?php

namespace App\Observers;

use App\Helpers\Configuration;
use App\Jobs\SendMail;
use App\Mail\DriverAccountCreatationMail;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function created(User $user): void
    {
        if($user->role_id == Configuration::UserRole('driver'))
        {
            // if($user->create())
            // {
                $user->assignRole(Role::findById($user->role_id, 'api'));
                SendMail::dispatch($user->email,new DriverAccountCreatationMail($user->temp_password));
                $user->update(['temp_password' => null]);
            // }
            // else
            // {
            //     SendMail::dispatchSync($user->email,new DriverAccountCreatationMail($user->temp_password));
            //     $user->update(['temp_password' => null]);
            // }
        }
    }

    public function creating(User $user): void
    {
        if($user->role_id == Configuration::UserRole('driver'))
        {

            $user->status = true;
            $user->verified = true;
            $password = Str::random(10);
            $user->password = Hash::make($password);
            $user->temp_password = $password;
        }
    }
}