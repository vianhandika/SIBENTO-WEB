<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SparepartProcurement;

class ProcurementTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];

    /**
     * Transform Barang.
     *
     * @param Procurement $procurement
     */
    public function transform(SparepartProcurement $procurement)
    {
        return [
            'id_procurement' => $procurement->id_procurement,
            'date_procurement' => strtok($procurement->date_procurement," ") ,
            'status_procurement' => $procurement->status_procurement,
            'id_sales' => $procurement->id_sales,
            'id_supplier' => $procurement->sales->supplier->id_supplier,
            'name_sales' => $procurement->sales->name_sales,
            'name_supplier' => $procurement->sales->supplier->name_supplier

        ];
    }

    public function includeDetail(SparepartProcurement $procurement)
    {
        return $this->collection($procurement->detailsparepartprocurement, new DetailProcurementTransformers);
    }
}