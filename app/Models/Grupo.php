<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempocriacao';
    const UPDATED_AT = 'atualizado';

    protected $table= 'grupo';
    public $timestamps=true;
    public $fillable= ['nome', 'privacidade', 'tipogrupo','descricao','fotoperfil','fotoheader'];
    
    public function members(){
        return $this->hasMany('App\Models\grupoUtilizador','idgrupo')
                    ->where('tipo_pedido','confirmed')
                    ->select('users.id','users.nome','users.fotoperfil')
                    ->join('users','users.id','=','grupoutilizador.idutilizador');
    }

    //requests to enter the group
    public function requests(){
        return $this->hasMany('App\Models\grupoUtilizador','idgrupo')
                    ->where('tipo_pedido','pending')
                    ->select('users.id','users.nome','users.fotoperfil')
                    ->join('users','users.id','=','grupoutilizador.idutilizador');
    }
}
