<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\DetailSparepartProcurement;

class DetailProcurementTransformers extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param DetailProcurementTransformers $procurement_detail
     */
    public function transform(DetailSparepartProcurement $procurement_detail)
    {
        return [
            'id_procurement_detail' => $procurement_detail->id_detail_procurement,
            'price' => $procurement_detail->price_detail_procurement,
            'sell_price' => $procurement_detail->sparepart->sell_price,
            'amount' => $procurement_detail->amount_detail_procurement,
            'subtotal' => $procurement_detail->subtotal_detail_procurement,
            'id_procurement' => $procurement_detail->id_procurement,
            'id_sparepart' => $procurement_detail->id_sparepart,
            'name_sparepart' => $procurement_detail->sparepart->name_sparepart
        ];
    }

}