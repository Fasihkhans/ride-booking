<?php

namespace App\Observers;

use App\Helpers\Configuration;
use App\Jobs\SendMail;
use App\Mail\AccountVerificationMail;
use App\Models\VerificationCode;

class VerificationCodeObserver
{
    /**
     * Handle the VerificationCode "created" event.
     */
    public function created(VerificationCode $verificationCode): void
    {
        if($verificationCode->Queue())
        {
            SendMail::dispatch($verificationCode->Recipient(),new AccountVerificationMail($verificationCode->code));
        }
        else
        {
            SendMail::dispatchSync($verificationCode->Recipient(),new AccountVerificationMail($verificationCode->code));
        }
    }

    /**
     * Handle the VerificationCode "updated" event.
     */
    public function updated(VerificationCode $verificationCode): void
    {
        //
    }

    /**
     * Handle the VerificationCode "deleted" event.
     */
    public function deleted(VerificationCode $verificationCode): void
    {
        //
    }

    /**
     * Handle the VerificationCode "restored" event.
     */
    public function restored(VerificationCode $verificationCode): void
    {
        //
    }

    /**
     * Handle the VerificationCode "force deleted" event.
     */
    public function forceDeleted(VerificationCode $verificationCode): void
    {
        //
    }
}
