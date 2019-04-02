<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleCustomer;
// use App\MotorcycleType;
// use App\MotorcycleBrand;

class MotorcycleCustomerTransformers extends TransformerAbstract
{
    /**
     * Transform MotorcycleCustomer.
     *
     * @param MotorcycleCustomer $motor
     */
    public function transform(MotorcycleCustomer $motor)
    {
        $customer=[
            'id'            => $motor->customer->id_customer,
            'name'          => $motor->customer->name_customer,
            'phone_number'  => $motor->customer->phone_number_customer,
            'address'       => $motor->customer->address_customer,
        ];

        return [
            'id'            => $motor->id_motorcycle,
            'plate'         => $motor->plate_number,
            'type'          => $motor->motorcycletype->name_motorcycle_type,
            'id_type'       => $motor->motorcycletype->id_motorcycle_type,
            'brand'         => $motor->motorcycletype->motorcyclebrand->name_motorcycle_brand,
            'id_brand'      => $motor->motorcycletype->motorcyclebrand->id_motorcycle_brand,
            'customer'      => $customer

        ];
    }
}