@extends('layouts.app')

@section('content')

<div class="container" style="width: auto;margin-top: 5px;">
  <div class="row" id="r1" style="height: auto;">
    <div class="col col-md-1 offset-md-0 offset-xxl-0" id="sidebar" style="height: auto;min-width: 25%;width: 25%;padding: 0px;">
      <a href="{{ route('show_friends') }}">
        <button class="btn btn-primary btn" id="colegas" type="button">Os Meus Colegas</button>
      </a>
      <a href="{{route('create_group_view')}}">
        <button class="btn btn-primary btn" id="grupos" type="button">Criar Novo Grupo</button>
      </a>
      @foreach(Auth::user()->groupMem as $group)
      <a href="{{ route('show_group', ['id' => $group->id]) }}">
        <button class="btn btn-primary btn" id="grupo-1" type="button">{{$group->nome}}</button>
      </a>
      @endforeach
      @foreach(Auth::user()->groupMod as $group)
      <a href="{{ route('show_group', ['id' => $group->id]) }}">
        <button class="btn btn-primary btn" id="grupo-1" type="button">{{$group->nome}}</button>
      </a>
      @endforeach
      <a href="{{ route('show_notifications') }}">
        <button class="btn btn-primary btn" id="notificacoes" type="button">Notificações</button>
      </a>
    </div>
    <div class="col-xl-1 col-xxl-12 offset-xxl-0" style="height: inherit;margin-top: 0px;width: 74%;">
      @if(Auth::check())
      @include('partials.create_post_block')
      @endif
      <div class="post-scroll col">
        @foreach ($posts as $post)
        <div class="row" style="width: 100%; margin: 0px;">
          <div class="col">
            @include('partials.post', array(
            'id' => $post->id,
            'idUtilizador' => $post->idutilizador,
            'conteudo' => $post->conteudo,
            'anexo' => $post->anexo
            ))
          </div>
        </div>
      </div>


      @foreach($post->comments as $comment)
      @if(!(is_null($comment)))
      @if(!(is_null($comment->idutilizador)))
      <div class="row" style="width: 100%;">
        <div class="col">
          @include('partials.comment',array(
          'id'=>$comment->id,
          'idUtilizador'=>$comment->idutilizador,
          'conteudo'=>$comment->conteudo,
          'idpublicacao'=>$comment->idpublicacao
          ))
        </div>
      </div>

    </div>
    @endif
    @endif
    @endforeach
    @endforeach

  </div>
</div>

</div>
@include('partials.edit_post')
@include('partials.create_comment')
@include('partials.edit_comment')
@endsection