<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparepartProcurement extends Model
{
    protected $table = 'sparepart_procurements';
    protected $primaryKey = 'id_procurement';
    public $timestamps = true;
    protected $fillable = [
        'date_procurement',
        'status_procurement',
        'id_sales',
    ];

    public function sales(){
        return $this->belongsTo('App\Sales','id_sales');
    }

    public function detailsparepartprocurement(){
        return $this->hasMany('App\DetailSparepartProcurement','id_procurement');
    }
}
