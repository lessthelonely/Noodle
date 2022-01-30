@extends('layouts.app')

@section('content')
<div class="container m2-auto justify-content-center" style="min-height: 800px;">
    <header>
        <h4>Convida utilizadores para se juntarem ao teu grupo!</h4>
        <a href="{{ route('show_group',['id'=>$group->id]) }}" style="text-decoration: none; margin-right: 10px;">
            <button class="btn btn-primary" id="save-btn" type="button" style="background: #efc11a;float: left;">Próximo</button>
        </a>
    </header>


    <div class="card-deck">

        <br>
        @foreach($users as $user)
        <div class="card-user" style="width: 15%; margin: 10px; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 0.25rem; width: 20%;" data-id="{{$user->id}}" data-group-id="{{$group->id}}">
            <div class="card-header" style="padding: 5px;margin-bottom: 1px;">
                <header class="d-flex flex-row align-items-center">
                    <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                        <img alt="Foto de Perfil" class="post-user" src="{{ asset($user->fotoperfil) }}"> </a>
                    <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                        <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">
                            <span>{{ $user->nome }}</span>
                        </h1>
                    </a>
                </header>
            </div>
            <p style="margin-left: 10px; margin-bottom: 3px;">
                <a class="mod-request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                    <i title="Enviar Pedido" class="fa fa-check-circle"></i>
                </a>
            </p>
        </div>
        @endforeach

    </div>

</div>

@endsection