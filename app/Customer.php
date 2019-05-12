<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MotorcycleCustomer;

class Customer extends Model
{
    protected $fillable = [
        'name_customer', 'address_customer', 'phone_number_customer'
    ];
 
    protected $primaryKey = 'id_customer';

    public function motorcyclecustomer()
    {
        return $this->hasMany('App\MotorcycleCustomer','id_customer');
    }

    public function transaction(){
        return $this->hasMany('App\Transaction','id_customer');
    }
}
