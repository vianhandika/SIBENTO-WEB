<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\DetailTransactionSparepart;

class DetailSparepartTransformers extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param DetailTransactionSparepart $detail_service
     */
    public function transform(DetailTransactionSparepart $detail_sparepart)
    {
        return [
            'id_detail_sparepart' => $detail_sparepart->id_detail_sparepart,
            'amount_transaction_sparepart' => $detail_sparepart->amount_transaction_sparepart,
            'price_transaction_sparepart' => $detail_sparepart->price_transaction_sparepart,
            'subtotal_transaction_sparepart' => $detail_sparepart->subtotal_transaction_sparepart,
            'id_transaction' => $detail_sparepart->id_transaction,
            'id_sparepart' => $detail_sparepart->id_sparepart,
            'type_sparepart' => $detail_sparepart->sparepart->spareparttype->name_sparepart_type,
            'name_sparepart' => $detail_sparepart->sparepart->name_sparepart,
            'brand_sparepart' => $detail_sparepart->sparepart->brand_sparepart,
            'id_mechanic' => $detail_sparepart->id_employee,
            'mechanic_name' => $detail_sparepart->mechanic->name_employee,
            'id_motorcycle' => $detail_sparepart->motorcyclecustomer->id_motorcycle,
            'plate_number' => $detail_sparepart->motorcyclecustomer->plate_number,
        ];
    }
}