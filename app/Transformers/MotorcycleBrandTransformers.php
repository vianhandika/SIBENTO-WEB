<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleBrand;
use App\MotorcycleType;

class MotorcycleBrandTransformers extends TransformerAbstract
{
    /**
     * Transform MotorcycleBrand.
     *
     * @param MotorcycleBrand $brand
     */
    public function transform(MotorcycleBrand $brand)
    {

        return [
            'id'            => $brand->id_motorcycle_brand,
            'name'          => $brand->name_motorcycle_brand,
            'typelist'      => $brand->motorcycletype,

        ];
    }
}