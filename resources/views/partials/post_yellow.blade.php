    <div class="d-flex justify-content-between p-2 px-3 posts" data-id="{{$post->id}}">
        @if(Auth::id()!=$idUtilizador)
        <header class="d-flex flex-row align-items-center" style="margin-bottom: 10px;"><a style="color: #0c1618; text-decoration: none" href="{{ route('show_profile', ['id' => $idUtilizador]) }}">
        <img alt="Foto de Perfil" class="post-user" src="{{asset(App\Models\User::find($idUtilizador)->fotoperfil)}}"></a>
        @elseif(Auth::guard('admin')->check())
        <header class="d-flex flex-row align-items-center" style="margin-bottom: 10px;"><a style="color: #0c1618; text-decoration: none" href="{{ route('admin_show_profile', ['id' => $idUtilizador]) }}">
        <img alt="Foto de Perfil" class="post-user" src="{{asset(App\Models\User::find($idUtilizador)->fotoperfil)}}"></a>
            @else
            <header class="d-flex flex-row align-items-center" style="margin-bottom: 10px;">
            <img alt="Foto de Perfil" class="post-user" src="{{asset(App\Models\User::find($idUtilizador)->fotoperfil)}}">
                @endif
                @if(Auth::id()!=$idUtilizador)
                <a href="{{ route('show_profile', ['id' => $idUtilizador]) }}" style="text-decoration: none;">
                    <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;"> {{App\Models\User::find($idUtilizador)->nome}}</h1>
                </a>
                </header>
            @elseif(Auth::guard('admin')->check())
            <header class="d-flex flex-row align-items-center" style="margin-bottom: 10px;"><a style="color: #0c1618; text-decoration: none" href="{{ route('admin_show_profile', ['id' => $idUtilizador]) }}">
            <img alt="Foto de Perfil" class="post-user" src="{{asset(App\Models\User::find($idUtilizador)->fotoperfil)}}"></a>
            @else
            <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px;"> {{App\Models\User::find($idUtilizador)->nome}}</h1>
        </header>
        @endif
        @if(!is_null($anexo))
        <img alt="Foto de Perfil" class="img-fluid" src="{{ asset($anexo) }}">
        @endif
        <p class="p-1 px-0">{{ $conteudo }}</p>
        @if(Auth::check() || Auth::guard('admin')->check())
        <footer>
        @if(!(Auth::guard('admin')->check()))
        <a href="#like" style="text-decoration: none;">
            @if($post->liked_by_auth_user)
            <i title="Gostado" class="fa fa-thumbs-up yellow"></i>
            @else
            <i title="Não Gosto" class="fa fa-thumbs-up black"></i>
            @endif
        </a>
            <a href="#" class="new-com" style="text-decoration: none;">
                <i title="Novo Comentário" class="fa fa-comment" style="margin-right: 15px;" data-bs-target="#create-comment" data-bs-toggle="modal"></i>
            </a>

            @if(Auth::id()==$idUtilizador)
            <a href="#" style="text-decoration: none;">
                <i title="Editar Publicação" class="fa fa-pencil" style="margin-right: 15px;" data-bs-target="#edit-post" data-bs-toggle="modal"></i>
            </a>
            @endif
            @endif
            
            @if(!(is_null($post->idgrupo)))
        @if(App\Models\Grupo::find($post->idgrupo)->moderador==Auth::id() && Auth::id() != $idUtilizador)
        <a class="delete-post" href="#" style="text-decoration: none;">
            <i title="Apagar Publicação" class="fa fa-trash"></i>
        </a>
        @endif
        @endif

            @if(Auth::id() == $idUtilizador || Auth::guard('admin')->check())
            <a class="delete-post" href="#" style="text-decoration: none;">
                <i title="Apagar Publicação" class="fa fa-trash"></i>
            </a>

            @endif
        </footer>
        @endif
    </div>