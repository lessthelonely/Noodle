@extends('layouts.app')
@section('content')

<div class="container" style="margin-top: 7.5px; min-height: 700px;">


    <h1>Configurações</h1>

    <form method="POST" action="{{route('config_user', ['id'=>$user->id])}}" enctype="multipart/form-data" style="margin: 0px;margin-bottom: 10px;">
        @csrf
        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="name-input">
                Nome Completo
            </label>
            <input class="form-control" name="name" type="text" id="name-input" style="margin-bottom: 10px;" placeholder="{{$user->nome}}">
            @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="date-input" style="margin-bottom: 5px;">
                Data de Nascimento
            </label>
            <input class="form-control" name="birthdate" id="date-input" type="date">
            @if ($errors->has('birthdate'))
            <span class="error">
                {{ $errors->first('birthdate') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="department-input" style="margin-bottom: 5px;">
                Departamento
            </label>
            <input class="form-control" name="department" type="text" id="departament-input" placeholder="{{$departamento}}">
            @if ($errors->has('department'))
            <span class="error">
                {{ $errors->first('department') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="formation-input" style="margin-bottom: 5px;">
                Formação
            </label>
            <input class="form-control" name="formation" type="text" id="formation-input" placeholder="{{$formacao}}">
            @if ($errors->has('formation'))
            <span class="error">
                {{ $errors->first('formation') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label for="profile-photo-input" style="margin-bottom: 5px;">Foto de Perfil</label>
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