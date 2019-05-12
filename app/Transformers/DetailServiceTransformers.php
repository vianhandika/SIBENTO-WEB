<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\DetailTransactionService;

class DetailServiceTransformers extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param DetailTransactionService $detail_service
     */
    public function transform(DetailTransactionService $detail_service)
    {
        return [
            'id_detail_service' => $detail_service->id_detail_service,
            'amount_transaction_service' => $detail_service->amount_transaction_service,
            'price_transaction_service' => $detail_service->price_transaction_service,
            'subtotal_transaction_service' => $detail_service->subtotal_transaction_service,
            'id_transaction' => $detail_service->id_transaction,
            'id_service' => $detail_service->id_service,
            'service_name' => $detail_service->service->name_service,
            'id_mechanic' => $detail_service->id_employee,
            'mechanic_name' => $detail_service->mechanic->name_employee,
            'id_motorcycle' =>$detail_service->motorcyclecustomer->id_motorcycle,
            'plate_number' => $detail_service->motorcyclecustomer->plate_number,
        ];
    }
}