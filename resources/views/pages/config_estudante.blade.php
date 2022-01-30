@extends('layouts.app')
@section('content')

<div class="container" style="margin-top: 7.5px; min-height: 700px;">

    <h1>Configurações</h1>

    <form method="POST" action="{{route('config_user', ['id'=>$user->id])}}" enctype="multipart/form-data" style="margin-bottom: 10px;">
        @csrf
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="name-input" style="margin-bottom: 5px;">Nome Completo</label>
            <input class="form-control" name="name" type="text" id="name-input" style="margin-bottom: 10px;" placeholder="{{$user->nome}}">
            @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="date-input" style="margin-bottom: 5px;">Data de Nascimento</label>
            <input class="form-control" name="birthdate" id="date-input" type="date">
            @if ($errors->has('birthdate'))
            <span class="error">
                {{ $errors->first('birthdate') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="course-input" style="margin-bottom: 5px;">Curso</label>
            <input class="form-control" type="text" name="course" id="course-input" placeholder="{{$curso}}">
            @if ($errors->has('course'))
            <span class="error">
                {{ $errors->first('course') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="year-range" style="margin-bottom: 3px;">Ano Corrente</label>
            <span>
                <input type="range" style="width: 100px;" name="year" class="form-range" id="year-range" default=$anoCorrente min=1 max=5 onchange="document.getElementById('year').innerHTML = this.value;">
                <output id="year" style="vertical-align: top;">{{$anoCorrente}}</output>
                @if ($errors->has('year'))
                <span class="error">
                    {{ $errors->first('year') }}
                </span>
                @endif
            </span>
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;">Foto de Perfil</label>
            <input class="form-control" name="profile-pic" type="file" id="profile-photo-input">
            @if ($errors->has('profile-pic'))
            <span class="error">
                {{ $errors->first('profile-pic') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="header-photo-input" style="margin-bottom: 5px;">Foto de Capa</label>
            <input class="form-control" name="header-pic" type="file" id="header-photo-input">
            @if ($errors->has('header-pic'))
            <span class="error">
                {{ $errors->first('header-pic') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="privacy" style="margin-bottom: 5px;">
                Privacidade
            </label>
            <br>
            <div id="privacy" class="btn-group" role="group">
                <input class="btn-check" type="radio" name="btnradio" id="btnradio1" value="public" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio1" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="O teu perfil e informações estarão visíveis para todos os utilizadores do Noodle!">Público</label>
                <input class="btn-check" type="radio" name="btnradio" id="btnradio2" value="private" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="O teu perfil e informações estarão visíveis apenas para os teus colegas do Noodle!">Privado</label>
            </div>
        </div>
        <button class="btn btn-primary" id="save-btn" type="submit" style="background: #efc11a;float: left;">Guardar</button>
    </form>
    <form method="post" action="{{route('delete_user', ['id'=>$user->id])}}">
        @csrf
        @method('delete')
        <button class="btn btn-primary" id="delete-btn" type="submit" style="background: var(--bs-red);float: right;">Apagar Conta</button>
    </form>

</div>

@endsection