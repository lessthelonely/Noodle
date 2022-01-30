<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comentario extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempo';
    const UPDATED_AT = 'atualizado';

    protected $table= 'comentario';
    public $timestamps=true;
    public $fillable= ['idutilizador','conteudo','idnotificacao','idpublicacao'];
    protected $appends=['liked_by_auth_user'];

    public function userCom(){
        return $this->belongsTo('App\Models\User');
    }

    public function post(){
        return $this->belongsTo('App\Models\Publicacao');
    }

    public function likes(){
        return $this->hasMany('App\Models\Gosto','idcomentario');
    }

    public function getLikedByAuthUserAttribute(){ 
        $test=$this->likes()->where('idutilizador',  Auth::id())->exists();
        return $test;
    }
}
