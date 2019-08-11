<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fancy</title>

    <script src="https://js.stripe.com/v3/"></script>

    <!-- Scripts -->
    <script src="/js/lang.js"></script>
    <script src="{{ asset('js/home.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
          crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        @include('partials.header')

        <main class="py-5">
            <section class="skew-section-primary"></section>

            <section id="checkout" class="pt-7">
                <div class="container">
                    <checkout-component :locale="'{{ app()->getLocale() }}'"
                                        :action="'{{ route('subscription') }}'"
                                        :product='@json($product)'
                                        :addons='@json($addons)'>
                    </checkout-component>
                </div>
            </section>
        </main>
    </div>
</body>

</html>