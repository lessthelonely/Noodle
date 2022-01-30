@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 7.5px">
    <div class="toast-container" style="width: 100%; min-height: 752px;">
        @foreach($notifications as $note)
        @if(!is_null($note->idpublicacao) && is_null($note->idgosto) && !is_null(App\Models\Publicacao::find($note->idpublicacao)->idutilizador))
        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
            <div class="toast-header">
                <a href="{{ route('show_profile', ['id' => App\Models\Publicacao::find($note->idpublicacao)->idutilizador]) }}" style="text-decoration: none;">
                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Publicacao::find($note->idpublicacao)->idutilizador)->fotoperfil)}}"></a>
                <strong class="me-auto">Nova Publicação</strong>
                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                    <i title="Dar Vista" class="fa fa-check"></i>
                </a>
            </div>
            <div class="toast-body" role="alert">
                <p>Um colega teu, {{App\Models\User::find(App\Models\Publicacao::find($note->idpublicacao)->idutilizador)->nome}}, fez uma nova publicação!</p>
            </div>
        </div>
        @endif


        @if(!is_null($note->idcomentario) && is_null($note->idgosto) && !is_null(App\Models\Comentario::find($note->idcomentario)->idutilizador))
        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
            <div class="toast-header">
            <a href="{{ route('show_profile', ['id' => App\Models\Comentario::find($note->idcomentario)->idutilizador]) }}" style="text-decoration: none;">
            <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Comentario::find($note->idcomentario)->idutilizador)->fotoperfil)}}"></a>
                <strong class="me-auto">Novo Comentário</strong>
                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                    <i title="Dar Vista" class="fa fa-check"></i>
                </a>
            </div>
            <div class="toast-body" role="alert">
                <p>{{App\Models\User::find(App\Models\Comentario::find($note->idcomentario)->idutilizador)->nome}} publicou um comentário na tua publicação.</p>
            </div>
        </div>
        @endif


        @if(!is_null($note->idgosto) && !is_null(App\Models\Gosto::find($note->idgosto)->idutilizador))
        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
            <div class="toast-header">
                <a href="{{ route('show_profile', ['id' => App\Models\Gosto::find($note->idgosto)->idutilizador]) }}" style="text-decoration: none;">
                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Gosto::find($note->idgosto)->idutilizador)->fotoperfil)}}"></a>
                <strong class="me-auto">Novo Gosto</strong>
                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                    <i title="Dar Vista" class="fa fa-check"></i>
                </a>
            </div>
            <div class="toast-body" role="alert">
                <p>{{App\Models\User::find(App\Models\Gosto::find($note->idgosto)->idutilizador)->nome}} gostou da sua publicação!</p>
            </div>
        </div>
        @endif
    @endforeach

    @foreach($friendship_request as $friend)
    <div class="toast fade notifications show frs" role="alert" style="width: 100%;" data-id="{{$friend->id}}">
        <div class="toast-header">
            <a href="{{ route('show_profile', ['id' => $friend->id]) }}" style="text-decoration: none;">
            <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{ asset($friend->fotoperfil) }}"> </a>
            <strong class="me-auto">Novo Pedido de Amizade</strong>
            <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Aceitar Pedido" class="fa fa-check-circle"></i>
            </a>
            <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Rejeitar Pedido" class="fa fa-times-circle"></i>
            </a>
        </div>
        <div class="toast-body" role="alert">
            <p>{{$friend->nome}} quer ser teu colega. Desejas aceitar o pedido ou recusá-lo?</p>
        </div>

    </div>
    @endforeach

    @foreach($group_request as $g)
    <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$g->id}}">
        <div class="toast-header">
            <a href="{{ route('show_group', ['id' => $g->id]) }}" style="text-decoration: none;">
            <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{ asset($g->fotoperfil) }}"> </a>
            <strong class="me-auto">Novo Convite para Entrar num Grupo</strong>
            <a class="mod-request" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Aceitar Convite" class="fa fa-check-circle"></i>
            </a>
            <a class="mod-request" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Rejeitar Convite" class="fa fa-times-circle"></i>
            </a>
        </div>
        <div class="toast-body" role="alert">
            <p>{{$g->nome}} quer que se torne num membro. Desejas aceitar o pedido ou recusá-lo?</p>
        </div>

    </div>
    @endforeach
    </div>
</div>
@endsection