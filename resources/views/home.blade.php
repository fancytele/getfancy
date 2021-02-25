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
        <script src="{{ asset(mix('js/home.js')) }}" defer>
        </script>

        <script>
          function validateForm() {
            var x = document.forms["myForm"]["price"].value;
            if (x < {{ env('MINIMUM_PRODUCT_PRICE') }}) {
              //document.getElementById('priceError').style.display = "block";
              document.getElementById('plan_submit').disabled = "true";
              $('#exampleModal').modal('show');

              return false;
            }
            else{
              document.getElementById('plan_submit_backend').click();
              return true;
            }
          }
          function closeDialog(){
            document.getElementById('priceError').style.display = "none";
          }
        </script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet"
              href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset(mix('css/web.css')) }}" rel="stylesheet">

        <style>
            input{
                outline: none;
                padding: 0;
                margin: 0;
            }
            ::placeholder {
                color: white;
                font-weight: bold;
            }
            .arrow_box {
                position: relative;
                background: #704895;
                border: 1px solid #704895;
            }
            .arrow_box:after, .arrow_box:before {
                top: 100%;
                left: 50%;
                border: solid transparent;
                content: "";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
            }

            .arrow_box:after {
                border-color: rgba(136, 183, 213, 0);
                border-top-color: #704895;
                border-width: 5px;
                margin-left: -5px;
            }
            .arrow_box:before {
                border-color: rgba(194, 225, 245, 0);
                border-top-color: #704895;
                border-width: 6px;
                margin-left: -6px;
            }
        </style>
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

        @env('local')
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143532505-1"></script>
                <script>
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag('js', new Date());

                  gtag('config', 'UA-143532505-1');
                </script>
        @endenv
    </head>

    <body>
        <!-- Header -->
        <header>
            <nav id="fancy-navbar" class="bg-transparent border-0 fixed-top navbar navbar-dark navbar-expand-md pt-4">
                <div class="align-items-end container d-flex">
                    <a href="{{ url('/') }}">
                        {{-- TODO: Change to SVG --}}
                        <img class="fancy-logo" src="{{ URL::asset('img/Fancyy_Logo-01.png') }}" alt="Fancyy Logo">
                        <img class="fancy-logo fancy-dark-logo" src="{{ URL::asset('img/Fancyy_Logo-01.png') }}"
                             alt="Fancyy Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fancy-menu"
                            aria-controls="fancy-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="font-weight-bold la la-2x la-bars text-primary"></i>
                    </button>
                    <div class="collapse navbar-collapse flex-column align-items-end" id="fancy-menu">
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="d-md-flex d-none mb-4 small">
                            @if(App::isLocale('en'))
                            <span class="text-body">English</span>
                            @else
                            <a href="{{ route('web.locale', 'en') }}" class="text-muted">
                                English
                            </a>
                            @endif
                            <span class="px-3">|</span>
                            @if(App::isLocale('es'))
                            <span class="text-body">Español</span>
                            @else
                            <a href="{{ route('web.locale', 'es') }}" class="text-muted">
                                Español
                            </a>
                            @endif
                        </div>
                        <ul class="align-items-center d-flex ml-auto navbar-nav">
                            <li class="nav-item">
                                <a class="font-weight-bold nav-link text-body" href="#features">
                                    @lang('Why Fancyy?')
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="font-weight-bold nav-link text-body" href="#how-it-works">
                                    @lang('How It Works')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="font-weight-bold nav-link text-body" href="#featuresPlans">
                                    @lang('Features')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="font-weight-bold nav-link text-body" href="#plans">
                                    @lang('Plans')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="font-weight-bold nav-link text-body"
                                   href="#about">@lang('About Us')</a>
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
                    </div>
                </div>
            </nav>
        </header>
        <!-- / Header -->

        <div id="have-us-call-you" class="call-you-box position-fixed">
            <div class="bg-white call-you-content rounded">
                <h3 class="bg-primary call-you-title rounded-top">
                    @lang('Have us call you!')
                </h3>

                <form action="/callyou" method="POST" class="overflow-hidden p-4 position-relative">
                    <div class="form-group">
                        <label for="name" class="m-0">@lang('Name')</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="m-0">
                            @lang('Phone Number')
                        </label>
                        <input type="tel" class="form-control" name="phone" placeholder="(000) 000-0000" id="phone"
                               required>
                    </div>
                    <div class="call-you-error d-none small text-danger">
                        @lang('An error has ocurred, please try again')
                    </div>

                    <button type="submit" class="btn btn-lg btn-outline-primary ladda-button ml-auto mt-2"
                            data-style="zoom-out" data-spinner-color="#704895">
                        @lang('Submit')
                    </button>

                    <div class="bg-white call-you-message d-flex position-absolute">
                        <h3 class="call-you-message-text m-auto position-relative">
                            <svg x="0px" y="0px" viewBox="0 0 296.938 296.938"
                                 class="call-you-message-icon position-absolute">
                                <path d="M208.924,188.481h-20.788v-20.215c5-5.883,8.861-12.365,12.098-18.87c1.267-0.226,2.7-0.642,3.961-1.244
                                c5.791-2.767,11.125-9.509,14.133-18.036c3.468-9.827,3.093-20.162-0.75-25.881c0.514-10.615,0.203-40.198-18.395-60.944
                                c-3.086-3.442-6.506-6.423-10.252-8.965C185.688,14.666,169.498,0,149.43,0c-19.75,0-37.762,14.317-41.314,33.575
                                c-7.074,4.054-13.037,9.307-17.735,15.734c-10.271,14.054-13.492,33.92-9.41,54.926c-5.297,5.275-6.436,14.558-2.444,25.882
                                c2.009,5.692,5.098,10.741,8.697,14.22c2.971,2.869,6.239,4.604,9.486,5.105c3.394,6.812,7.425,13.596,12.425,19.688v19.351H88.014
                                c-29.855,0-52.591,51.352-52.591,76.925c0,2.859,1.652,5.585,4.24,6.8c40.122,18.834,77.952,24.732,109.433,24.732
                                c16.571,0,31.385-1.586,43.841-3.776c39.228-6.896,63.791-20.516,64.818-21.093c2.322-1.306,3.76-4.006,3.76-6.67
                                C261.515,239.826,238.778,188.481,208.924,188.481z M97.421,116.427c3.23-3.784,12.414-15.094,18.051-27.587
                                c11.75,12.234,36.941,26.687,90.465,26.764c0.214,2.045,0.052,5.398-1.433,9.606c-1.983,5.617-4.846,8.586-6.152,9.442
                                c-1.524-0.5-3.18-0.494-4.716,0.038c-1.93,0.668-3.495,2.105-4.324,3.972c-7.938,17.861-23.51,38.719-40.843,38.719
                                c-9.131,0-17.571-5.784-24.823-13.869c3.477,0.661,6.659,0.881,9.301,0.881c0.327,0,0.643,0.066,0.953,0.061
                                c1.864,2.404,4.773,4.028,8.051,4.028h13.037c5.629,0,10.148-4.705,10.148-10.334v-3.208c0-5.629-4.52-10.458-10.148-10.458H141.95
                                c-3.72,0-6.965,2.133-8.744,5.108c-2.985,0.054-7.268-0.212-11.854-1.925C110.105,143.465,101.953,132.696,97.421,116.427z
                                M149.433,14.745c8.807,0,15.624,4.409,20.418,11.23c-6.067-1.529-13.714-2.316-20.714-2.316v0.003
                                c-8,0.063-15.598,0.958-22.571,2.646C131.342,19.301,140.513,14.745,149.433,14.745z M102.139,58.01
                                c9.25-12.658,24.997-19.437,46.997-19.603v-0.003c16,0,30.136,4.939,38.896,14.679c13.147,14.621,14.91,36.817,14.862,47.761
                                c-39.053-0.483-59.581-9.094-70.018-16.352c-10.538-7.327-12.721-14.431-12.961-15.313c-0.607-3.776-3.995-6.305-7.793-6.024
                                c-3.848,0.289-6.789,3.651-6.789,7.51c0,6.797-5.107,16.561-10.75,24.988C92.565,80.717,95.077,67.672,102.139,58.01z
                                M116.521,203.481c4.071,0,6.614-3.054,6.614-7.126v-12.893c8,5.337,16.029,8.663,25,8.663c9.24,0,18-3.524,26-9.149v13.379
                                c0,4.072,3.191,7.126,7.264,7.126h7.893l-40.823,31.927l-40.823-31.927H116.521z M190.383,278.671
                                c-33.137,5.827-83.967,7.346-139.946-17.624c2.258-20.604,18.398-52.314,33.973-56.772l59.518,46.548
                                c1.335,1.043,2.937,1.564,4.542,1.564c1.604,0,3.207-0.521,4.542-1.564l59.518-46.548c15.628,4.474,31.826,36.39,33.995,56.987
                                C238.392,265.165,218.32,273.759,190.383,278.671z">
                                </path>
                            </svg>
                            @lang('Thank you!'),
                            <span class="d-block font-weight-light h4 mb-0 mt-2">
                                @lang('One of our agents will call you shortly!')
                            </span>
                        </h3>
                    </div>
                </form>
            </div>
            <button class="btn btn-lg btn-primary call-you-button py-3 rounded-circle">
                <i class="la la-phone"></i>
                <i class="la la-times"></i>
            </button>
        </div>

        <main>
            <!-- Hero Section -->
            <section id="home" class="fancy-section hero pt-7 pt-sm-8">
                <div class="container">
                    <div class="row" data-aos="zoom-in">
                        <div class="col-md-7">
                            <h1 class="display-3 font-heading font-weight-bold line-height-md text-primary">
                                @lang('Hero Title')
                            </h1>
                           <div class="my-md-5 w-75">
                               <p class="mb-2">
                                   @lang('Hero Message title')
                               </p><br>
                               <p>
                                   @lang('Hero Message')
                               </p>
                           </div>
                            <div class="d-inline-block">
                                <a href="#plans" id="get-started"
                                   class="btn btn-block btn-lg btn-primary px-6 rounded text-uppercase">
                                    @lang('Get Fancyy')
                                </a>
                                <p class="mb-0">
                                    <small class="text-muted">
                                        @lang('Cancel anytime')
                                    </small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="{{ asset('/img/fancyy_home.png') }}" alt="Business man"
                                 class="d-flex hero-img img-fluid ml-auto">
                        </div>
                    </div>
                </div>
            </section>
            <!-- / Hero Section -->

            <!-- Features Section -->
            <section id="features" class="bg-primary text-white">
                <svg class="h-60 w-100" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-body" points="0,0 100,0 0,100 0,100"></polygon>
                </svg>
                <div class="fancy-section">
                    <div class="container">
                        <div class="text-center" data-aos="fade-up">
                            <h2 class="display-4 font-heading">
                                @lang('Why Fancyy?')
                            </h2>
                        </div>
                        <div class="mt-7 row">
                            <div class="col-md-4 mb-3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="las la-bolt position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Powerful')
                                </h4>
                                <p>
                                    @lang('Powerful Message')
                                </p>
                            </div>
                            <div class="col-md-4 mb-3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="las la-handshake position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Credible')
                                </h4>
                                <p>
                                    @lang('Credible Message')
                                </p>
                            </div>
                            <div class="col-md-4 mb-3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="lar la-check-square position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Easy')
                                </h4>
                                <p>
                                    @lang('Easy Message')
                                </p>
                            </div>

                            <div class="col-md-4 mb-3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="lar la-lightbulb position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Smart')
                                </h4>
                                <p>
                                    @lang('Smart Message')
                                </p>
                            </div>
                            <div class="col-md-4 mb3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="las la-chart-pie position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Data Driven')
                                </h4>
                                <p>
                                    @lang('Data Driven Message')
                                </p>
                            </div>
                            <div class="col-md-4 mb3" data-aos="fade-up">
                                <div class="mb-4">
                                    <span class="bg-info h1 px-2 py-1 rounded-circle">
                                        <i class="las la-money-bill-alt position-relative top-1"></i>
                                    </span>
                                </div>
                                <h4 class="font-weight-bold">
                                    @lang('Affordable')
                                </h4>
                                <p>
                                    @lang('Affordable Message')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <svg class="h-60 w-100" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-body" points="0,80 100,0 100,100 0,100" />
                </svg>
            </section>
            <!-- / Features Section -->

            <!-- How It Works Section -->
            <section id="how-it-works" class="fancy-section">
                <div class="container pb-5" data-aos="fade-up">
                    <div class="mb-6">
                        <h2 class="display-4 font-heading mb-1 text-primary">
                            @lang('How It Works')
                        </h2>
                        <p class="small">@lang('How It Works Message')</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="work-list">
                                <div class="mb-5 media">
                                    <div class="work-item-left">
                                        <img src="{{ asset('/img/web/phone-office.svg') }}" class="img-fluid"
                                             alt="Phone office">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="mt-0">
                                            1. @lang('Get Started')
                                        </h4>
                                        <small>
                                            @lang('Get Started Message')
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="work-list">
                                <div class="mb-5 media">
                                    <div class="work-item-left">
                                        <img src="{{ asset('/img/web/microphone-svgrepo-com.svg') }}"
                                            class="d-flex img-fluid m-auto w-60" alt="Phone office">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="mt-0">
                                            2. @lang('Customize')
                                        </h4>
                                        <small>
                                            @lang('Customize Message')
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="work-list">
                                <div class="mb-5 media">
                                    <div class="work-item-left">
                                        <img src="{{ asset('/img/web/people-extensions.svg') }}" class="img-fluid"
                                             alt="Phone office">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="mt-0">
                                            3. @lang('Smarten up with your data & reports.')
                                        </h4>
                                        <small>
                                            @lang('Smarten Message')
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="work-list">
                                <div class="mb-5 media">
                                    <div class="work-item-left">
                                        <img src="{{ asset('/img/web/phone-office.svg') }}" class="img-fluid"
                                             alt="Phone office">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="mt-0">
                                            4. @lang('Take Action!')
                                        </h4>
                                        <small>
                                            @lang('Take Action Message')
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / How It Works Section -->

            <!-- Plans Section -->
            <section id="featuresPlans" class="bg-primary text-white pt-0 text-center">
                <svg class="h-60 mb-6 w-100" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-body" points="0,0 100,0 0,100 0,100"></polygon>
                </svg>
                <div class="container fancy-section" data-aos="fade-up">
                    <div class="text-center" data-aos="fade-up">
                        <h2 class="display-4 font-heading">
                            @lang('Features')
                        </h2>
                        <p class="mx-auto w-lg-75">
                            @lang('Plans and Features Message')
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="my-5 text-left">
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Phone Calls')</dt>
                                            <dd><small>@lang('Feature Phone Calls Message')</small></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Auto-Play')</dt>
                                            <dd><small>@lang('Feature Auto-Play Message')</small></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Text-able')</dt>
                                            <dd><small>@lang('Feature Text-able Message')</small></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Conference Call Room')</dt>
                                            <dd><small>@lang('Feature Conference Call Room Message')</small></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Auto-Reply SMS')</dt>
                                            <dd><small>@lang('Feature Auto-Reply SMS')</small></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature E-Fax')</dt>
                                            <dd><small>@lang('Feature E-Fax Message')</small></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Data Driven')</dt>
                                            <dd><small>@lang('Feature Data Driven SMS')</small></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Spam Filtering Queues')</dt>
                                            <dd><small>@lang('Feature Spam Filtering Queues Message')</small></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Call Queues')</dt>
                                            <dd><small>@lang('Feature Call Queues SMS')</small></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="border-bottom h-100 mb-0 px-lg-4 pt-3 pb-2">
                                            <dt>@lang('Feature Better Call Management')</dt>
                                            <dd><small>@lang('Feature Better Call Management Message')</small></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <svg class="h-60 w-100" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-body" points="0,80 100,0 100,100 0,100"></polygon>
                </svg>
            </section>
            <!-- / Plans Section -->

            <!-- Plans Section -->

            <section id="plans"  class="bg-white fancy-section pt-4 text-center">
                <form id="planForm" name="myForm" action="{{ route('web.planPrice') }}" method="POST">
                    @csrf
                    <h2 class="display-4 font-heading text-primary">
                        @lang('How much do you want to pay')
                    </h2>
                    <p style="font-size: small; margin-bottom: 18px">@lang('Pay Message')</p>

                    <div style="border: 2px solid #704895;border-radius: 5px;max-width: 10rem;
                                 margin: 0 auto;display: flex; flex-direction: column; justify-content: center;" >
                        <div style="background-color: #704895">
                            <span class="small text-white">@lang('Monthly Payment')</span>
                        </div>
                        <div style="display: flex; flex-direction: row; justify-content: center;background-color: #704895;">
                            <span class="text-white font-weight-bold" style="font-size: 22px">$</span>
                            <input style="border: none;background-color: #704895;color: white;max-width: 3rem; font-size: 22px;font-weight: bold"
                                   type="number" name="price"
                                   id="price"
                                   required
                            >
                        </div>
                        <div class="arrow_box"></div>
                        <div class="m-2" style="background-color: #FFFFFF; font-size:10px " >
                            @lang('Pay whatever you think is fair')
                        </div>
                    </div>

             <!--       <div id="priceError" style="max-width: 14rem; display:none; margin: 0 auto; background-color: #F3F3F3; border-radius: 5px;">
                        <div style="display:flex;flex-direction: row;">
                            <div style="padding: 16px 10px 0">
                                <h1><i class="fa fa-exclamation-triangle text-primary"></i></h1>
                            </div>
                            <div style="text-align: left; line-height: 10px; padding:5px 0 0">
                                <div>
                                    <span class="text-primary font-weight-bolder" style="font-size: 10px">@lang('Heads Up')</span>
                                </div>
                                <div>
                                    <span style="font-size: 9px;">@lang('Heads Up Message')</span>
                                </div>

                            </div>
                            <div class="text-left pr-3">
                                <a href="javascript:void(0)" onclick="closeDialog()" style="color:#464343">&times;</a>
                            </div>
                        </div>
                    </div>

                  @if($errors->any())
                        <div id="priceError" style="max-width: 14rem; display:none; margin: 0 auto; background-color: #F3F3F3; border-radius: 5px;">
                            <div style="display:flex;flex-direction: row;">
                                <div style="padding: 16px 10px 0">
                                    <h1><i class="fa fa-exclamation-triangle text-primary"></i></h1>
                                </div>
                                <div style="text-align: left; line-height: 10px; padding:5px 0 0">
                                    <div>
                                        <span class="text-primary font-weight-bolder" style="font-size: 10px">@lang('Heads Up')</span>
                                    </div>
                                    <div>
                                        <span style="font-size: 9px;">@lang('Heads Up Message')</span>
                                    </div>

                                </div>
                                <div class="text-left pr-3">
                                    <a href="javascript:void(0)" onclick="closeDialog()" style="color:#464343">&times;</a>
                                </div>
                            </div>
                        </div>
                    @endif -->

                    <br>
                    <h5>@lang('First month free')</h5>
                    <button id="plan_submit_backend" type="submit" style="display: none" class="btn btn-primary px-6" disabled>Nextyolo</button>
                    <button id="plan_submit"  onclick="return validateForm()" class="btn btn-primary px-6" disabled>@lang('Next')</button>
                </form>
            </section>
            <!-- Plans Section -->

            <!-- Testimonials Section -->
            <section id="about" class="fancy-section position-relative pt-0">
                <svg class="h-60 mb-6 position-relative w-100 z-index" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-white" points="0,0 100,0 0,100 0,100"></polygon>
                </svg>
                <svg class="h-20 h-sm-100 position-absolute pull-left pull-top w-100 w-sm-50"
                     preserveAspectRatio="none" viewBox="0 0 100 100">
                    <polygon class="fill-primary d-md-none"
                             points="0,0 100,0 100,80 0,100" />
                    <polygon class="fill-primary d-none d-md-block"
                             points="0,0 100,0 90,100 0,100" />
                </svg>
                <div class="container py-md-4" data-aos="fade-up">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-md-0 px-4 px-sm-0 py-4">
                                <h2 class="display-3 d-md-inline-block font-heading mr-3 text-white">
                                    @lang('About') Fancyy
                                </h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mt-7 mt-md-0">@lang('About us message')</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / Testimonials Section -->
        </main>

        <footer class="footer overflow-hidden text-white">
            <div class="container" data-aos="fade-up">
                <h3 class="display-4 font-weight-bold mb-4 text-center">
                    @lang('Contact Us')
                </h3>

                <form action="contactus" method="POST" class="mb-5">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name" class="sr-only">
                                            @lang('Full Name')
                                        </label>
                                        <input type="text" class="form-control w-100" name="full_name" id="full_name"
                                               placeholder="@lang('Full Name')" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="sr-only">
                                            @lang('E-mail')
                                        </label>
                                        <input type="email" class="form-control w-100" name="email" id="email"
                                               placeholder="@lang('E-mail')" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message" class="sr-only">
                                            @lang('Message')
                                        </label>
                                        <textarea class="form-control" name="message" id="message" rows="5"
                                                  placeholder="@lang('Message')" required></textarea>
                                    </div>
                                </div>
                                <div class="text-center w-100">
                                    <p class="d-none text-message"></p>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary font-weight-bold px-6">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="border-top pt-2" style="display: flex;flex-direction: row;justify-content: space-between;">
                    <div>
                        <small>&copy; Fancyy {{ date('Y') }}</small>
                    </div>
                    <div>
                        <a href="{{ route('web.privacy_policy') }}"  class="text-white"><small>Privacy Policy</small></a>
                        &nbsp;&nbsp;<a href="{{ route('web.terms_of_service') }}"  class="text-white"><small>Terms of Service</small></a>
                        &nbsp;&nbsp;<a href="{{ route('web.cookie_policy') }}"  class="text-white"><small>Cookie Policy</small></a>
                    </div>
                </div>

            </div>
        </footer>
        <!--try-->
        <div class="modal fade" id= "exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="delete-element-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button" class="close mr-3 mt-2"
                                data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times text-primary" style="font-size: medium"></i>
                        </button>
                        <div class="d-flex my-3">
                            <div style="display:flex;flex-direction: row;">
                                <div style="padding: 16px 10px 0">
                                    <h1><i class="fa fa-exclamation-triangle text-primary"></i></h1>
                                </div>
                                <div style="text-align: left; line-height: 13px; padding:5px 0 0">
                                    <div>
                                        <span class="text-primary font-weight-bolder" style="font-size: 15px">@lang('Heads Up')</span>
                                    </div>
                                    <div>
                                        <span style="font-size: 13px;">@lang('Heads Up Message')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--try-->
    </body>
</html>
