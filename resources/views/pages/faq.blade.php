@extends('layouts.app')

@section('content')
<div class="container justify-content" style="margin-top: 7.5px; min-height: 600px;">
        <h4>Frequently Asked Questions</h4>
        <h6 class="text-muted mb-2">Perguntas Frequentes</h6>
        <p>
                <strong>O que é o Noodle?</strong><br>O <em>Noodle </em>é uma rede social
                desenhada especialmente para estudantes por estudantes - procura criar uma
                forma simples de se encontrar comunidade e de gerir a vida académica entre
                alunos e professores, para que a vida escolar não seja só trabalho.<br><br>
                <strong>Por estudantes? Mas vocês são crentes?</strong><br>Sim, diz-se que
                sim.<br><br><strong>Quem gere a rede social?</strong><br>Os criadores e
                alguns professores têm privilégios de administrador - contudo, estes não
                podem alterar ou usar dados pessoais teus! Tem apenas cuidado com o que
                publicas, porque isso pode ser apagado por má conduta e até podes acabar
                sancionado ou mesmo banido!<br><br><strong>Qual a diferença entre um grupo
                        de Lazer e um grupo de Trabalho?</strong><br>Os primeiros são para os
                utilizadores usarem com amigos, enquanto os últimos são para usares com
                colegas de trabalho. E esse podem não ser teus conhecidos, mas <em>hey</em>,
                &nbsp;com certeza podem vir a sê-lo!<br><br><strong>Não tenho mais perguntas.
                </strong><br>E nós não temos mais respostas.<br><br><strong>Porquê <em>Noodle
                        </em>?</strong><br>Porque se trocasses o <em>N </em>com um <em>M</em>, éramos
                processados. E porque é muito comum os estudantes universitários americanos
                alimentarem-se à base de <em>noodles </em>(é tipo Milaneza, mas chinesa, 'tás a ver?).
        </p>


        <a href="{{ route('login') }}">
                <i title="Início" class="fa fa-home" style="font-size: 25px;"></i>
        </a>


</div>
@endsection