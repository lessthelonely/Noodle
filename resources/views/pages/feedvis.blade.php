@extends('layouts.app')


@section('content')
<div class="container" style="margin-top: 7.5px;">
        <div class="post-scroll col">
                @foreach ($posts as $post)
                <div class="row" style="width: 100%; margin: 0px;">
                        <div class="col">
                                @include('partials.post', array(
                                'id' => $post->id,
                                'idUtilizador' => $post->idutilizador,
                                'conteudo' => $post->conteudo,
                                'anexo' => $post->anexo)
                                )
                        </div>
                </div></div>

                @foreach($comments as $comment)
                @if($post->id==$comment->idpublicacao && !is_null($comment->idutilizador))
                <div class="row" style="width: 100%;">
                        <div class="col">
                                @include('partials.comment',array(
                                'id'=>$comment->id,
                                'idUtilizador'=>$comment->idutilizador,
                                'conteudo'=>$comment->conteudo,
                                'idpublicacao'=>$comment->idpublicacao)
                                )
                        </div>
                </div></div>
                @endif
                @endforeach
                @endforeach
                @include('partials.edit_post')
                @include('partials.create_comment')
                @include('partials.edit_comment')
        </div>
</div>
@endsection