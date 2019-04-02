<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MotorcycleType;

class MotorcycleBrand extends Model
{
    protected $fillable = [
        'name_motorcycle_brand'
    ];
 
    protected $primaryKey = 'id_motorcycle_brand';

    public function motorcycletype()
    {
        return $this->hasMany('App\MotorcycleType','id_motorcycle_brand');
    }
}
