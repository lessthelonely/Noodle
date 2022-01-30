@extends('layouts.app')

@section('content')

<div class="min-vh-100, d-flex,flex-column,justify-content-between" style="height: auto;width: auto;display: flex;flex-direction: column;min-height: auto;">
    <div class="container" style="width: auto;display: flex;padding: 0px; min-height: 750px;">
        <div class="row" id="r1" style="width: auto;height: auto;">
            <div class="col" style="padding: 0px;width: auto;height: auto;">
                <div class="row" style="width: auto;height: auto;max-height: 450px;margin-bottom: 70px;">
                    <div class="col" style="width: auto;height: auto;max-height: 450px;padding: 0px;margin-bottom: 0px;">
                        <img alt="Foto de Capa" src="{{ asset($headerPic) }}" style="width: auto;height: auto;max-width: 100%;min-width: auto;max-height: 95%;">
                        <img alt="Foto de Perfil" id="profile-pic" class="profile-pic rounded-circle" src="{{ asset($profilePic) }}" style="width: 200px;height: 200px;" data-user="{{$user->id}}">
                        @if(Auth::id()!=$user->id && Auth::check())
                        <button class="btn btn-primary btn" id="add-friend" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-req="false">Adicionar Colega
                        </button>
                        @foreach ($colleagues as $friend)
                        @if($friend->id==Auth::id())
                        <button class="btn btn-primary btn" id="add-friend" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-req="true">Colega :)
                        </button>
                        @endif
                        @endforeach
                        @foreach($user->friendship_request as $f)
                        @if($f->id==Auth::id())
                        <button class="btn btn-primary btn" id="add-friend" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-req="true">Pedido Pendente
                        </button>
                        @endif
                        @endforeach
                        @endif

                        <h1 style="width: auto;position: relative;top: -200px;left: 265px;margin: 0px;margin-top: 0px;max-width: 45%;">
                            {{ $user->nome }}
                        </h1>
                    </div>
                </div>
                @if($user->privacidade=="private")
                @if(Auth::id()==$user->id || $user->friends->contains('id',Auth::id()))
                @include('partials.profile_info_estudante')
                @endif
                @else
                @include('partials.profile_info_estudante')

                @endif
                <script type="text/javascript" src={{ asset('js/profile.js') }} defer></script>
            </div>
        </div>
    </div>
</div>
@endsection