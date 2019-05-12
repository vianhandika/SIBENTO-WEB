<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MotorcycleCustomer;
use App\MotorcycleBrand;

class MotorcycleType extends Model
{
    protected $fillable = [
        'name_motorcycle_type','id_motorcycle_brand'
    ];
 
    protected $primaryKey = 'id_motorcycle_type';

    public function motorcyclecustomer()
    {
        return $this->hasMany('App\MotorcycleCustomer','id_motorcycle_type');
    }
    public function motorcyclebrand()
    {
        return $this->belongsTo('App\MotorcycleBrand','id_motorcycle_brand','id_motorcycle_brand');
    }
    public function sparepart(){
        return $this->belongsToMany('App\Sparepart','sparepart_compatibilities','id_motorcycle_type','id_sparepart');
    }

}
