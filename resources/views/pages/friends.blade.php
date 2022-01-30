@extends('layouts.app')

@section('content')
<div class="container m2-auto justify-content-center" style="min-height: 752px;">
    <div class="card-deck" style="margin-top: 7.5px;">
        @foreach($users as $user)
        <div class="card-user flexbox align-items-center" style="padding: 5px; width: 17.5%; margin-bottom: 15px; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 15px;" data-id="{{$user->id}}">
            <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                <img alt="Foto de Perfil" class="post-user" src="{{ asset($user->fotoperfil) }}">
            </a>
            <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">
                    {{ $user->nome }}
                </h1>
            </a>
            <a class="nav-link" href="#" style="vertical-align: middle; float: right; margin-top: -2px;">
                <i title="Desfazer Amizade" class="fa fa-frown-o"></i>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection