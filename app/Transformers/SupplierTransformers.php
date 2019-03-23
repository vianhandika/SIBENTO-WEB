<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Supplier;
use App\Sales;

class SupplierTransformers extends TransformerAbstract
{
    /**
     * Transform Supplier.
     *
     * @param Supplier $supplier
     */
    public function transform(Supplier $supplier)
    {

        // $sales = [
        //     'id'            => $supplier->sales()->id_sales,
        //     'name'          => $supplier->sales()->name_sales,
        //     'phone_number'  => $supplier->sales()->phone_number_sales,
        // ];


        return [
            'id'            => $supplier->id_supplier,
            'name'          => $supplier->name_supplier,
            'phone_number'  => $supplier->phone_number_supplier,
            'address'       => $supplier->address_supplier,
            'sales'         => $supplier->sales,

        ];
    }
 

}