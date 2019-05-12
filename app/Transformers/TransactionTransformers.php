<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'service',
        'sparepart',
        'employee'
    ];
    /**
     * Transform Barang.
     *
     * @param Transaction $transaction
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id_transaction' => $transaction->id_transaction,
            'status_process' => $transaction->status_process,
            'date_transaction' => $transaction->date_transaction,
            'status_paid' => $transaction->status_paid,
            'type_transaction' => $transaction->type_transaction,
            'discount_transaction' => $transaction->discount_transaction,
            'total_transaction' => $transaction->total_transaction,
            'id_customer' => $transaction->id_customer,
            'name_customer' => $transaction->customer->name_customer,
        ];
    }

    public function includeService(Transaction $transaction)
    {
        return $this->collection($transaction->detail_transaction_service, new DetailServiceTransformers);
    }

    public function includeSparepart(Transaction $transaction)
    {
        return $this->collection($transaction->detail_transaction_sparepart, new DetailSparepartTransformers);
    }

    public function includeEmployee(Transaction $transaction)
    {
        return $this->collection($transaction->employee, new EmployeeTransformers);
    }
}