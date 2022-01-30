<header id="header" class="header-yellow" style="background: #0c1618;width: auto;">
    <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search" id="navbar" style="width: auto; z-index:999;">
        <div class="container-fluid">
            <a id="home-link" href="{{ route('admin.admin_view_users') }}">
                <img alt="Logotipo do Noodle" id="logo" src="{{ asset('assets/img/yellow_logo.png')}} ">
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav"></ul>
            <form method="GET" action="{{route('search_aut')}}" class="d-flex me-auto navbar-form" target="_self" style="text-align: center;border-width: 10px;border-color: #0c1618;transform: translate(324px);">
                @csrf
                <div class="d-flex align-items-center" id="search-bar" style="align-self: center;">
                        <button type="submit" style="background: transparent; border-color: transparent;">

                            <i title="Pesquisar" class="fa fa-search" id="search-icon-admin"></i>

                        </button>
                    <input class="form-control search-field" type="search" id="search-input" name="search">
                    @if ($errors->has('search'))
                    <span class="error">
                        {{ $errors->first('search') }}
                    </span>
                    @endif
                    <div class="dropdown" style="z-index: 1000; margin-right: 0px;margin-left: 5px;">
                        <a class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="color: #0c1618;"></a>
                        <div id="search-dropdown" class="dropdown-menu">
                            <p>
                                Autores da Publicação
                                <input class="form-control" type="text" id="user-filter" name="username_search" placeholder="A pesquisa só será feita neste utilizador!">
                            </p>
                            <p style="margin-bottom: 0px;">
                                Tipo de Resultados
                            </p>
                            <p style="margin-bottom: 0px;">
                                <input type="checkbox" name="posts">
                                <label style="padding: 5px; color: #0c1618; margin-right: 57px;">Publicações</label>
                                <input type="checkbox" name="comments">
                                <label style="padding: 5px; color:#0c1618; margin-right: 57px;">Comentários</label>
                                <input type="checkbox" name="groups">
                                <label style="padding: 5px; color:#0c1618">Grupos</label>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
            <a id="trending-link" href="{{route('general_feed')}}">
                <i title="Tendências" class="fa fa-arrow-up bi bi-question nav-link" id="i3" style="font-size: 25px;"></i>
            </a>
            <a id="faq-link-admin" href="{{ route('faq') }}">
                <i title="Perguntas Frequentes" class="fa fa-question bi bi-question nav-link" id="i4"></i>
            </a>
            <a id="about-link-admin" class="nav-link" href="{{ route('about-us') }}">
                <i title="Sobre Nós" class="fa fa-info bi bi-question" id="i5"></i>
            </a>
            @if(Auth::guard('admin')->check())
            <a href="{{ route('admin.logout') }}" style="margin-right: 10px;">
                <button class="btn btn-primary register" id="home-admin-register" type="button" style="min-width: auto;width: auto;padding: 10px;">Logout</button>
            </a>
            @endif
        </div>
    </nav>
</header>