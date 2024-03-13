<?php

namespace App\Providers;

use App\Interfaces\IBookingPaymentsRepository;
use App\Interfaces\IBookingRepository;
use App\Interfaces\IBookingStopsRepository;
use App\Interfaces\ICustomerPaymentMethodsRepository;
use App\Interfaces\IDriverRepository;
use App\Interfaces\IUserRatingRepository;
use App\Interfaces\IUserRepository;
use App\Interfaces\IVehicleTypesRepository;
use App\Interfaces\IVerificationCodeRepository;
use App\Models\CustomerPaymentMethods;
use App\Models\VerificationCode;
use App\Repositories\BookingPaymentsRepository;
use App\Repositories\BookingRepository;
use App\Repositories\BookingStopsRepository;
use App\Repositories\CustomerPaymentMethodsRepository;
use App\Repositories\DriverRepository;
use App\Repositories\UserRatingRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleTypesRepository;
use App\Repositories\VerificationCodeRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

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
        $this->app->bind(IBookingRepository::class, BookingRepository::class);
        $this->app->bind(IBookingStopsRepository::class, BookingStopsRepository::class);
        $this->app->bind(IDriverRepository::class, DriverRepository::class);
        $this->app->bind(ICustomerPaymentMethodsRepository::class, CustomerPaymentMethodsRepository::class);
        $this->app->bind(IBookingPaymentsRepository::class, BookingPaymentsRepository::class);
        $this->app->bind(\Illuminate\Contracts\Debug\ExceptionHandler::class,\App\Exceptions\ApiExceptionHandler::class);
        $this->app->bind(IUserRatingRepository::class,UserRatingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Cashier::useCustomerModel(CustomerPaymentMethods::class);
    }
}
