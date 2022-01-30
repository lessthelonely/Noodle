@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 752px;">
  <form action="{{ route('forget_password') }}" method="POST" style="width: 100%;margin: 0px;margin-bottom: 10px;padding: 25px;height: 300px;">
    @csrf
    <header>
      <h1>Pedido de Recuperação de Password</h1>
    </header>
    <p style="text-align: justify;">
      Por favor, insira aqui o e-mail com que costuma Iniciar Sessão no Noodle.
      Caso uma conta com esse e-mail esteja presente na nossa base de dados, 
      receberá um e-mail que lhe permitirá recuperar a password.</p>
    <p style="margin-bottom: 10px;">
      E-mail (obrigatório)
      <input class="form-control" type="email" name="email" placeholder="Email" style="margin-bottom: 10px;">
      @if ($errors->has('email'))
      <span class="error">
        {{ $errors->first('email') }}
      </span>
      @endif
      <button id="email-request-btn" class="btn btn-primary" type="submit">Enviar Pedido</button>
    </p>
  </form>
</div>
@endsection
