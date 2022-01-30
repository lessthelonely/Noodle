@extends('layouts.admin')

@section('content')
<div class="container m2-auto justify-content-center">
    <div class="card-deck">
        @foreach($users as $user)
        <div class="card-user" style="width: 15%; margin: 10px; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 0.25rem; width: 20%;" data-id="{{$user->id}}">
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
                <a class="admin-links" href="#" style="margin-right: 15px; text-decoration: none;">
                    <i title="Apagar" class="fa fa-trash"></i></a>
                @if($user->is_banned)
                <a class="admin-links2" href="#" style="margin-right: 15px; text-decoration: none;">
                    <i title="Desbloquear" class="fa fa-ban"></i>
                </a>
                @else
                <a class="admin-links" href="#" style="margin-right: 15px; text-decoration: none;">
                    <i title="Bloquear" class="fa fa-ban"></i>
                </a>
                @endif
            </p>
        </div>
        @endforeach
    </div>

</div>
@endsection