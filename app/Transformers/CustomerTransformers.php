<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\MotorcycleCustomerTransformers;
use App\Customer;
use App\MotorcycleCustomer;

class CustomerTransformers extends TransformerAbstract
{
    /**
     * Transform Customer.
     *
     * @param Customer $customer
     */
    protected $defaultIncludes = [
        'motorcycle'
    ];

    public function transform(Customer $customer)
    {

        return [
            'id'            => $customer->id_customer,
            'name'          => $customer->name_customer,
            'phone_number'  => $customer->phone_number_customer,
            'address'       => $customer->address_customer,
            
        ];
    }

    public function includeMotorcycle(Customer $customer)
    {
        $motorcycle = $customer->motorcyclecustomer;
        return $this->collection($motorcycle, new MotorcycleCustomerTransformers);
    }
}