<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SessionToken extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id_session';
    protected $fillable = [
        'encrypt_username', 'encrypt_password', 'generated_at','lastused_at','id_user'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'id_user'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }
    
    
}
