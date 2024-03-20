<?php

namespace App\Observers;

use App\Constants\Constants;
use App\Helpers\Configuration;
use App\Interfaces\ICustomerPaymentMethodsRepository;
use App\Jobs\SendMail;
use App\Mail\DriverAccountCreatationMail;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function __construct(private ICustomerPaymentMethodsRepository $iCustomerPaymentMethodsRepository)
    {

    }
    public function created(User $user): void
    {
        if($user->role_id == Configuration::UserRole('driver'))
        {
            $user->assignRole(Role::findById($user->role_id, 'api'));
            SendMail::dispatch($user->email,new DriverAccountCreatationMail($user->temp_password,$user->first_name.' '.$user->last_name,$user->email));
            $user->temp_password = null;
            $user->update();

        }
        if($user->role_id == Configuration::UserRole('user'))
        {
            $this->iCustomerPaymentMethodsRepository::create([
                                                        'user_id'=>$user->id,
                                                        'name' => "cash",
                                                        'status' => Constants::ACTIVE
                                                    ]);
            // $this->iCustomerPaymentMethodsRepository::create([
            //                                             'user_id'=>$user->id,
            //                                             'name' => "card",
            //                                             'status' => Constants::ACTIVE
            //                                         ]);
        }

    }

    public function creating(User $user): void
    {
        if($user->role_id == Configuration::UserRole('driver'))
        {
            $user->status = 'active';
            $user->verified = true;
            $password = Str::random(10);
            $user->password = Hash::make($password);
            $user->temp_password = $password;
        }
    }
}
