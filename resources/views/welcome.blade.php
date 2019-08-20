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
    <script src="{{ asset('js/home.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet"
          href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    @include('partials.header', ['show_nav' => true])

    <div id="have-us-call-you" class="call-you-box position-fixed">
        <div class="bg-white call-you-content rounded">
            <h3 class="bg-primary call-you-title rounded-top">
                @lang('Have us call you!')
            </h3>

            <form action="/callyou" method="POST"
                  class="overflow-hidden p-4 position-relative">
                <div class="form-group">
                    <label for="name" class="m-0">@lang('Name')</label>
                    <input type="text" class="form-control" name="name"
                           id="name" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="m-0">
                        @lang('Phone Number')
                    </label>
                    <input type="text" class="form-control" name="phone"
                           id="phone" required>
                </div>
                <div class="call-you-error d-none small text-danger">
                    @lang('An error has ocurred, please try again')
                </div>

                <button type="submit"
                        class="btn btn-lg btn-outline-primary ladda-button ml-auto mt-2"
                        data-style="zoom-out" data-spinner-color="#704895">
                    @lang('Submit')
                </button>

                <div class="bg-white call-you-message d-flex position-absolute">
                    <h3 class="call-you-message-text m-auto position-relative">
                        <svg x="0px" y="0px" viewBox="0 0 296.938 296.938"
                             class="call-you-message-icon position-absolute">
                            <path
                                  d="M208.924,188.481h-20.788v-20.215c5-5.883,8.861-12.365,12.098-18.87c1.267-0.226,2.7-0.642,3.961-1.244
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
        <button
                class="btn btn-lg btn-primary call-you-button py-3 rounded-circle">
            <i class="la la-phone"></i>
            <i class="la la-times"></i>
        </button>
    </div>

    <main class="overflow-hidden">
        <!-- Hero Section -->
        <section id="home" class="hero text-white d-flex align-items-center"
                 style="background-image: url(img/hero_blue.jpg)">
            <div class="container">
                <div class="hero-content" data-aos="zoom-in">
                    <h3 class="display-3">@lang('Virtual Phone System')</h3>
                    <p>@lang('Hero Message')</p>
                    <ul class="list-unstyled pl-3">
                        <li class="mb-3">
                            <i
                               class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            @lang('Get a Toll Free, Local Phone Number.')
                        </li>
                        <li class="mb-3">
                            <i
                               class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            @lang('Create Custom Greetings, Unlimited
                            Extensions.')
                        </li>
                        <li>
                            <i
                               class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            @lang('Get Voicemails by email, Manage Your Phone
                            System Online.')
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- / End Hero Section -->

        <!-- Features Section -->
        <section id="features" class="bg-white-ghost position-relative">
            <div class="background-image background-position-top d-lg-block d-none h-100 position-absolute position-bottom w-50-gutter"
                 style="background-image: url(img/feature-business-man.jpg)">
            </div>
            <div class="container">
                <div class="row d-flex">
                    <div class="col-lg-6 ml-auto fancy-section">
                        <div data-aos="zoom-in">
                            <h3 class="display-4 text-primary">@lang('Features')
                            </h3>
                            <p class="mb-5 text-blue-solid">
                                @lang('Feature Message')
                            </p>
                        </div>
                        <div class="row d-flex">
                            <div class="col-md-6" data-aos="fade-right">
                                <h5 class="font-weight-bold">
                                    @lang('Work Anywhere')
                                </h5>
                                <p>@lang('Work Anywhere Message')</p>
                            </div>
                            <div class="col-md-6" data-aos="fade-left">
                                <h5 class="font-weight-bold">
                                    @lang('Relability')
                                </h5>
                                <p>@lang('Relability Message')</p>
                            </div>
                            <div class="col-md-6" data-aos="fade-right">
                                <h5 class="font-weight-bold">
                                    @lang('Management Tools')
                                </h5>
                                <p>@lang('Management Tools Message')</p>
                            </div>
                            <div class="col-md-6" data-aos="fade-left">
                                <h5 class="font-weight-bold">
                                    @lang('Easy Setup')
                                </h5>
                                <p>@lang('Easy Setup Message')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- / End Features Section -->

        <!-- How It Works Section -->
        <section id="how-it-works" class="fancy-section text-center">
            <div class="container">
                <div class="mb-5 work-heading" data-aos="zoom-in">
                    <h3 class="display-4 text-primary">@lang('How It Works')
                    </h3>
                    <p class="m-auto text-blue-solid">
                        @lang('How It Works Message')</p>
                </div>
                <div class="row work-list">
                    <div class="col-md-4 mb-3" data-aos="fade-up"
                         data-aos-anchor-placement="center-bottom">
                        <svg x="0px" y="0px" viewBox="0 0 18 18"
                             class="bg-lighter fancy-svg px-5 text-blue-solid">
                            <g>
                                <g>
                                    <path class="fill-blue-solid"
                                          d="M6.719,0h-1.05C5.114,0,4.664,0.45,4.664,1.005v12.622c0,0.548,0.439,0.993,0.985,1.004
                                            c-0.172,0.875-0.945,1.538-1.869,1.538c-1.051,0-1.907-0.857-1.907-1.907V9.45c0-0.238-0.192-0.43-0.429-0.43
                                            s-0.43,0.191-0.43,0.43v4.812c0,1.524,1.241,2.764,2.766,2.764c1.397,0,2.554-1.044,2.737-2.393H6.72
                                            c0.555,0,1.006-0.451,1.006-1.006V1.006C7.725,0.451,7.274,0,6.719,0z" />
                                    <path class="fill-blue-solid"
                                          d="M15.159,1.595h-7.01V13.89h7.01c0.472,0,0.853-0.381,0.853-0.852V2.447
                                            C16.012,1.976,15.631,1.595,15.159,1.595z M10.812,12.631h-1.49v-1.489h1.49V12.631z M10.812,10.556h-1.49v-1.49h1.49V10.556z
                                            M10.823,8.495h-1.49v-1.49h1.49V8.495z M12.942,12.631h-1.491v-1.489h1.491V12.631z M12.942,10.556h-1.491v-1.49h1.491V10.556z
                                            M12.952,8.495h-1.491v-1.49h1.491V8.495z M15.071,12.631h-1.49v-1.489h1.49V12.631z M15.071,10.556h-1.49v-1.49h1.49V10.556z
                                            M15.082,8.495h-1.491v-1.49h1.491V8.495z M15.088,4.085H9.073V2.328h6.015V4.085z" />
                                    <path class="fill-blue-solid"
                                          d="M3.696,13.89h0.521V1.595H3.696c-0.47,0-0.852,0.382-0.852,0.852v10.592
                                            C2.844,13.509,3.226,13.89,3.696,13.89z" />
                                </g>
                            </g>
                        </svg>
                        <div class="mt-4">
                            <h5 class="font-weight-bold">
                                @lang('Pick a number of your choice')
                            </h5>
                            <p>@lang('Pick a number Message')</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up"
                         data-aos-anchor-placement="center-bottom">
                        <i
                           class="la la-microphone la-5x px-5 bg-lighter text-blue-solid"></i>
                        <div class="mt-4">
                            <h5 class="font-weight-bold">
                                @lang('Record greetings or use recording service')
                            </h5>
                            <p>@lang('Record greetings Message')</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up"
                         data-aos-anchor-placement="center-bottom">
                        <svg x="0px" y="0px" viewBox="0 0 290.626 290.626"
                             class="bg-lighter fancy-svg px-5 text-blue-solid">
                            <g>
                                <g class="fill-blue-solid">
                                    <path
                                          d="M154.8,34.8c5.5-3.3,9.3-9.2,9.3-16.1c0-10.3-8.4-18.8-18.8-18.8s-18.8,8.4-18.8,18.8
                                        c0,6.9,3.8,12.8,9.3,16.1c-8.2,3.6-14,11.8-14,21.4v4.7c0,2.6,2.1,4.7,4.7,4.7h14.1v32.8h9.4V65.6h14.1c2.6,0,4.7-2.1,4.7-4.7
                                        v-4.7C168.7,46.7,163,38.5,154.8,34.8z M145.3,9.4c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4s-9.4-4.2-9.4-9.4S140.1,9.4,145.3,9.4z
                                         M131.2,56.3c0-7.8,6.3-14.1,14.1-14.1s14.1,6.3,14.1,14.1H131.2z" />
                                    <path
                                          d="M9.4,98.4h37.5c2.6,0,4.7-2.1,4.7-4.7v-0.6l49,32.6l5.2-7.8L50,80.8c-2.2-5.9-6.7-10.6-12.4-13.2
                                        c5.5-3.3,9.3-9.2,9.3-16.1c0-10.3-8.4-18.8-18.8-18.8S9.4,41.2,9.4,51.6c0,6.9,3.8,12.8,9.3,16.1c-8.2,3.6-14,11.8-14,21.4v4.7
                                        C4.7,96.3,6.8,98.4,9.4,98.4z M28.1,42.2c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4s-9.4-4.2-9.4-9.4S23,42.2,28.1,42.2z M28.1,75
                                        c7.8,0,14.1,6.3,14.1,14.1H14.1C14.1,81.3,20.4,75,28.1,75z" />
                                    <path
                                          d="M272,67.7c5.5-3.3,9.3-9.2,9.3-16.1c0-10.3-8.4-18.8-18.8-18.8s-18.8,8.4-18.8,18.8c0,6.9,3.8,12.8,9.3,16.1
                                        c-5.7,2.5-10.2,7.3-12.4,13.2L184.9,118l5.2,7.8l49-32.6v0.6c0,2.6,2.1,4.7,4.7,4.7h37.5c2.6,0,4.7-2.1,4.7-4.7v-4.7
                                        C285.9,79.5,280.2,71.3,272,67.7z M262.5,42.2c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4s-9.4-4.2-9.4-9.4S257.3,42.2,262.5,42.2z
                                         M248.4,89.1c0-7.8,6.3-14.1,14.1-14.1c7.8,0,14.1,6.3,14.1,14.1H248.4z" />
                                    <path
                                          d="M272,198.9c5.5-3.3,9.3-9.2,9.3-16.1c0-10.3-8.4-18.8-18.8-18.8s-18.8,8.4-18.8,18.8c0,6.9,3.8,12.8,9.3,16.1
                                        c-2.6,1.2-4.9,2.7-6.9,4.7l-55.9-38.7l-5.3,7.7l56,38.8c-1.1,2.8-1.8,5.8-1.8,8.9v4.7c0,2.6,2.1,4.7,4.7,4.7h37.5
                                        c2.6,0,4.7-2.1,4.7-4.7v-4.7C285.9,210.8,280.2,202.6,272,198.9z M262.5,173.4c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4
                                        s-9.4-4.2-9.4-9.4S257.3,173.4,262.5,173.4z M248.4,220.3c0-7.8,6.3-14.1,14.1-14.1c7.8,0,14.1,6.3,14.1,14.1H248.4z" />
                                    <path
                                          d="M154.8,259.8c5.5-3.3,9.3-9.2,9.3-16.1c0-8.7-6-16-14.1-18.1v-33.5h-9.4v33.5c-8.1,2.1-14.1,9.4-14.1,18.1
                                        c0,6.9,3.8,12.8,9.3,16.1c-8.2,3.6-14,11.9-14,21.4v4.7c0,2.6,2.1,4.7,4.7,4.7h37.5c2.6,0,4.7-2.1,4.7-4.7v-4.7
                                        C168.7,271.7,163,263.5,154.8,259.8z M145.3,234.4c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4s-9.4-4.2-9.4-9.4
                                        S140.1,234.4,145.3,234.4z M131.2,281.3c0-7.8,6.3-14.1,14.1-14.1s14.1,6.3,14.1,14.1H131.2z" />
                                    <path
                                          d="M100.5,164.9l-55.9,38.7c-2-2-4.3-3.6-6.9-4.7c5.5-3.3,9.3-9.2,9.3-16.1c0-10.3-8.4-18.8-18.8-18.8
                                        s-18.8,8.4-18.8,18.8c0,6.9,3.8,12.8,9.3,16.1c-8.2,3.6-14,11.9-14,21.4v4.7c0,2.6,2.1,4.7,4.7,4.7h37.5c2.6,0,4.7-2.1,4.7-4.7
                                        v-4.7c0-3.2-0.6-6.2-1.8-8.9l56-38.8L100.5,164.9z M28.1,173.4c5.2,0,9.4,4.2,9.4,9.4s-4.2,9.4-9.4,9.4s-9.4-4.2-9.4-9.4
                                        S23,173.4,28.1,173.4z M14.1,220.3c0-7.8,6.3-14.1,14.1-14.1s14.1,6.3,14.1,14.1H14.1z" />
                                </g>
                            </g>
                            <g class="fill-blue-solid">
                                <path d="M174,95.7h-57.3c-3.2,0-5.9,2.6-5.9,5.9v87.5c0,3.2,2.6,5.9,5.9,5.9H174c3.2,0,5.9-2.6,5.9-5.9v-87.5
                                    C179.8,98.3,177.2,95.7,174,95.7z M152.1,186c0,2.1-1.7,3.8-3.8,3.8h-5.9c-2.1,0-3.8-1.7-3.8-3.8v-3.9c0-2.1,1.7-3.8,3.8-3.8h5.9
                                    c2.1,0,3.8,1.7,3.8,3.8V186z M175.6,170.6c0,1.6-1.3,2.9-2.9,2.9H118c-1.6,0-2.9-1.3-2.9-2.9v-65.7c0-1.6,1.3-2.9,2.9-2.9h54.7
                                    c1.6,0,2.9,1.3,2.9,2.9V170.6z" />
                                <path d="M145.3,140.5c4.8,0,8.8-4.6,8.8-10.2c0-7.8-3.9-10.2-8.8-10.2c-4.8,0-8.8,2.4-8.8,10.2
		                            C136.6,135.9,140.5,140.5,145.3,140.5z" />
                                <path
                                      d="M160.2,145.7c-0.2-0.5-0.6-0.8-1-1.1l-6.9-3.6c-0.2-0.1-0.3-0.1-0.5,0c-1.9,1.5-4.2,2.2-6.6,2.2c-2.4,0-4.7-0.8-6.6-2.2
                                    c-0.1-0.1-0.3-0.1-0.5,0l-6.9,3.6c-0.4,0.2-0.8,0.6-1,1.1l-4.4,9.9c-0.3,0.7-0.2,1.5,0.2,2.1c0.4,0.6,1.1,1,1.9,1h34.6
                                    c0.8,0,1.4-0.4,1.9-1c0.4-0.6,0.5-1.4,0.2-2.1L160.2,145.7z" />
                            </g>
                        </svg>
                        {{-- <i
                           class="la la-headphones la-5x px-5 bg-lighter text-blue-solid"></i> --}}
                        <div class="mt-4">
                            <h5 class="font-weight-bold">
                                @lang('Add extensions')
                            </h5>
                            <p>@lang('Add extensions Message')</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- / End How It Works Section -->

        <!-- Testimonials Section -->
        <section id="testimonial" class="fancy-section text-white">
            <div class="container py-5">
                <div class="m-auto text-center w-lg-50">
                    <div id="carouselExampleFade" class="carousel slide"
                         data-interval="false">
                        <ol class="carousel-indicators m-0">
                            <li data-target="#carouselExampleFade"
                                data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleFade"
                                data-slide-to="1"></li>
                            <li data-target="#carouselExampleFade"
                                data-slide-to="2"></li>
                            <li data-target="#carouselExampleFade"
                                data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <blockquote class="blockquote mb-5 mt-4">
                                    <p>@lang('Testimony1')</p>
                                    <footer class="blockquote-footer">
                                        @lang('Testimony Footer')
                                    </footer>
                                </blockquote>
                            </div>
                            <div class="carousel-item">
                                <blockquote class="blockquote mb-5 mt-4">
                                    <p>@lang('Testimony2')</p>
                                    <footer class="blockquote-footer">
                                        @lang('Testimony Footer')
                                    </footer>
                                </blockquote>
                            </div>
                            <div class="carousel-item">
                                <blockquote class="blockquote mb-5 mt-4">
                                    <p>@lang('Testimony3')</p>
                                    <footer class="blockquote-footer">
                                        @lang('Testimony Footer')
                                    </footer>
                                </blockquote>
                            </div>
                            <div class="carousel-item">
                                <blockquote class="blockquote mb-5 mt-4">
                                    <p>@lang('Testimony4')</p>
                                    <footer class="blockquote-footer">
                                        @lang('Testimony Footer')
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- / End Testimonials Section -->

        <!-- Plans Section -->
        <section id="plans" class="fancy-section pb-6 text-center">
            <h3 class="display-4 mb-5 text-primary" data-aos="zoom-in">
                @lang('Our Plans')
            </h3>

            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div data-aos="zoom-in">
                            <h2 class="display-1 text-primary plan-wrapper">
                                @foreach ($products as $product)
                                <span id="{{ $product->slug }}"
                                      class="plan-item{{ $product->is_primary ? ' active' : '' }}">
                                    <span
                                          class="align-top d-inline-block font-weight-bold h1 mr-n3 mt-3">$</span>
                                    <span
                                          class="plan-amount">{{ $product->cost }}</span>
                                    @if($product->discount)
                                    <small
                                           class="badge badge-pill badge-success font-weight-bold plan-save position-absolute px-3 py-2">
                                        @lang('Save') {{ $product->discount }}
                                    </small>
                                    @endif
                                </span>
                                @endforeach
                            </h2>

                            <div class="btn-group" role="group"
                                 aria-label="Our Plans Button Groups">
                                @foreach ($products as $product)
                                <button type="button"
                                        class="btn btn-outline-light{{ $product->is_primary ? ' active' : '' }}"
                                        data-type="{{ $product->slug }}">@lang($product->name)</button>
                                @endforeach
                            </div>

                            <p>
                                <small class="text-muted font-italic">
                                    @lang('Variant time, same characteristics')
                                </small>
                            </p>
                        </div>

                        <div class="my-5 row" data-aos="fade-up"
                             data-aos-anchor-placement="center-bottom">
                            <div class="col-md-6">
                                <ul
                                    class="border-bottom border-top list-group list-group-flush">
                                    <li class="list-group-item">
                                        @lang('Unlimited extensions')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('Customer support')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('All minutes = fixed')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('Choose your number')
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul
                                    class="border-bottom border-sm-top list-group list-group-flush">
                                    <li class="list-group-item">
                                        @lang('Conference call')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('Custom voice')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('Recording voice')
                                    </li>
                                    <li class="list-group-item">
                                        @lang('Recording voicemail to Email')
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a id="plan-buy" href="#"
                           class="btn btn-primary px-7 rounded-pill">
                            @lang('Buy now')
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- / End Plans Section -->
    </main>

    <footer class="footer overflow-hidden text-white">
        <div class="container">
            <h3 class="display-4 font-weight-bold mb-4 text-center">
                @lang('Contact Us')
            </h3>

            <form action="contactus" method="POST" class="mb-5"
                  data-aos="flip-up">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="sr-only">
                                        @lang('Full Name')
                                    </label>
                                    <input type="text"
                                           class="form-control w-100"
                                           name="name" id="name"
                                           placeholder="@lang('Full Name')"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="sr-only">
                                        @lang('E-mail')
                                    </label>
                                    <input type="email"
                                           class="form-control w-100"
                                           name="email" id="email"
                                           placeholder="@lang('E-mail')"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message" class="sr-only">
                                        @lang('Message')
                                    </label>
                                    <textarea class="form-control"
                                              name="message" id="message"
                                              rows="5"
                                              placeholder="@lang('Message')"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="text-center w-100">
                                <p class="d-none text-message"></p>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit"
                                        class="btn btn-primary font-weight-bold px-6">
                                    @lang('Submit')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <p class="border-top pt-2 text-center">
                <small>&copy; Fancy 2019</small>
            </p>
        </div>
    </footer>
</body>

</html>