<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Authenticatable
{

    protected $table= 'administrador';
    public $timestamps=false;
    protected $guard='admin';
    
    protected $hidden = [
        'password', 'remember_token'
    ];
}
