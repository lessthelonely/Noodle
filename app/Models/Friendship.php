<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $table= 'colega';
    public $timestamps=false;
    public $fillable= ['id','utilizador1','utilizador2','tipo_pedido'];
}