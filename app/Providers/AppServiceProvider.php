<?php

namespace App\Providers;

use App\Interfaces\IUserRepository;
use App\Interfaces\IVehicleTypesRepository;
use App\Interfaces\IVerificationCodeRepository;
use App\Models\VerificationCode;
use App\Repositories\UserRepository;
use App\Repositories\VehicleTypesRepository;
use App\Repositories\VerificationCodeRepository;
use Illuminate\Http\Resources\Json\JsonResource;
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
        $this->app->bind(IVehicleTypesRepository::class, VehicleTypesRepository::class);

        $this->app->bind(\Illuminate\Contracts\Debug\ExceptionHandler::class,\App\Exceptions\ApiExceptionHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}