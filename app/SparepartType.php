<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparepartType extends Model
{

    protected $primaryKey = 'id_sparepart_type';

    protected $fillable = [
    'name_sparepart_type',];

    public function sparepart()
    {
        return $this->hasMany('App\Sparepart','id_sparepart_type');
    }
}
