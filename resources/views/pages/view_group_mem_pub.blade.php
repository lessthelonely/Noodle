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
                        
                        @foreach ($group->requests as $waiting)
                        @if($waiting->id==Auth::id())
                        <button class="btn btn-primary btn" id="group-member" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="false">À espera de resposta ao seu pedido
                        </button>
                        @endif
                        @endforeach
                        @foreach(App\Models\User::find(Auth::id())->grouprequests as $answer)
                        @if($answer->id==$group->id)
                        <button class="btn btn-primary btn" id="group-member" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="false"> Veja as suas Notificações
                        </button>
                        @endif
                        @endforeach
                        @if($group->moderador==Auth::id())
                        <button class="btn btn-primary btn" id="group-member" type="button" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="false">Moderador :)
                        </button>
                        @endif
                        @foreach ($group->members as $member)
                        @if($member->id==Auth::id())
                        <form method="post" action="{{route('leave_group', ['id'=>$group->id])}}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-primary btn" id="group-member" type="submit" style="padding: 0px;margin: 0px;position: absolute;top: 465px;left: 70%;" data-can-join="false"> Membro :)
                            </button>
                        </form>
                        @endif
                        @endforeach
                        @endif
                        
                        <h1 style="width: auto;position: relative;top: -200px;left: 265px;margin: 0px;margin-top: 0px;max-width: 45%;"> {{ $group->nome }} </h1>
                        <a href="{{ route('show_group_members', ['id' => $group->id]) }}" style="text-decoration: none;">
                            <h1 id="add-colleague" style="margin-top: 0px;margin-bottom: 0px;width: auto;max-width: 170px;min-width: auto;text-decoration: none;">Ver Membros</h1>
                        </a>

                    </div>
                </div>

                <div class="row" style="margin-right: 0px;margin-left: 0px;display: flex;flex-direction: row; height: auto; flex-wrap: nowrap; width: auto; margin-bottom: 15px; margin-top: 85px;">
                    <div class="col-xxl-1" style="max-width: inherit;width: 25%;padding: 0px;padding-right: 0px;height: auto;max-height: 355px;margin-right: 7.5px; align-items: start;">
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
                    <div class="col-xl-1 col-xxl-12 offset-xxl-0" style="margin: 0px;margin-left: 7.5px;height: inherit;margin-top: 0px;width: 74%;padding: 0px;max-width: inherit;min-width: auto;max-height: inherit;">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col">

                            @foreach ($group->members as $member)
                            @if($member->id==Auth::id())
                                <div class="row">
                                    @include('partials.create_post_block_group',array(
                                    'id_group'=>$group->id
                                    ))
                                </div>
                            @endif
                            @endforeach

                            @if($group->moderador==Auth::id())
                            <div class="row">
                                    @include('partials.create_post_block_group',array(
                                    'id_group'=>$group->id
                                    ))
                                </div>
                            @endif

                                <div class="row">
                                    <div class="post-scroll col" style="flex: auto;">
                                        @foreach ($posts as $post)
                                        <div class="row" style="width: 100%; margin: 0px;">
                                            <div class="col">
                                                @include('partials.post', array(
                                                'id' => $post->id,
                                                'idUtilizador' => $post->idutilizador,
                                                'conteudo' => $post->conteudo,
                                                'anexo' => $post->anexo
                                                ))
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($post->comments as $comment)
                                    @if(!is_null($comment->idutilizador))
                                    <div class="row" style="width: 100%">
                                        <div class="col">
                                            @include('partials.comment',array(
                                            'id'=>$comment->id,
                                            'idUtilizador'=>$comment->idutilizador,
                                            'conteudo'=>$comment->conteudo,
                                            'idpublicacao'=>$comment->idpublicacao
                                            ))
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach

                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @include('partials.create_comment')
            @include('partials.edit_post')
            @include('partials.edit_comment')
        </div>
    </div>
</div>
</div>
@endsection