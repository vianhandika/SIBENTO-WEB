<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class Branch extends Model
{
    protected $fillable = [
        'name_branch','address_branch'
    ];

    protected $primaryKey = 'id_branch';

    public function employee()
    {
        return $this->hasMany('App\Employee','id_branch');
    }

}
