<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\MotorcycleType;

class MotorcycleCustomer extends Model
{
    protected $table = 'motorcycle_customers';
    protected $fillable = [
        'plate_number', 'id_motorcycle_type', 'id_customer'
    ];
 
    protected $primaryKey = 'id_motorcycle';

    public function customer()
    {
        return $this->belongsTo('App\Customer','id_customer','id_customer');
    }

    public function motorcycletype()
    {
        return $this->belongsTo('App\MotorcycleType','id_motorcycle_type','id_motorcycle_type');
    }

}
