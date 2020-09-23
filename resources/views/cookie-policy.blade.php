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
    <script src="{{ asset(mix('js/home.js')) }}" defer></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('css/web.css')) }}" rel="stylesheet">

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
                        <a class="font-weight-bold text-body" href="{{ route('web.homepage') }}">
                            @lang('Home')
                        </a>
                    </li>
                    &nbsp;&nbsp;
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
                <div class="col-md-12">

                    <h2>Cookie Policy</h2>
                    <p>We use cookies to help improve your experience of <a href="http://fancyy.co">http://fancyy.co</a>. This cookie policy is part of Hyper Telecom LLC's privacy policy, and covers the use of cookies between your device and our site. We also provide basic information on third-party services we may use, who may also use cookies as part of their service, though they are not covered by our policy.</p>
                    <p>If you don’t wish to accept cookies from us, you should instruct your browser to refuse cookies from <a href="http://fancyy.co">http://fancyy.co</a>, with the understanding that we may be unable to provide you with some of your desired content and services.</p>
                    <h3>What is a cookie?</h3>
                    <p>A cookie is a small piece of data that a website stores on your device when you visit, typically containing information about the website itself, a unique identifier that allows the site to recognize your web browser when you return, additional data that serves the purpose of the cookie, and the lifespan of the cookie itself.</p>
                    <p>Cookies are used to enable certain features (eg. logging in), to track site usage (eg. analytics), to store your user settings (eg. timezone, notification preferences), and to personalize your content (eg. advertising, language).</p>
                    <p>Cookies set by the website you are visiting are normally referred to as “first-party cookies”, and typically only track your activity on that particular site. Cookies set by other sites and companies (ie. third parties) are called “third-party cookies”, and can be used to track you on other websites that use the same third-party service.</p>
                    <h3>Types of cookies and how we use them</h3>
                    <h4>Essential cookies</h4>
                    <p>Essential cookies are crucial to your experience of a website, enabling core features like user logins, account management, shopping carts and payment processing. We use essential cookies to enable certain functions on our website.</p>
                    <h4>Performance cookies</h4>
                    <p>Performance cookies are used in the tracking of how you use a website during your visit, without collecting personal information about you. Typically, this information is anonymous and aggregated with information tracked across all site users, to help companies understand visitor usage patterns, identify and diagnose problems or errors their users may encounter, and make better strategic decisions in improving their audience’s overall website experience. These cookies may be set by the website you’re visiting (first-party) or by third-party services. We use performance cookies on our site.</p>
                    <h4>Functionality cookies</h4>
                    <p>Functionality cookies are used in collecting information about your device and any settings you may configure on the website you’re visiting (like language and time zone settings). With this information, websites can provide you with customized, enhanced or optimized content and services. These cookies may be set by the website you’re visiting (first-party) or by third-party service. We use functionality cookies for selected features on our site.</p>
                    <h4>Targeting/advertising cookies</h4>
                    <p>Targeting/advertising cookies are used in determining what promotional content is more relevant and appropriate to you and your interests. Websites may use them to deliver targeted advertising or to limit the number of times you see an advertisement. This helps companies improve the effectiveness of their campaigns and the quality of content presented to you. These cookies may be set by the website you’re visiting (first-party) or by third-party services. Targeting/advertising cookies set by third-parties may be used to track you on other websites that use the same third-party service. We use targeting/advertising cookies on our site.</p>
                    <h3>Third-party cookies on our site</h3>
                    <p>We may employ third-party companies and individuals on our websites—for example, analytics providers and content partners. We grant these third parties access to selected information to perform specific tasks on our behalf. They may also set third-party cookies in order to deliver the services they are providing. Third-party cookies can be used to track you on other websites that use the same third-party service. As we have no control over third-party cookies, they are not covered by Hyper Telecom LLC's cookie policy.</p>
                    <h4>Our third-party privacy promise</h4>
                    <p>We review the privacy policies of all our third-party providers before enlisting their services to ensure their practices align with ours. We will never knowingly include third-party services that compromise or violate the privacy of our users.</p>
                    <h3>How you can control or opt out of cookies</h3>
                    <p>If you do not wish to accept cookies from us, you can instruct your browser to refuse cookies from our website. Most browsers are configured to accept cookies by default, but you can update these settings to either refuse cookies altogether, or to notify you when a website is trying to set or update a cookie.</p>
                    <p>If you browse websites from multiple devices, you may need to update your settings on each individual device.</p>
                    <p>Although some cookies can be blocked with little impact on your experience of a website, blocking all cookies may mean you are unable to access certain features and content across the sites you visit.</p>

                </div>
            </div>
        </div>
    </section>
    <!-- / Hero Section -->

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
</body>

</html>