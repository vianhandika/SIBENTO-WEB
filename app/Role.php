<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class Role extends Model
{
    protected $fillable = [
        'name_role'
    ];
    
    protected $primaryKey = 'id_role';

    public function employee()
    {
        return $this->hasMany('App\Employee','id_role');
    }
}
