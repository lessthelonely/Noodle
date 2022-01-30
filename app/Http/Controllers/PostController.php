<?php

//https://stackoverflow.com/questions/59230488/how-to-redirect-in-laravel-form-on-post-request
//https://laraveldaily.com/all-about-redirects-in-laravel-5/

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Publicacao;
use App\Models\Notificacao;
use App\Models\Grupo;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller 
{
    
    
  /**
   * Creates a new post.
   *
   * @return Response
   */
  public function create(Request $request) 
  {
      if(!Auth::check()) return redirect('/login');
      if(Auth::user()->is_banned) return view('layouts.error403');
      $post=new Publicacao();
      $post->numerogostos=0;
      $post->numerocomentarios=0;
      $validated=$request->validate([
         'body'=>'max:255',
         'annex'=>'mimes:jpg,png,jpeg|max:5048'
      ]);

      $post->conteudo=$request['body'];
      if($request->hasFile('annex')){
        $newImageName = 'assets/img/' . time() . '-' . pathinfo($request['annex']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['annex']->extension();
        $request['annex']->move(public_path('/assets/img'),$newImageName);
        $post->anexo = $newImageName;
     }

      $post->idutilizador= Auth::id();
      $post->privacidade=User::find(Auth::id())->privacidade;
      
      $post->save();
      $post->member = Auth::user();

      $friends=User::find(Auth::id())->friends;
      
      foreach($friends as $user){
         $notification=new Notificacao();
         $notification->tipo='post';
         $notification->idutilizador=$user->id;
         $notification->idpublicacao=$post->id;
         $notification->idposter=Auth::id();
         $notification->idgosto=NULL;
         $notification->idcomentario=NULL;
         $notification->vista=false;
         $notification->save();
         }
      return back();
  } 
    
    public function updatePost($id){
     if(!Auth::check()) return redirect('/login');
     if(Auth::user()->is_banned) return view('layouts.error403');
       $post=Publicacao::find($id);
       if(is_null($post))
           return view('layouts.error204');
       return view('partials.edit_post',['post' => $post]);
    }
    
    public function editPost(Request $request, $id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $post=Publicacao::find($id);
        if(is_null($post))
           return view('layouts.error204');
        $validated=$request->validate([
            'body'=>'required|max:255'
        ]);
        if(!is_null($request['body'])){
           $post->conteudo=$request['body'];
        }
        
        $post->save();        
        
        return $post;
    }

    /**
     * Deletes a post from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id, Request $request) //followed Item and CardController
    {
        if(!(Auth::check() || Auth::guard('admin')->check())) return redirect('/login');
        if(!(Auth::guard('admin')->check())){
         if(Auth::user()->is_banned) return view('layouts.error403');
        }
        $post = Publicacao::find($id);
        if(is_null($post))
           return view('layouts.error204');
        $post->delete();

        return $post;
    } 

    
}