@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 7.5px;">

    <h1>Criar Grupo</h1>

    <form method="POST" action="{{route('create_group')}}" enctype="multipart/form-data" style="margin-bottom: 10px;">
        @csrf
        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">Nome do Grupo (obrigatório)</p>
            <input class="form-control" name="name" type="text" id="name-input" style="margin-bottom: 10px;" placeholder="Nome">
            @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">Descrição (obrigatório)</p>
            <input class="form-control" name="description" type="text" id="description-input" placeholder="Breve Descrição">
            @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">Foto de Perfil (obrigatório)</p>
            <input class="form-control" name="profile-pic" type="file" id="profile-photo-input">
            @if ($errors->has('profile-pic'))
            <span class="error">
                {{ $errors->first('profile-pic') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">Foto de Capa (obrigatório)</p>
            <input class="form-control" name="header-pic" type="file" id="header-photo-input">
            @if ($errors->has('header-pic'))
            <span class="error">
                {{ $errors->first('header-pic') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">
                Privacidade (obrigatório)
            </p>
            <div id="privacy" class="btn-group" role="group">
                <input class="btn-check" type="radio" name="btnradio" id="btnradio1" value="public" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="O grupo será visível a todos os utilizadores do Noodle!">Público</label>
                <input class="btn-check" type="radio" name="btnradio" id="btnradio2" value="private" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nenhum conteúdo do grupo será visível a utilizadores que não integrem o grupo.">Privado</label>
            </div>
        </div>

        <div class="mb-3" style="margin-bottom: 15px;">
            <p style="margin-bottom: 5px;">Tipo de Grupo (obrigatório)</p>
            <div id="type" class="btn-group" role="group">
                <input type="radio" class="btn-check btn-secondary" name="btnradio1" value="work" id="btnradio5" autocomplete="on">
                <label class="btn btn-outline-primary" for="btnradio5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Não há tempo para brincadeiras! Este tipo de grupos é para trabalhar em projetos!">Trabalho</label>

                <input type="radio" class="btn-check btn-secondary" name="btnradio1" value="lazer" id="btnradio6" autocomplete="on">
                <label class="btn btn-outline-primary" for="btnradio6" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Grupos para que não te esqueças de te divertires com amigos... ou de chorar com eles, quem sabe?">Lazer</label>

            </div>
        </div>
        <button class="btn btn-primary" id="reg-submit" type="submit">Criar Grupo</button>
    </form>

    @endsection