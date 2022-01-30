@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 7.5px">
    <div class="toast-container" style="width: 100%; height: 752px;">
    
    @foreach($group->requests as $mem)
    <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id-user="{{$mem->id}}" data-id-group="{{$group->id}}">
        <div class="toast-header">
             <a href="{{ route('show_profile', ['id' => $mem->id]) }}" style="text-decoration: none;">
             <img alt="Foto de Perfil" class="me-2" src="{{asset($mem->fotoperfil)}}"></a>
            <strong class="me-auto">Novo Pedido de Junção ao teu Grupo</strong>
            <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Aceitar Pedido" class="fa fa-user-plus"></i>
            </a>
            <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                <i title="Rejeitar Pedido" class="fa fa-times"></i>
            </a>
        </div>
        <div class="toast-body" role="alert">
            <p>{{$mem->nome}} quer fazer parte do teu grupo. Desejas aceitar o pedido ou recusá-lo?</p>
        </div>

    </div>
    @endforeach
    </div>
</div>
@endsection