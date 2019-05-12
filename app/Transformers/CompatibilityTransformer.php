<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleType;

class CompatibilityTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param MotorcycleType $motorcycle
     */
    public function transform(MotorcycleType $motorcycle)
    {
        return [
            'id' => $motorcycle->id_motorcycle_type,
            'name' => $motorcycle->name_motorcycle_type,
        ];
    }
}