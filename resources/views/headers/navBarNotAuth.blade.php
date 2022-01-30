<header id="header" class="header-yellow" style="width: auto;">
    <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
        <a id="home-link" href="{{ route('login') }}">
            <img alt="Logotipo do Noodle" id="logo" src="{{ asset('assets/img/logo.png')}} "></a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav"></ul>
        <form method="GET" action="{{route('search_vis')}}" class="d-flex me-auto navbar-form" target="_self" style="text-align: center;border-width: 10px;border-color: #0c1618;transform: translate(324px);">
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
            </div>
        </form>
        <a id="trending-link" href="{{route('general_feed')}}" style="text-decoration: none;">
            <i title="Tendências" class="fa fa-arrow-up bi bi-question nav-link" id="i1" style="font-size: 25px;"></i>
        </a>
        <a id="faq-link-1" href="{{ route('faq') }}" style="text-decoration: none;">
            <i title="Perguntas Frequentes" class="fa fa-question bi bi-question nav-link" id="i2"></i>
        </a>
        <a id="about-link" class="nav-link" href="{{ route('about-us') }}" style="text-decoration: none;">
            <i title="Sobre Nós" class="fa fa-info bi bi-question" id="i-3"></i>
        </a>
        <a href="{{ route('register') }}" style="text-decoration: none; margin-right: 10px;">
            <button class="btn btn-primary register" id="home-register" type="button" style="min-width: auto; width: auto; padding: 10px;">Registar</button>
        </a>
    </nav>
</header>