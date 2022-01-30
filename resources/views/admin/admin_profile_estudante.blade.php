@extends('layouts.admin')

@section('content')

<div class="min-vh-100, d-flex,flex-column,justify-content-between" style="height: auto;width: auto;display: flex;flex-direction: column;min-height: auto;">
    <div class="container" style="width: auto;display: flex;padding: 0px; min-height: 750px;">
        <div class="row" id="r1" style="width: auto;height: auto;">
            <div class="col" style="padding: 0px;width: auto;height: auto;">
                <div class="row" style="width: auto;height: auto;max-height: 450px;margin-bottom: 70px;">
                    <div class="col" style="width: auto;height: auto;max-height: 450px;padding: 0px;margin-bottom: 0px;">
                        <img alt="Foto de Capa" src="{{ asset($headerPic) }}" style="width: auto;height: auto;max-width: 100%;min-width: auto;max-height: 95%;">
                        <img alt="Foto de Perfil" class="profile-pic rounded-circle" src="{{ asset($profilePic) }}" style="width: 200px;height: 200px;">

                        <h1 style="width: auto;position: relative;top: -200px;left: 265px;margin: 0px;margin-top: 0px;max-width: 45%;">
                            {{ $user->nome }}
                        </h1>
                    </div>
                </div>

                @include('partials.profile_info_estudante')

            </div>
        </div>
    </div>
</div>
@endsection