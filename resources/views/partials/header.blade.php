<header>
    <nav
        id="getfancy-navbar"
        class="border-0 bg-transparent fixed-top navbar navbar-dark navbar-expand-md"
    >
        <div class="container">
            <a
                class="font-weight-bold navbar-brand py-3 text-uppercase"
                href="{{ url('/') }}"
            >
                <img
                    class="getfancy-logo getfancy-white-logo"
                    src="{{ URL::asset('img/logo-light.png') }}"
                    alt="Fancy Logo"
                >
                <img
                    class="getfancy-logo getfancy-dark-logo"
                    src="{{ URL::asset('img/logo-primary.png') }}"
                    alt="Fancy Logo"
                >
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#getfancy-menu"
                aria-controls="getfancy-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            @isset ($show_nav)
                <div
                    class="collapse navbar-collapse"
                    id="getfancy-menu"
                >
                    <ul class="navbar-nav ml-auto text-uppercase">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#home"
                            >
                                Home <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#features"
                            >Features</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#how-it-works"
                            >How it Works</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#testimonial"
                            >Testimonial</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#plans"
                            >Our Plans</a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
</header>