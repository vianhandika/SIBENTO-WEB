<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supplier;

class Sales extends Model
{
    protected $fillable = [
        'name_sales', 'phone_number_sales','id_supplier'
    ];
 
    protected $primaryKey = 'id_sales';


    public function supplier()
    {
        return $this->belongsTo('App\Supplier','id_supplier','id_supplier');
    }
}
