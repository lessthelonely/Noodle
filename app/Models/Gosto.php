<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gosto extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempocriacao';
    const UPDATED_AT = 'atualizado';

    protected $table= 'gosto';
    public $timestamps=true;
    public $fillable= ['id','idutilizador','idnotificacao','idpublicacao','idcomentario'];
    
    public function user(){
        return $this->belongsTo('App\Models\User','idutilizador','id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Publicacao','idpublicacao','id');
    }

    public function comment(){
        return $this->belongsTo('App\Models\Comentario','idcomentario','id');
    }
}