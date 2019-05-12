<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleType;
use App\MotorcycleCustomer;

class MotorcycleTypeTransformers extends TransformerAbstract
{
    /**
     * Transform MotorcycleType.
     *
     * @param MotorcycleType $type
     */
    public function transform(MotorcycleType $type)
    {
        $motorcyclebrand = [
            'id'            => $type->motorcyclebrand->id_motorcycle_brand,
            'name'          => $type->motorcyclebrand->name_motorcycle_brand,
        ];

        return [
            'id'            => $type->id_motorcycle_type,
            'name'          => $type->name_motorcycle_type,
            'id_brand'      => $type->motorcyclebrand->id_motorcycle_brand,
            'brand'         => $motorcyclebrand,

        ];
    }
}