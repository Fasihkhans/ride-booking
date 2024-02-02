<?php

namespace App\Interfaces;

use App\Models\CustomerPaymentMethods;

interface ICustomerPaymentMethodsRepository
{
    static public function create(array $data);

    public function getById(int $id);

    public function getWhere($column, $match);

    public function destroy(int $id);

    public function IsDefault(int $id,bool $isDefault);
}