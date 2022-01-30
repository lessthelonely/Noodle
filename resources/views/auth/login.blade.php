@extends('layouts.app')

@section('content')
<section class="login-dark">
<form method="POST" action="{{ route('login') }}" id="user-login" style="background: #0c1618;width: 346px;padding: 20px;">
    {{ csrf_field() }}

    <h2 class="visually-hidden">Login Form</h2>
    <div class="illustration"><i title="Cadeado" class="icon ion-ios-locked-outline" style="border-color: #efc11a;color: #efc11a;"></i></div>
    <div class="mb-3"><input id="email" class="form-control login-input" type="email" name="email" placeholder="Email (obrigatório)"  value="{{ old('email') }}" required autofocus></div>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <div class="mb-3"><input id="password" class="form-control login-input" type="password" name="password" placeholder="Password (obrigatório)" required></div>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif
    <div class="mb-3">
        <button class="btn btn-primary d-block btn btn-primary" id="login-form-button" type="submit">
            Iniciar Sessão
        </button>
    </div>
    <a class="forgot" href="{{ route('forget_password_form') }}">Esqueceste-te da palavra-passe?</a>
    <a class="forgot" href="{{ route('admin.login') }}">Administração</a>
</form>
</section>
@endsection

