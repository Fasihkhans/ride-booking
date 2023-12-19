<?php

namespace App\Interfaces;

use App\Models\CustomerPaymentMethods;

interface ICustomerPaymentMethodsRepository
{
    static public function create(array $data);

}
