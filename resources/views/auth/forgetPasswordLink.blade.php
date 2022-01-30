@extends('layouts.app')

@section('content')
<section class="login-dark">
<form method="POST" action="{{ route('reset_password') }}" id="user-login" style="background: #0c1618;width: 346px;padding: 20px;">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">

    <h2 class="visually-hidden">New Password Form</h2>
    <div class="illustration"><i title="Cadeado" class="icon ion-ios-locked-outline" style="border-color: #efc11a;color: #efc11a;"></i></div>
    <div class="mb-3"><input id="email" class="form-control login-input" type="email" name="email" placeholder="Email (obrigatório)"  required autofocus></div>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <div class="mb-3">
        <input id="password" class="form-control login-input" type="password" name="password" placeholder="Password (obrigatório)" required></div>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif
    <div class="mb-3"><input class="form-control login-input" type="password" id="psw-input-confirm" name="password_confirmation" placeholder="Confirmar Password (obrigatório)"></div>
    <div class="mb-3">
        <button class="btn btn-primary d-block btn btn-primary" id="login-form-button" type="submit">
            Confirmar Nova Password
        </button></div>
</form>
</section>
@endsection
