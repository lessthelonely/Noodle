<header id="header" class="header-yellow" style="width: auto;">
    <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search" id="navbar" style="width: auto;">
        <div class="container-fluid">
            <a id="feed-link" href="{{ route('for_you_feed') }}">
                <img alt="Logotipo do Noodle" id="logo" src="{{ asset('assets/img/logo.png')}} "></a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav"></ul>
            <form method="GET" action="{{route('search_aut')}}" class="d-flex me-auto navbar-form" target="_self" style="text-align: center;border-width: 10px;border-color: #0c1618;transform: translate(324px);">
                @csrf
                <div class="d-flex align-items-center" id="search-bar" style="align-self: center;">
                        <button type="submit" style="background: transparent; border-color: transparent;">

                            <i title="Pesquisar" class="fa fa-search fa fa-search" id="search-icon"></i>

                        </button>
                    <input class="form-control search-field" type="search" id="search-input" name="search">
                    @if ($errors->has('search'))
                    <span class="error">
                        {{ $errors->first('search') }}
                    </span>
                    @endif
                    <div class="dropdown" style="z-index: 1000;margin-right: 0px;margin-left: 5px;">
                        <a class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="color: #0c1618;"></a>
                        <div id="search-dropdown" class="dropdown-menu">
                            <p>
                                Utilizador
                                <input class="form-control" type="text" id="user-filter" name="username_search" placeholder="A pesquisa só será feita neste utilizador!">
                            </p>
                            <p style="margin-bottom: 0px;">
                                Tipo de Resultados
                            </p>
                            <p style="margin-bottom: 0px;">
                                <input type="checkbox" name="posts">
                                <label style="padding: 5px; color: #0c1618; margin-right: 57px;">Publicações</label>
                                <input type="checkbox" name="comments">
                                <label style="padding: 5px; color:#0c1618; margin-right: 50px;">Comentários</label>
                                <input type="checkbox" name="groups">
                                <label style="padding: 5px; color:#0c1618">Grupos</label>
                            </p>
                        </div>
                    </div>

                </div>
            </form>
            <div class="dropdown dropstart" id="user-btn" aria-expanded="false" style="margin-right: 15px;" role="menu">
                <a class="dropdown-toggle a" style="text-decoration: none;" aria-expanded="false" data-bs-toggle="dropdown" id="dropdown-link" href="#user-tab">
                    <img alt="Foto do Utilizador" id="user-pic" class="rounded-circle" src="{{ asset(App\Models\User::find(Auth::id())->fotoperfil)}} " style="margin-right: 0px;">
                    @if((Auth::user()->friendship_request->count() + Auth::user()->notifications->count() + Auth::user()->grouprequests()->count()) != 0)
                    <span id="not-badge-dropdown" class="position-absolute translate-middle bg-danger rounded-circle"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropleft-menu-start" id="user-tab" style="margin-right: 7.5px;">
                    <h6 class="dropdown-header" id="dh1">
                        <a href="{{route('show_notifications')}}" style="text-decoration: none; color: #0c1618;">
                            Notificações
                        </a>
                        <span id="badge" class="badge bg-warning text-dark">
                            {{Auth::user()->friendship_request->count() + Auth::user()->notifications->count() + Auth::user()->grouprequests()->count()}}
                        </span>
                    </h6>
                    <div class="toast-container" id="notifications">
                        @foreach(Auth::user()->notifications()->notSeen()->orderBy('datatempo', 'desc')->paginate(10) as $note)
                        @if(!is_null($note->idpublicacao) && is_null($note->idgosto) && !is_null(App\Models\Publicacao::find($note->idpublicacao)->idutilizador))
                        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
                            <div class="toast-header">
                            <a href="{{ route('show_profile', ['id' => App\Models\Publicacao::find($note->idpublicacao)->idutilizador]) }}" style="text-decoration: none;">
                                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Publicacao::find($note->idpublicacao)->idutilizador)->fotoperfil)}}"></a>
                                <strong class="me-auto">Nova Publicação</strong>
                                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Dar Vista" class="fa fa-check"></i>
                                </a>
                            </div>
                            <div class="toast-body" role="alert">
                                <p>Um colega teu, {{App\Models\User::find(App\Models\Publicacao::find($note->idpublicacao)->idutilizador)->nome}}, fez uma nova publicação!</p>
                            </div>
                        </div>
                        @endif


                        @if(!is_null($note->idcomentario) && is_null($note->idgosto) && !is_null(App\Models\Comentario::find($note->idcomentario)->idutilizador))
                        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
                            <div class="toast-header">
                            <a href="{{ route('show_profile', ['id' => App\Models\Comentario::find($note->idcomentario)->idutilizador]) }}" style="text-decoration: none;">
                                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Comentario::find($note->idcomentario)->idutilizador)->fotoperfil)}}"></a>
                                <strong class="me-auto">Novo Comentário</strong>
                                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Dar Vista" class="fa fa-check"></i>
                                </a>
                            </div>
                            <div class="toast-body" role="alert">
                                <p>{{App\Models\User::find(App\Models\Comentario::find($note->idcomentario)->idutilizador)->nome}} publicou um comentário na tua publicação.</p>
                            </div>
                        </div>
                        @endif


                        @if(!is_null($note->idgosto) && !is_null(App\Models\Gosto::find($note->idgosto)->idutilizador))
                        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$note->id}}">
                            <div class="toast-header">
                                <a href="{{ route('show_profile', ['id' => App\Models\Gosto::find($note->idgosto)->idutilizador]) }}" style="text-decoration: none;">
                                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{asset(App\Models\User::find(App\Models\Gosto::find($note->idgosto)->idutilizador)->fotoperfil)}}"></a>
                                <strong class="me-auto">Novo Gosto</strong>
                                <a class="notification-check" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Dar Vista" class="fa fa-check"></i>
                                </a>
                            </div>
                            <div class="toast-body" role="alert">
                                <p>{{App\Models\User::find(App\Models\Gosto::find($note->idgosto)->idutilizador)->nome}} gostou da sua publicação!</p>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @foreach(App\Models\User::find(Auth::id())->friendship_request as $friend)
                        <div class="toast fade notifications show frs" role="alert" style="width: 100%;" data-id="{{$friend->id}}">
                            <div class="toast-header">
                                <a href="{{ route('show_profile', ['id' => $friend->id]) }}" style="text-decoration: none;">
                                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{ asset($friend->fotoperfil) }}"> </a>
                                <strong class="me-auto">Novo Pedido de Amizade</strong>
                                <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Aceitar Pedido" class="fa fa-check-circle"></i>
                                </a>
                                <a class="request-check" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Rejeitar Pedido" class="fa fa-times-circle"></i>
                                </a>
                            </div>
                            <div class="toast-body" role="alert">
                                <p>{{$friend->nome}} quer ser teu colega. Desejas aceitar o pedido ou recusá-lo?</p>
                            </div>

                        </div>
                        @endforeach

                        @foreach(App\Models\User::find(Auth::id())->grouprequests as $g)
                        <div class="toast fade notifications show" role="alert" style="width: 100%;" data-id="{{$g->id}}">
                            <div class="toast-header">
                                <a href="{{ route('show_group', ['id' => $g->id]) }}" style="text-decoration: none;">
                                <img alt="Foto de Perfil" class="me-2" style="width: 30px;height: 30px;margin: 0px 8px 0px 0px;padding: 0px;border-radius: 15px;" src="{{ asset($g->fotoperfil) }}"> </a>
                                <strong class="me-auto">Novo Convite para Entrar num Grupo</strong>
                                <a class="mod-request" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Aceitar Convite" class="fa fa-check-circle"></i>
                                </a>
                                <a class="mod-request" href="#" style="vertical-align: middle; font-size: 24px;">
                                    <i title="Rejeitar Convite" class="fa fa-times-circle"></i>
                                </a>
                            </div>
                            <div class="toast-body" role="alert">
                                <p>{{$g->nome}} quer que se torne num membro. Desejas aceitar o pedido ou recusá-lo?</p>
                            </div>

                        </div>
                        @endforeach
                    </div>
                    <div class="dropdown-divider" id="dv1"></div>
                    <h6 class="dropdown-header" id="dv2">Navegação</h6>
                    <a class="dropdown-item" id="user-btn-1" href="{{ route('show_profile', ['id' => Auth::id()]) }}" data-user="{{Auth::id()}}">Perfil</a>
                    <a class="dropdown-item" id="user-btn-2" href="{{ route('config_view', ['id' => Auth::id()]) }}">Configurações</a>
                    <a class="dropdown-item" href="{{ route('for_you_feed') }}">Feed Personalizado</a>
                    <a class="dropdown-item" id="user-btn-3" href="{{ route('logout') }}">Terminar Sessão</a>
                </div>
            </div>
            <a id="trending-link" href="{{route('general_feed')}}">
                <i title="Tendências" class="fa fa-arrow-up bi bi-question nav-link" id="i1" style="font-size: 25px;"></i>
            </a>
            <a id="faq-link" href="{{ route('faq') }}">
                <i title="Perguntas Frequentes" class="fa fa-question bi bi-question nav-link" style="padding: 0px;margin-top: 0px;margin-right: 0px;"></i>
            </a>
            <a id="about-link" class="nav-link" href="{{ route('about-us') }}" style="margin-right: 10px;">
                <i title="Sobre Nós" class="fa fa-info bi bi-question"></i>
            </a>
        </div>
    </nav>
</header>