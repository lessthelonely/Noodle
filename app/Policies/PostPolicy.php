<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Publicacao;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user){
        // Any user can create a new post
      return Auth::check();
    }

    public function show(Publicacao $post, User $user){
      // Any user can show a post
      return Auth::check();
    }

    public function edit(User $user, Publicacao $post){
      // User can only edit items in posts they own
      return $user->id == $post->idUtilizador;
    }

    public function update(User $user, Publicacao $post){
        // User can only update items in posts they own
      return $user->id == $post->idUtilizador;
    }

    public function delete(User $user, Publicacao $post){ //not gonna add admin here because will make a function in their controller so they don't have to access the function in Publicacao
        return $user->id == $post->idutilizador;
    }
}