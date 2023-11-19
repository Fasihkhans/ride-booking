<?php

namespace App\Providers;

use App\Interfaces\IUserRepository;
use App\Interfaces\IVerificationCodeRepository;
use App\Models\VerificationCode;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IVerificationCodeRepository::class, VerificationCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
