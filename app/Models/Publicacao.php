<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class Publicacao extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempo';
    const UPDATED_AT = 'atualizado';

    protected $table= 'publicacao';
    public $timestamps=true;
    public $fillable= ['idutilizador','conteudo', 'anexo'];

    protected $appends=['liked_by_auth_user'];

    public function user(){
        return $this->belongsTo('App\Models\User','idutilizador','id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comentario','idpublicacao');
    }

    public function likes(){
        return $this->hasMany('App\Models\Gosto','idpublicacao');
    }

    public function groupPub(){
        return $this->belongsTo('App\Models\Grupo');
    }

    public function getUserName($id){
        return BD::table('utilizador')->select('nome')->where('id','=',$id)->get();
    }

    public function getAnexo() {
        if (is_null($this->anexo))
            return NULL; //need to fix name or maybe not, depending on what we write on the views
        return $this->anexo;
    }
  
    public function getCorpo() {
        if (is_null($this->conteudo))
            return NULL;
        return $this->conteudo;
    }

    public function getLikedByAuthUserAttribute(){
        $test=$this->likes()->where('idutilizador',  Auth::id())->exists();
        return $test;
    }
}
