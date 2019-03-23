<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sparepart;

class SparepartTransformers extends TransformerAbstract
{
    /**
     * Transform Sparepart.
     *
     * @param Sparepart $sparepart
     */
    public function transform(Sparepart $sparepart)
    {
        $placement = explode('-',trim($sparepart->placement));
        return [
            'id'                        => $sparepart->id_sparepart,
            'name'                      => $sparepart->name_sparepart,
            'brand'                     => $sparepart->brand_sparepart,
            'type'                      => $sparepart->spareparttype->name_sparepart_type,
            'stock'                     => $sparepart->stock_sparepart,
            'min_stock'                 => $sparepart->minimal_stock_sparepart,
            'buy_price'                 => $sparepart->buy_price,
            'sell_price'                => $sparepart->sell_price,
            'placement'                 => $sparepart->placement,
            'placement_position'        => $placement[0],
            'placement_place'           => $placement[1],
            'placement_number'          => $placement[2],
            'image'                     => $sparepart->image_sparepart,
        ];
    }
}