<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;

    const CREATED_AT = 'datatempo';
    const UPDATED_AT = 'atualizado';

    protected $table= 'notificacao';
    public $timestamps=true;

    static $tiponotificacao=['comment','like','post'];


    //Scope a query to only include notifications not seen
    public function scopeNotSeen($query){
        return $query->where('vista',false);
    }

    public function scopePosts($query){
        return $query->where('vista',false)->where('tipo','post');
    }

    public function scopeComments($query){
        return $query->where('vista',false)->where('tipo','comment');
    }

    public function scopeLikes($query){
        return $query->where('vista',false)->where('tipo','like');
    }

    public function post(){
        return $this->belongsTo('App\Models\Publicacao');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function comment(){
        return $this->belongsTo('App\Models\Comentario');
    }

    public function like(){
        return $this->belongsTo('App\Models\Gosto');
    }

}