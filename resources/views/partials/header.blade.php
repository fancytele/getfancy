<header>
    <nav id="fancy-navbar"
         class="border-0 bg-transparent fixed-top navbar navbar-dark navbar-expand-md">
        <div class="container">
            <a class="font-weight-bold navbar-brand py-3 text-uppercase"
               href="{{ url('/') }}">
                <img class="fancy-logo fancy-white-logo"
                     src="{{ URL::asset('img/logo-light.png') }}"
                     alt="Fancy Logo">
                <img class="fancy-logo fancy-dark-logo"
                     src="{{ URL::asset('img/logo-primary.png') }}"
                     alt="Fancy Logo">
            </a>
            <form method="POST" action="/locale" class="d-md-none ml-auto pr-3">
                @csrf
                <label class="sr-only" for="locale-sm">
                    Cambiar lenguaje </label>
                <select name="lang" id="locale-sm"
                        class="form-control form-control-sm locale"
                        class="form-control form-control-sm">
                    <option value="en">EN</option>
                    <option value="es" selected="" disabled="">ES</option>
                </select>
            </form>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#fancy-menu" aria-controls="fancy-menu"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse flex-column align-items-end"
                 id="fancy-menu">
                <form method="POST" action="/locale"
                      class="d-none d-md-block pr-3">
                    @csrf
                    <label class="sr-only" for="locale-md">
                        @lang('Change Language')
                    </label>
                    <select name="locale" id="locale-md"
                            class="form-control form-control-sm locale"
                            class="form-control form-control-sm">
                        <option value="en" @if (App::isLocale('en')) selected
                                disabled @endif>EN</option>
                        <option value="es" @if (App::isLocale('es')) selected
                                disabled @endif>ES</option>
                    </select>
                </form>
                @isset ($show_nav)

                <ul class="navbar-nav ml-auto text-uppercase">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">
                            @lang('Home') <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="#features">@lang('Features')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">
                            @lang('How It Works')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="#testimonial">@lang('Testimonial')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#plans">@lang('Our Plans')</a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>
</header>