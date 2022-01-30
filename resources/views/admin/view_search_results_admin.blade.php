@extends('layouts.admin')

@section('content')
<div class="container" style="min-height: 752px; margin-top: 7.5px;">
    @if(!(is_null($users)))
    <h1 class="post-author" style="margin-left: 10px; margin-bottom: 5px;">
        Utilizadores Encontrados
    </h1>
    <div class="card-group">
        @foreach($users as $user)
        <div class="card-user" style="width: 100%; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 15px;">
            <div class="d-flex flex-row align-items-center" style="padding: 5px;">
                <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                    <img alt="Foto de Perfil" class="post-user" src="{{ asset($user->fotoperfil) }}">
                </a>
                <h1 class="post-author" style="vertical-align: middle; margin: 0px; margin-top: -2px;">
                    <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none; color: #0c1618;">
                        {{ $user->nome }}
                    </a>
                </h1>
            </div>
        </div>
        @endforeach
    </div>

    <br style="margin-top: 10px;">
    @endif

    @if(!(is_null($groups)))
    <h1 class="post-author" style="margin-left: 10px; margin-bottom: 5px;">
        Grupos Encontrados
    </h1>
    <div class="card-group">
        @foreach($groups as $group)
        <div class="card-user" style="width: 100%; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 15px;">
            <div class="d-flex flex-row align-items-center" style="padding: 5px;">
                <a href="{{ route('show_group', ['id' => $group->id]) }}" style="text-decoration: none;">
                    <img alt="Foto de Perfil" class="post-user" src="{{ asset($group->fotoperfil) }}">
                </a>
                <h1 class="post-author" style="vertical-align: middle; margin: 0px; margin-top: -2px;">
                <a href="{{ route('show_group', ['id' => $group->id]) }}" style="text-decoration: none; color: #0c1618;">
                        {{ $group->nome }}
                    </a>
                </h1>
            </div>
        </div>
        @endforeach
    </div>

    <br style="margin-top: 10px;">
    @endif

    @if(!(is_null($posts)))
    <h1 class="post-author" style="margin-left: 10px; margin-bottom: 5px;">
        Publicações Encontradas
    </h1>
    <div class="post_scroll">
        @foreach($posts as $post)
        @include('partials.post', array(
        'id' => $post->id,
        'idUtilizador' => $post->idutilizador,
        'conteudo' => $post->conteudo,
        'anexo' => $post->anexo
        ))
        @endforeach
    </div>


    <br style="margin-top: 10px;">
    @endif



    @if(!(is_null($comments)))

    <h1 class="post-author" style="margin-left: 10px; margin-bottom: 5px;">
        Comentários Encontrados
    </h1>
    <div class="post-scroll">
        @foreach($comments as $comment)
        @include('partials.comment_result',array(
        'id'=>$comment->id,
        'idUtilizador'=>$comment->idutilizador,
        'conteudo'=>$comment->conteudo,
        'idpublicacao'=>$comment->idpublicacao
        ))
        @endforeach
    </div>
    @endif


</div>
@endsection