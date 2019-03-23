<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SparepartType;

class SparepartTypeTransformers extends TransformerAbstract
{
    /**
     * Transform SparepartType.
     *
     * @param SparepartType $spareparttype
     */
    public function transform(SparepartType $spareparttype)
    {
        return [
            'id'                        => $spareparttype->id_sparepart_type,
            'name'                      => $spareparttype->name_sparepart_type,
        ];
    }
}