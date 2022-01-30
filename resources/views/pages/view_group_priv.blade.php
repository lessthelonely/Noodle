@extends('layouts.app')

@section('content')

<div class="min-vh-100, d-flex,flex-column,justify-content-between" style="height: auto;width: auto;display: flex;flex-direction: column;min-height: auto;">
    <div class="container" style="width: auto;display: flex;padding: 0px;height: auto;">
        <div class="row" id="r1" style="width: auto;height: auto;">
            <div class="col-xxl-12" style="padding: 0px;width: auto;height: auto;">
                <div class="row" style="width: auto;height: auto;max-height: 450px;margin-bottom: 70px;">
                    <div class="col" style="width: auto;height: auto;max-height: 450px;padding: 0px;margin-bottom: 0px;">
                        <img alt="Foto de Capa" src="{{ asset($group->fotoheader) }}" style="width: auto;height: auto;max-width: 100%;min-width: auto;max-height: 95%;">
                        <img alt="Foto de Perfil" class="profile-pic rounded-circle" src="{{ asset($group->fotoperfil) }}" style="width: 200px;height: 200px;">
                        @if(Auth::check())
                        <button class="btn btn-primary btn" id="group-member" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="true" data-id-group="{{$group->id}}"> Pedir para se juntar a este grupo
                        </button>
                        @endif
                        @foreach ($group->requests as $waiting)
                        @if($waiting->id==Auth::id())
                        <button class="btn btn-primary btn" id="group-member" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="false">À espera de resposta ao seu pedido
                        </button>
                        @endif
                        @endforeach
                        <h1 style="width: auto;position: relative;top: -200px;left: 265px;margin: 0px;margin-top: 0px;max-width: 45%;">
                            {{ $group->nome }}
                        </h1>

                    </div>
                </div>

                <div class="row" style="margin-right: 0px;margin-left: 0px;display: flex;flex-direction: row;height: auto;flex-wrap: nowrap;width: auto;margin-top: 0px;margin-bottom: 15px;">
                    <div class="col-xxl-1" style="max-width: inherit;width: 25%;padding: 0px;padding-right: 0px;height: auto;max-height: 355px;margin-right: 7.5px;">
                        <div style="background: #f7f0f5; box-shadow: 0px 0px 20px #0c1618; max-height: 355px; margin-bottom: 15px;">
                            <p style="margin-left: 0px;padding: 10px;margin-bottom: 0px;width: auto;height: inherit;max-height: inherit;">
                                <strong>Tipo de Grupo</strong><br>
                                @if($group->tipo=='work')
                                Grupo de Trabalho<br><br>
                                @else
                                Grupo de Lazer<br><br>
                                @endif
                                <strong>Breve Descrição</strong><br>
                                {{ $group->descricao }}<br><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection