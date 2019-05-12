<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransactionService extends Model
{
    protected $table = 'detail_transaction_services';
    protected $primaryKey = 'id_detail_service';
    public $timestamps = true;
    protected $fillable = [
        'amount_transaction_service',
        'price_transaction_service',
        'subtotal_transaction_service',
        'id_transaction',
        'id_service',
        'id_employee',
        'id_motorcycle',
    ];

    protected $casts = [
        'amount_transaction_service' => 'integer',
        'price_transaction_service' => 'double',
        'subtotal_transaction_service' => 'double',
        'id_service' => 'integer',
        'id_employee' => 'integer',
        'id_motorcycle' => 'integer',
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction','id_transaction');
    }

    public function service(){
        return $this->belongsTo('App\Service','id_service');
    }

    public function mechanic(){
        return $this->belongsTo('App\Employee','id_employee');
    }

    public function motorcyclecustomer(){
        return $this->belongsTo('App\MotorcycleCustomer','id_motorcycle');
    }
}
