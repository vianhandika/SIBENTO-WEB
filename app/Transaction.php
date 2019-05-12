<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = [
        'date_transaction',
        'status_paid',
        'status_process',
        'type_transaction',
        'discount_transaction',
        'total_transaction',
        'id_customer'
    ];

    protected $casts = [
        'discount_transaction' => 'double',
        'total_transaction' => 'double',
        'id_customer' => 'integer'
    ];

    public function employee(){
        return $this->belongsToMany('App\Employee','employee_onduties','id_transaction','id_employee');
    }

    public function detail_transaction_sparepart(){
        return $this->hasMany('App\DetailTransactionSparepart','id_transaction');
    }

    public function detail_transaction_service(){
        return $this->hasMany('App\DetailTransactionService','id_transaction');
    }

    public function customer(){
        return $this->belongsTo('App\Customer','id_customer');
    }
}
