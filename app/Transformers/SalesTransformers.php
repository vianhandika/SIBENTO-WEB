<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sales;

class SalesTransformers extends TransformerAbstract
{
    /**
     * Transform Sales.
     *
     * @param Sales $sales
     */
    public function transform(Sales $sales)
    {
        $supplier = [
            'id'            => $sales->supplier->id_supplier,
            'name'          => $sales->supplier->name_supplier,
            'phone_number'  => $sales->supplier->phone_number_supplier,
            'address_supplier'  => $sales->supplier->address_supplier,
        ];
        
        return [
            'id'            => $sales->id_sales,
            'name'          => $sales->name_sales,
            'phone_number'  => $sales->phone_number_sales,
            'supplier'      => $supplier,

        ];
    }
 

}