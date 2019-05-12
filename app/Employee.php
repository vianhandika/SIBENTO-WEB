<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Branch;
use App\Role;
use App\User;

class Employee extends Model
{
    protected $fillable = [
        'name_employee', 'salary', 'phone_number','address','id_user','id_branch','id_role'
    ];
 
    protected $primaryKey = 'id_employee';


    public function user()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function role()
    {
        return $this->belongsTo('App\Role','id_role','id_role');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','id_branch','id_branch');
    }
    
    public function transaction(){
        return $this->belongsToMany('App\Transaction','employee_onduties','id_employee','id_transaction');
    }

    public function detail_transaction_service(){
        return $this->hasMany('App\DetailTransactionService','id_employee');
    }

    public function detail_transaction_sparepart(){
        return $this->hasMany('App\DetailTransactionSparepart','id_employee');
    }


}
