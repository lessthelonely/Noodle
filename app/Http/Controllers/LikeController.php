<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacao;
use App\Models\Gosto;
use App\Models\Notificacao;
use App\Models\Comentario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function createPost(Request $request, $id){ //you can like a comment or a post
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $like = new Gosto();
        $like->idutilizador=Auth::id();
        $post = Publicacao::find($id);
        $like->idcomentario=NULL;
        if(is_null($post))
           return view('layouts.error204');
        $like->idpublicacao = $id;
        $post->likes()->save($like);
        $post->refresh();
        $like->save();
        $like->member = Auth::user();

        //Notification
        $post = Publicacao::find($id);
        $notification=new Notificacao();
        $notification->tipo='like';
        $notification->idutilizador=$post->idutilizador;
        $notification->idgosto=$like->id;
        $notification->idpublicacao=$id;
        $notification->idcomentario=NULL;
        $notification->vista=false;
        $notification->save();    
        
        return $like;
    }

    public function createComment(Request $request, $id){ //you can like a comment or a post
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $like = new Gosto();
        $like->idutilizador=Auth::id();
        $comment= Comentario::find($id);
        if(is_null($comment)){
            return view('layouts.error204');
        }
        $like->idcomentario=$id;
        $like->idpublicacao=NULL;
        $comment->likes()->save($like);
        $comment->refresh();
        $like->save();
        $like->member = Auth::user();

        //Notification
        $comment= Comentario::find($id);
        $notification=new Notificacao();
        $notification->tipo='like';
        $notification->idutilizador=$comment->idutilizador;
        $notification->idcomentario=$id;
        $notification->idgosto=$like->id;
        $notification->idposter=Auth::id();
        $notification->idpublicacao=NULL;
        $notification->vista=false;
        $notification->save();

        return $like;
    }

    public function deletePost($id,Request $request){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $like=Gosto::where('idutilizador',Auth::id())->where('idpublicacao',$id)->get();
        $like->each->delete();
        return $like;
    }

    public function deleteComment($id, Request $request){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $like=Gosto::where('idutilizador',Auth::id())->where('idcomentario',$id)->get();
        $like->each->delete();
        return $like;
    }
}
