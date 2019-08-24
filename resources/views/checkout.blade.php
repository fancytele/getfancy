<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="/js/lang.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit&hl=' . app()->getLocale()}}"
            async defer>
    </script>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
          crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @env('production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143244951-1">
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
    <div id="app">
        @include('partials.header')

        <main class="py-5">
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