<?php

//https://matthewdaly.co.uk/blog/2017/12/02/full-text-search-with-laravel-and-postgresql/

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'datatemporegisto';
    const UPDATED_AT = 'atualizado';

    protected $table= 'users';
    
    public $timestamps=true;
    public $fillable= ['nome', 'email', 'password', 'datanascimento', 'instituicaoensino', 'privacidade','fotoperfil'];
    
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function groups(){
        return $this->belongsToMany('App\Models\Grupo', 'grupoutilizador');
    }
    
    public function posts(){
        return $this->hasMany('App\Models\Publicacao');
    }

    public function com(){
        return $this->hasMany('App\Models\Comentario');
    }

    public function likes(){
        return $this->hasMany('App\Models\Gosto');
    }

    public function notifications(){
        return $this->hasMany('App\Models\Notificacao','idutilizador','id')
                    ->where('vista',false);
    }

    //requests to join a group
    public function grouprequests(){
        return $this->hasMany('App\Models\grupoUtilizador','idutilizador')
                    ->where('tipo_pedido','group_join')
                    ->select('grupo.id','grupo.nome','grupo.fotoperfil')
                    ->join('grupo','grupo.id','=','grupoutilizador.idgrupo');
    }

    //Functions to get friends attribute

    public function friendsOfThisUser(){
        return $this->belongsToMany('App\Models\User','colega','utilizador1','utilizador2')->withPivot('tipo_pedido')->wherePivot('tipo_pedido','confirmed');
    }

    public function thisUserFriendOf(){
        return $this->belongsToMany('App\Models\User','colega','utilizador2','utilizador1')->withPivot('tipo_pedido')->wherePivot('tipo_pedido','confirmed');
    }

    //accessor allowing you call $user->friends
    public function getFriendsAttribute(){
        if(!array_key_exists('friends',$this->relations)){
            $this->loadFriends();
        }
        return $this->getRelation('friends');
    }

    protected function loadFriends(){
		if ( !array_key_exists('friends', $this->relations)){
		   $friends = $this->mergeFriends();
           $this->setRelation('friends', $friends);
	}
	}

    protected function mergeFriends(){
		if($temp = $this->friendsOfThisUser){
            return $temp->merge($this->thisUserFriendOf);
        }
        else{
            return $this->thisUserFriendOf;
        }
	} 

    public function friendships() {
        return $this->belongsToMany(Friendship::class, "colega", "utilizador1", "utilizador2");
    }

    /*How does the Friendship System work here:
      
    Sending a friend request:utilizador1 = id of the user who is sending the friend request, utilizador2, user who's receiving it. tipo_pedido='pending'
    Accepting a friend request-> set tipo_pedido to 'confirmed'
    Rejecting a friend request & breaking off a friendship-> delete instance from the table colega*/
    
    public function friendshipRequestsOfThisUser(){
        return $this->belongsToMany('App\Models\User','colega','utilizador1','utilizador2')->withPivot('tipo_pedido')->wherePivot('tipo_pedido','pending');
    }

    public function friendshipRequestsToThisUser(){
        return $this->belongsToMany('App\Models\User','colega','utilizador2','utilizador1')->withPivot('tipo_pedido')->wherePivot('tipo_pedido','pending');
    }

    public function getFriendshipRequestAttribute(){
        if(!array_key_exists('friendship_request',$this->relations)){
            $this->loadFriendshipRequest();
        }
        return $this->getRelation('friendship_request');
    }

    protected function loadFriendshipRequest(){
		if (!array_key_exists('friendship_request', $this->relations)){
		   $friends = $this->friendshipRequestsToThisUser;
           $this->setRelation('friendship_request', $friends);
	}
	}

    //Get the groups that are moderated by the user
    public function groupMod(){
        return $this->hasMany('App\Models\Grupo','moderador');
    }

    //Get the groups a user is a member of
    public function groupMem(){
        return $this->hasMany('App\Models\grupoUtilizador','idutilizador')
                    ->where('tipo_pedido','confirmed')
                    ->select('grupo.id','grupo.nome')
                    ->join('grupo','grupo.id','=','grupoutilizador.idgrupo');
    }

    public function getProfilePic() {
        if (is_null($this->fotoPerfil))
            return "assets/img/avatar.jpg"; //need to fix name or maybe not, depending on what we write on the views
        return $this->fotoPerfil;
    }

    public function getHeaderPic() {
        if (is_null($this->fotoHeader))
            return "assets/img/banner.jpg"; //need to fix name or maybe not, depending on what we write on the views
        return $this->fotoHeader;
    }  
}