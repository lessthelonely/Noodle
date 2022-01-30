{{--https://www.codewall.co.uk/how-to-show-validation-errors-in-laravel-views/--}}
@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 7.5px;">
    <h4>Registo</h4>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="e-mail-input">
                Introduza um Email (obrigatório)
            </label>
            <input class="form-control login-input" type="email" id="e-mail-input" name="email" placeholder="Email">
            @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
            @endif
        </div>

        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="psw-input">
                Introduza uma Password (obrigatório)
            </label>
            <input class="form-control login-input" type="password" id="psw-input" name="password" placeholder="Password">
            @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
            @endif
        </div>

        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="psw-input-confirm">
                Repita a Password (obrigatório)
            </label>
            <input class="form-control login-input" type="password" id="psw-input-confirm" name="password_confirmation" placeholder="Confirmar Password">
        </div>

        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="name-input">
                Nome Próprio (obrigatório)
            </label>
            <input class="form-control" type="text" id="name-input" name="name" placeholder="Nome">
            @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="date-input">
                Data de Nascimento (obrigatório)
            </label>
            <input class="form-control" id="date-input" name="birthdate" type="date">
            @if ($errors->has('birthdate'))
            <span class="error">
                {{ $errors->first('birthdate') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">
            <label style="margin-bottom: 5px;" for="privacy">
                Privacidade (obrigatório)
            </label>
            <br>
            <div id="privacy" class="btn-group" role="group">

                <input class="btn-check" type="radio" name="btnradio" id="btnradio1" value="public" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio1" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="O teu perfil e informações estarão visíveis para todos os utilizadores do Noodle!">Público</label>
                <input class="btn-check" type="radio" name="btnradio" id="btnradio2" value="private" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="O teu perfil e informações estarão visíveis apenas para os teus colegas do Noodle!">Privado</label>
            </div>
            @if ($errors->has('btnradio'))
            <span class="error">
                {{ $errors->first('btnradio') }}
            </span>
            @endif
        </div>
        <div class="mb-3" style="margin-bottom: 15px;">

            <label style="margin-bottom: 5px;" for="profile-photo-input">
                Foto de Perfil (obrigatório)
            </label>
            <input class="form-control" type="file" name="profile-pic" id="profile-photo-input">
            @if ($errors->has('profile-pic'))
            <span class="error">
                {{ $errors->first('profile-pic') }}
            </span>
            @endif
        </div>
        <button class="btn btn-primary" id="reg-submit" type="submit">Registar</button>
    </form>

</div>


@endsection