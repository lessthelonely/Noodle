@extends('layouts.admin')

@section('content')
<div class="container justify-content" style="margin-top: 7.5px; min-height: 600px;">
        <h4>Sobre Nós</h4>
        <p>
                Somos uma equipa dedicada com uma enorme vontade em dar-te a melhor experiência
                possível na tua passagem pelo ensino superior! Sente-te à vontade para nos
                contactares e dares sugestões ou <em>feedback</em> sobre o <em>Noodle</em> com o
                nosso contacto totalmente legítimo: <em>porfavornaonosmandesemails@gmail.com</em>.
                <br><br><em>Oh...</em>&nbsp; Espera, era suposto falarmos sobre nós, aqui?
                Ah, OK, mas vamos fazê-lo com perguntas!<br><br><strong>Como se chamam?</strong><br>
                Pelo nome.<br><br><strong>De onde são?</strong><br>Planeta Terra. Que já agora é plano,
                senão seria um&nbsp;<em>redondeta</em>. Coincidência? Achamos que não.<br><br><strong>
                        OK, OK, então onde vivem?</strong><br>Em nossa casa.<br><br><strong>OK, e onde
                        ficam as vossas casas?</strong><br>Já dissemos.<br><br><strong>Podem dar-me mais
                        alguma informação?</strong><br>A viagem à Lua é uma farsa.<br>
        </p>
        <a href="{{ route('admin.login') }}">
                <i title="Início" class="fa fa-home" style="font-size: 25px;"></i>
        </a>

</div>
@endsection