<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacao;
use App\Models\Comentario;
use App\Models\Gosto;
use App\Models\Notificacao;
use DB;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller {
    
    public function generalTimeline() { //Only used by Vis
        $posts=Publicacao::where('privacidade','public')->where('idgrupo',NULL)->where('idutilizador','!=',NULL)->orderBy('numerogostos','desc')->get();        
        if(is_null($posts))
           return view('layouts.error204');

        $comments= Comentario::where('idutilizador','!=',NULL)->get();
        if(Auth::guard('admin')->check()){
            return view('admin.admin_feedvis',['posts'=>$posts,'comments'=>$comments]);
        }
        
        return view('pages.feedvis',['posts'=>$posts,'comments'=>$comments]);
    }

    public function personalizedTimeline(){ //Used by Aut
        if(!Auth::check()) return redirect('/login');
        $users=User::find(Auth::id())->friends;
        
        //Check if Auth user has friends --> If they do, get the friends' posts and theirs
        $posts=Publicacao::whereIn('idutilizador', Auth::user()->friends->pluck('id'))->where('idgrupo',NULL)->orWhere('idutilizador',Auth::id())->where('idgrupo',NULL)->get();
        return view('pages.feedaut_withposts',['posts'=>$posts]);
    }
}