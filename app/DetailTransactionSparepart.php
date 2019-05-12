<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransactionSparepart extends Model
{
    protected $table = 'detail_transaction_spareparts';
    protected $primaryKey = 'id_detail_sparepart';
    public $timestamps = true;
    protected $fillable = [
        'amount_transaction_sparepart',
        'price_transaction_sparepart',
        'subtotal_transaction_sparepart',
        'id_transaction',
        'id_sparepart',
        'id_employee',
        'id_motorcycle'
    ];

    protected $casts = [
        'amount_transaction_sparepart' => 'integer',
        'price_transaction_sparepart' => 'double',
        'subtotal_transaction_sparepart' => 'double',
        
        'id_employee' => 'integer',
        'id_motorcycle' => 'integer',
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction','id_transaction');
    }

    public function sparepart(){
        return $this->belongsTo('App\Sparepart','id_sparepart');
    }

    public function mechanic(){
        return $this->belongsTo('App\Employee','id_employee');
    }

    public function motorcyclecustomer(){
        return $this->belongsTo('App\MotorcycleCustomer','id_motorcycle');
    }
}
