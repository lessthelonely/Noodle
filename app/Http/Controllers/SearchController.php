<?php

//https://laraveldaily.com/all-about-redirects-in-laravel-5/
//https://stackoverflow.com/questions/62627035/laravel-search-only-exact-match

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Response;

use App\Models\Publicacao;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Grupo;
use App\Models\grupoUtilizador;

class SearchController extends Controller 
{
    /*Search through multiple attributes-> get the search text and look through Users, Posts, Comments and Groups(if we do them)
    and see if there's any match or multiple matches*/
    public function searchVis(Request $request){ //Visitantes can't access private objects
      $validated=$request->validate([
        'search'=>'required|max:255'
      ]);
      
      $query=$request->search;

      //Users: (only one where it matters if it had " " or not)
      if(preg_match('/"/', $query)){ //exact search match
        $output=trim($query,'"');
        $users= User::where('nome',$output)->where('privacidade','public')->get();
        $groups= Grupo::where('nome',$output)->where('privacidade','public')->get();
      }
      else{ //full text search
        $users = User::where('privacidade','public')->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 

        $groups = Grupo::where('privacidade','public')->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 
      }       

      //Posts
      $posts = Publicacao::where('privacidade','public')->where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
      ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
      ->limit(5)->get(); 

      //Comments
      $comments = Comentario::where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 

      
      if($users->isEmpty() && $posts->isEmpty() && $comments->isEmpty() && $groups->isEmpty()){
          return view('layouts.error204');
      }

        return view('pages.view_search_results',[ 
          'users'=>$users,
          'posts'=>$posts,
          'comments'=>$comments,
          'groups'=>$groups]);
    }

    public function searchAut(Request $request){//Aut can see all data
      $users=null;
      $comments=null;
      $posts=null;
      $groups=null;

      $validated=$request->validate([
        'search'=>'required|max:255'
      ]);
      
      $query=$request->search;
      $id=0;

      if(!(is_null($request->username_search))){
      //Users: (only one where it matters if it had " " or not)
      $query_search=$request->username_search;
      if(preg_match('/"/', $query_search)){ //exact search match
        $output=trim($query_search,'"');
        $users= User::where('nome',$output)->get();
      }
      else{ //full text search
        $users = User::whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query_search])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query_search])
        ->limit(5)->get(); 
      }

      foreach($users as $user){
        $id=$user->id;
      }

      if($request->has('posts')){
        if($id==0){
          $posts = Publicacao::where('privacidade','public')->where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
          ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
          ->limit(5)->get(); 
        }
        else{
          //Posts
          $posts = Publicacao::where('idutilizador',$id)->where('privacidade','public')->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
                              ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
                               ->limit(5)->get(); 
        }    
      }
      if($request->has('comments')){
        if($id==0){
          $comments = Comentario::where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
                                ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
                                ->limit(5)->get(); 

        }
        else{
          $comments = Comentario::where('idutilizador',$id)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
                                 ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
                                 ->limit(5)->get(); 
        }
      }
      if($request->has('groups')){
        //get group based on its members (if group isn't private)--->not really FTS but it's interesting all the same so I'm gonna do it
        if($id==0){
          $groups = Grupo::whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
                            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
                            ->limit(5)->get(); 
        }
        else{
          $id_groups=grupoUtilizador::select('idgrupo')->where('idutilizador',$id)->get();
          $groups=Grupo::whereIn('id',$id_groups)->limit(5)->get();
        }
      }
    }


    if(is_null($request->username_search)){
      if($request->has('groups')){
        $groups = Grupo::whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 

        if($groups->isEmpty()){
          return view('layouts.error204');
        }
        else{
          if(Auth::guard('admin')->check()){
            return view('admin.view_search_results_admin',[ 
              'users'=>$users,
              'posts'=>$posts,
              'comments'=>$comments,
              'groups'=>$groups]);
          }
          else{
            return view('pages.view_search_results',[ 
              'users'=>$users,
              'posts'=>$posts,
              'comments'=>$comments,
              'groups'=>$groups]);
          }
        }
      }
      if($request->has('comments')){
        $comments = Comentario::where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 
        
        if($comments->isEmpty()){
          return view('layouts.error204');
        }
        else{
          if(Auth::guard('admin')->check()){
            return view('admin.view_search_results_admin',[ 
              'users'=>$users,
              'posts'=>$posts,
              'comments'=>$comments,
              'groups'=>$groups]);
          }
          else{
            return view('pages.view_search_results',[ 
              'users'=>$users,
              'posts'=>$posts,
              'comments'=>$comments,
              'groups'=>$groups]);
          }
        }
      }
      if($request->has('posts')){
        $posts = Publicacao::where('privacidade','public')->where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
          ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
          ->limit(5)->get(); 

      if($posts->isEmpty()){
        return view('layouts.error204');
      }
      else{
        if(Auth::guard('admin')->check()){
          return view('admin.view_search_results_admin',[ 
            'users'=>$users,
            'posts'=>$posts,
            'comments'=>$comments,
            'groups'=>$groups]);
        }
        else{
          return view('pages.view_search_results',[ 
            'users'=>$users,
            'posts'=>$posts,
            'comments'=>$comments,
            'groups'=>$groups]);
        }
      }
    }


    }
    

      if(!(!(is_null($request->username_search)) || $request->has('posts') || $request->has('comments') || $request->has('groups'))){
        //Users: (only one where it matters if it had " " or not)
      if(preg_match('/"/', $query)){ //exact search match
        $output=trim($query,'"');
        $users= User::where('nome',$output)->get();
        $groups= Grupo::where('nome',$output)->get();
      }
      else{ //full text search
        $users = User::whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 

        $groups = Grupo::whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 
      }
        //Posts
      $posts = Publicacao::where('privacidade','public')->where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
      ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
      ->limit(5)->get(); 

      //Comments
      $comments = Comentario::where('idutilizador','!=',NULL)->whereRaw('tsvectors @@ plainto_tsquery(\'portuguese\', ?)', [$query])
        ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$query])
        ->limit(5)->get(); 

      }

      if($users->isEmpty() && $posts->isEmpty() && $comments->isEmpty() && $groups->isEmpty()){
        return view('layouts.error204');
      }

      if(Auth::guard('admin')->check()){
        return view('admin.view_search_results_admin',[ 
          'users'=>$users,
          'posts'=>$posts,
          'comments'=>$comments,
          'groups'=>$groups]);
      }
      else{
        return view('pages.view_search_results',[ 
          'users'=>$users,
          'posts'=>$posts,
          'comments'=>$comments,
          'groups'=>$groups]);
      }
    }

}