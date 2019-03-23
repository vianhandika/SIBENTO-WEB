<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sales;

class Supplier extends Model
{
    protected $fillable = [
        'name_supplier', 'phone_number_supplier','address_supplier'
    ];
 
    protected $primaryKey = 'id_supplier';


    public function sales()
    {
        return $this->hasMany('App\Sales','id_supplier');
    }
}
