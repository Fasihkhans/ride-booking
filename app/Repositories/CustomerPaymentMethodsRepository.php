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

    public function getById(int $id)
    {
        return CustomerPaymentMethods::find($id);
    }

    public function getWhere($column, $match)
    {
        return CustomerPaymentMethods::where($column, $match);
    }

    public function destroy(int $id)
    {
        return CustomerPaymentMethods::destroy($id);
    }


    public function IsDefault(int $id,bool $isDefault)
    {

        $method = $this->getById($id);
        $method->is_default = $isDefault;
        $method->save();

        return $method;
    }
}