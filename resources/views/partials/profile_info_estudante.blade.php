<div class="row justify-content-center justify-items-center" style="align-items: start; margin-top: 85px;">
    <div class="col-sm-3 col-md-6 col-lg-4 col-xl-3">
        <div style="background: #f7f0f5; box-shadow: 0px 0px 20px #0c1618; max-height: 355px;">
            <p style="margin-left: 0px; padding: 10px; margin-bottom: 0px; width: auto; height: inherit; max-height: inherit;">
                <strong>Nome Completo</strong><br>
                {{ $user->nome }}<br><br>
                <strong>Data de Nascimento</strong><br>
                {{ $user->datanascimento}}<br><br>
                <strong>Instituição de Ensino</strong><br>
                {{ $user->instituicaoensino }}<br><br>
                <strong>Curso</strong><br>
                {{$curso}}<br><br>
                <strong>Ano Corrente</strong><br>
                {{$anoCorrente}}<br>
            </p>
        </div>
    </div>
    <div class="col-sm-9 col-md-6 col-lg-8 col-xl-9">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col">
                @if(Auth::check() && Auth::id()==$user->id)
                <div class="row">
                    @include('partials.create_post_block')
                </div>
                @endif
                <div class="row">
                    <div class="post-scroll col" style="flex: auto;">
                        @foreach ($posts as $post)
                            <div class="row" style="width: 100%">
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
                            <div class="row" style="width:100%;">
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
@if(!(Auth::guard('admin')->check()))
@include('partials.create_comment')
@include('partials.edit_comment')
@include('partials.edit_post')
@endif
</div>