<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/lang.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/checkout.js') }}" defer></script>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit&hl={{ app()->getLocale() }}"
            async defer>
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">

    @env('production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=UA-143244951-1">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', 'UA-143244951-1');
    </script>
    @endenv
</head>

<body>
    <div id="app" class="summary">
        <!-- Header -->
        <header>
            <nav id="fancy-navbar"
                 class="bg-transparent border-0 fixed-top navbar navbar-dark navbar-expand-md pt-4">
                <div class="align-items-end container d-flex">
                    <a href="{{ url('/') }}">
                        {{-- TODO: Change to SVG --}}
                        <img class="fancy-logo"
                             src="{{ URL::asset('img/logo-light.png') }}"
                             alt="Fancy Logo">
                    </a>
                    <div class="collapse navbar-collapse flex-column align-items-end"
                         id="fancy-menu">
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="d-md-flex d-none mb-3 small locale">
                            @if(App::isLocale('en'))
                            <span>English</span>
                            @else
                            <a href="{{ route('web.locale', 'en') }}">
                                English
                            </a>
                            @endif
                            <span class="px-3">|</span>
                            @if(App::isLocale('es'))
                            <span>Español</span>
                            @else
                            <a href="{{ route('web.locale', 'es') }}">
                                Español
                            </a>
                            @endif
                        </div>
                        <div>
                            @guest
                            <a href="{{ route('admin.login') }}"
                               class="btn btn-info btn-sm px-4 py-2 text-capitalize">
                                @lang('Login')
                            </a>
                            @endguest

                            @auth
                            <a href="{{ route('admin.dashboard') }}"
                               class="btn btn-info btn-sm px-3 py-2 text-capitalize">
                                @lang('Dashboard')
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- / Header -->

        <main class="pb-5 pt-7">
            <section class="skew-section-primary"></section>

            <section id="checkout" class="pt-7">
                <div class="container">
                    <checkout-component :support-email="'{{ config('fancy.email') }}'"
                                        :locale="'{{ app()->getLocale() }}'"
                                        :action="'{{ route('subscription') }}'"
                                        :recaptcha-key="'{{ config('fancy.recaptcha_site_key') }}'"
                                        :product='@json($product)'
                                        :addons='@json($addons)'>
                    </checkout-component>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
