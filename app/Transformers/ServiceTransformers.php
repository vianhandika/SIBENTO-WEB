<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Service;

class ServiceTransformers extends TransformerAbstract
{
    /**
     * Transform Service.
     *
     * @param Service $eervice
     */
    public function transform(Service $service)
    {
        return [
            'id_service'            => $service->id_service,
            'name_service'          => $service->name_service,
            'price_service'         => $service->price_service,
        ];
    }
}