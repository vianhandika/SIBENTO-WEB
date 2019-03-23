<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $primaryKey = 'id_service';

    protected $fillable = [
        'name_service', 'price_service'
    ];
}
