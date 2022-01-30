<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;

use App\Models\Publicacao;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Notificacao;

class CommentController extends Controller
{
  /**
   * Creates a new comment.
   *
   * @return Response
   */
  public function create(Request $request, $id_post)
  {
    if (!Auth::check()) return redirect('/login');
    if(Auth::user()->is_banned) return view('layouts.error403');
    $comment = new Comentario();
    $comment->idutilizador = Auth::id();
    $comment->idpublicacao = $id_post;
    $validated=$request->validate([
      'content'=>'required|max:255'
    ]);
    $comment->conteudo = $request['content'];

    $post = Publicacao::find($id_post);
    if (is_null($post))
      return view('layouts.error204');
    $post->comments()->save($comment);
    $post->refresh();

    $comment->save();
    $comment->member = Auth::user();

    $notification=new Notificacao();
    $notification->tipo='comment';
    $notification->idutilizador=$post->idutilizador;
    $notification->idpublicacao=NULL;
    $notification->idposter=Auth::id();
    $notification->idgosto=NULL;
    $notification->idcomentario=$comment->id;
    $notification->vista=false;
    $notification->save();


    return $comment;
  }

  public function updateComment($id)
  {
    if (!Auth::check()) return redirect('/login');
    if(Auth::user()->is_banned) return view('layouts.error403');
    $comment = Comentario::find($id);
    if (is_null($comment))
      return view('layouts.error204');
    return view('partials.edit_comment', ['comment' => $comment]);
  }

  public function editComment(Request $request, $id)
  {
    if (!Auth::check()) return redirect('/login');
    if(Auth::user()->is_banned) return view('layouts.error403');
    $comment = Comentario::find($id);
    if (is_null($comment))
      return view('layouts.error204');
    $validated=$request->validate([
        'comment'=>'required|max:255'
    ]);
    if (!is_null($request['comment'])) {
      $comment->conteudo = $request['comment'];
    }

    $comment->save();

    return $comment;
  }

  /**
   * Deletes comment.
   *
   * @param  int  $id
   * @return Response
   */
  public function delete(Request $request, $id)
  {
    if(!(Auth::check() || Auth::guard('admin')->check())) return redirect('/login');
    if(!(Auth::guard('admin')->check())){
     if(Auth::user()->is_banned) return view('layouts.error403');
    }
    $comment = Comentario::find($id);
    if (is_null($comment))
      return view('layouts.error204');
    $comment->delete();

    return $comment;
  }
}
