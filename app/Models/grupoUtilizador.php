<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grupoUtilizador extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempocriacao';
    const UPDATED_AT = 'atualizado';

    protected $table= 'grupoutilizador';
    public $timestamps=true;
    public $fillable= ['id','idutilizador','idgrupo','tipo_pedido'];
}