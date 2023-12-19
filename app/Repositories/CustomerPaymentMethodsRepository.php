<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Interfaces\ICustomerPaymentMethodsRepository;
use App\Models\CustomerPaymentMethods;

class CustomerPaymentMethodsRepository implements ICustomerPaymentMethodsRepository
{
    static public function create(array $data)
    {
        return CustomerPaymentMethods::create($data);
    }

}