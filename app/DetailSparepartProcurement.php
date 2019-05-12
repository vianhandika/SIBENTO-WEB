<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSparepartProcurement extends Model
{
    protected $table = 'detail_sparepart_procurements';
    protected $primaryKey = 'id_detail_procurement';
    public $timestamps = true;
    protected $fillable = [
        'price_detail_procurement',
        'subtotal_detail_procurement',
        'amount_detail_procurement',
        'id_procurement',
        'id_sparepart'
        
    ];

    protected $casts = [
        'price_detail_procurement' => 'double',
        'subtotal_detail_procurement' => 'double',
        'amount_detail_procurement' => 'integer',
        'id_procurement' => 'integer',
        'id_sparepart' => 'string',
    ];

    public function sparepartprocurement(){
        return $this->belongsTo('App\SparepartProcurement','id_procurement');
    }

    public function sparepart(){
        return $this->belongsTo('App\Sparepart','id_sparepart');
    }
}
