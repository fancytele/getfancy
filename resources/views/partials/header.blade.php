<header>
    <nav id="fancy-navbar"
         class="bg-transparent border-0 fixed-top navbar navbar-dark navbar-expand-md pt-4">
        <div class="align-items-end container d-flex">
            <a href="{{ url('/') }}">
                {{-- TODO: Change to SVG --}}
                <img class="fancy-logo"
                     src="{{ URL::asset('img/logo-primary.png') }}"
                     alt="Fancy Logo">
            </a>
            @isset ($show_nav)
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#fancy-menu" aria-controls="fancy-menu"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="font-weight-bold la la-2x la-bars text-primary"></i>
            </button>
            @endif
            <div class="collapse navbar-collapse flex-column align-items-end"
                 id="fancy-menu">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-md-flex d-none mb-4 small">
                    @if(App::isLocale('en'))
                    <span class="text-muted">English</span>
                    @else
                    <a href="{{ route('web.locale', 'en') }}" class="text-body">
                        English
                    </a>
                    @endif
                    <span class="px-3">|</span>
                    @if(App::isLocale('es'))
                    <span class="text-muted">Español</span>
                    @else
                    <a href="{{ route('web.locale', 'es') }}" class="text-body">
                        Español
                    </a>
                    @endif
                </div>
                @isset ($show_nav)
                <ul
                    class="align-items-center d-flex ml-auto navbar-nav text-lowercase">
                    <li class="nav-item">
                        <a class="font-weight-bold nav-link text-body"
                           href="#features">
                            @lang('Features')
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="font-weight-bold nav-link text-body"
                           href="#how-it-works">
                            @lang('How It Works')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="font-weight-bold nav-link text-body"
                           href="#plans">@lang('Our Plans')</a>
                    </li>
                    <li class="nav-item">
                        <a class="font-weight-bold nav-link text-body"
                           href="#testimonial">@lang('Testimonial')</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a href="{{ route('admin.login') }}"
                           class="btn btn-primary btn-sm px-4 py-2 text-capitalize">
                            @lang('Login')
                        </a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="btn btn-primary btn-sm px-3 py-2 text-capitalize">
                            @lang('Dashboard')
                        </a>
                    </li>
                    @endauth
                </ul>
                @endif
            </div>
        </div>
    </nav>
</header>