@extends('layouts.admin')

@section('content')
<div class="container m2-auto justify-content-center" style="margin-top: 7.5px; min-height: 752px;">
    
    <h1>
        Membros
    </h1>

    <div class="card-deck justify-content-center" style="margin-top: 7.5px; flex-direction: col;">
        <div class="card-user flexbox align-items-center" style="padding: 5px; width: 17.5%; margin-bottom: 15px; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 15px;" data-id="{{$group->moderador}}" data-group-id="{{$group->id}}">
            <a href="{{ route('show_profile', ['id' => $group->moderador]) }}" style="text-decoration: none;">
                <img alt="Foto de Perfil" class="post-user" src="{{ asset(App\Models\User::find($group->moderador)->fotoperfil) }}">
            </a>
            <a href="{{ route('show_profile', ['id' => $group->moderador]) }}" style="text-decoration: none;">
                <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">
                    {{ App\Models\User::find($group->moderador)->nome }}
                </h1>
            </a>
        </div>
        @foreach($users as $user)
        <div class="card-user flexbox align-items-center" style="padding: 5px; width: 17.5%; margin-bottom: 15px; display: inline-flex; flex-direction: column; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: 15px;" data-id="{{$user->id}}" data-group-id="{{$group->id}}">
            <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                <img alt="Foto de Perfil" class="post-user" src="{{ asset($user->fotoperfil) }}">
            </a>
            <a href="{{ route('show_profile', ['id' => $user->id]) }}" style="text-decoration: none;">
                <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">
                    {{ $user->nome }}
                </h1>
            </a>
            <a class="nav-link" href="#" style="vertical-align: middle; float: right; margin-top: -2px;">
                <i title="Apagar Membro" class="fa fa-user-times"></i>
            </a>
        </div>
        @endforeach
    </div>
</div>
</div>

@endsection