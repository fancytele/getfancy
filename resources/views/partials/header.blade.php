<header>
    <nav
        id="fancy-navbar"
        class="border-0 bg-transparent fixed-top navbar navbar-dark navbar-expand-md"
    >
        <div class="container">
            <a
                class="font-weight-bold navbar-brand py-3 text-uppercase"
                href="{{ url('/') }}"
            >
                <img
                    class="fancy-logo fancy-white-logo"
                    src="{{ URL::asset('img/logo-light.png') }}"
                    alt="Fancy Logo"
                >
                <img
                    class="fancy-logo fancy-dark-logo"
                    src="{{ URL::asset('img/logo-primary.png') }}"
                    alt="Fancy Logo"
                >
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#fancy-menu"
                aria-controls="fancy-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            @isset ($show_nav)
                <div
                    class="collapse navbar-collapse"
                    id="fancy-menu"
                >
                    <ul class="navbar-nav ml-auto text-uppercase">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#home"
                            >
                                @lang('Home') <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#features"
                            >@lang('Features')</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#how-it-works"
                            >@lang('How It Works')</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#testimonial"
                            >@lang('Testimonial')</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#plans"
                            >@lang('Our Plans')</a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
</header>