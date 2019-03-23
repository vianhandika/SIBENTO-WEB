<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Session extends Model
{
    protected $fillable = [
        'encrypt_username', 'encrypt_password', 'generated_at','lastused_at','id_user'
    ];

    
    
}
