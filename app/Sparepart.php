<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{

    protected $primaryKey = 'id_sparepart';
    public $incrementing = false;
    protected $fillable = [
    'id_sparepart',
    'name_sparepart',
    'brand_sparepart',
    'stock_sparepart',
    'minimal_stock_sparepart',
    'buy_price',
    'sell_price',
    'placement',
    'image_sparepart',
    'id_sparepart_type'];

    public function spareparttype(){
        return $this->belongsTo('App\SparepartType','id_sparepart_type');
    }
}
