<div class="comments-results" data-id="{{$comment->id}}" data-post-id="{{$comment->idpublicacao}}">
    <header class="d-flex flex-row align-items-center" style="margin-bottom: 5px; margin-left: 5px; margin-top: 5px;">
        <a style="color: #0c1618; text-decoration: none" href="{{ route('show_profile', ['id' => $comment->idutilizador]) }}">
            <img alt="Foto de Perfil" class="post-user" src="{{asset(App\Models\User::find($comment->idutilizador)->fotoperfil)}}">
        </a>
        
        <a href="{{ route('show_profile', ['id' => $comment->idutilizador]) }}" style="text-decoration: none;">
            <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">
                {{App\Models\User::find($comment->idutilizador)->nome}}
            </h1>
        </a>
    </header>
        <p class="d-flex flex-row align-items-center" style="margin-top: 5px; margin-left: 5px; margin-right: 5px; margin-bottom: 5px;">{{ $conteudo }}</p>
        @if(Auth::check() || Auth::guard('admin')->check())
        <div class="footer">
        @if(!(Auth::guard('admin')->check()))
            <a href="#like" style="padding: 5px; text-decoration: none;">
                @if($comment->liked_by_auth_user)
                <i title="Gostado" class="fa fa-thumbs-up yellow"></i>
                @else
                <i title="Não Gosto" class="fa fa-thumbs-up black"></i>
                @endif
            </a>
            @if(Auth::id()==$idUtilizador)
            <a class="edit-com" href="#" style="padding: 5px; text-decoration: none">
                <i title="Editar Comentário" class="fa fa-pencil" style="margin-right: 15px;" data-bs-toggle="modal" data-bs-target="#edit-comment"></i>
            </a>
            @endif
            @endif

            @if(!(is_null(App\Models\Publicacao::find($comment->idpublicacao)->idgrupo)))
            @if(App\Models\Grupo::find(App\Models\Publicacao::find($comment->idpublicacao)->idgrupo)->moderador==Auth::id() && Auth::id() != $idUtilizador)
               <a class="delete-post" href="#" style="text-decoration: none;">
               <i title="Apagar Publicação" class="fa fa-trash"></i>
               </a>
            @endif
            @endif

            @if(Auth::id() == $idUtilizador || Auth::guard('admin')->check())
            <a class="delete-com" style="padding: 5px; text-decoration: none" href="#">
                <i title="Apagar Comentário" class="fa fa-trash" type="submit"></i>
            </a>
            @endif
            @endif
        </div>
</div>