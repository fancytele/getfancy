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

    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">

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
                         src="{{ URL::asset('img/Fancyy_Logo-06.png') }}"
                         alt="Fancy Logo">
                    <img class="fancy-logo fancy-dark-logo"
                         src="{{ URL::asset('img/Fancyy_Logo-02.png') }}"
                         alt="Fancy Logo">
                </a>
                <div class="collapse navbar-collapse flex-column align-items-end"
                     id="fancy-menu">
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-md-flex d-none mb-3 small locale">
                        @if(App::isLocale('en'))
                            <span class="text-body">English</span>
                        @else
                            <a class="text-muted" href="{{ route('web.locale', 'en') }}">
                                English
                            </a>
                        @endif
                        <span class="px-3">|</span>
                        @if(App::isLocale('es'))
                            <span class="text-body">Español</span>
                        @else
                            <a class="text-muted" href="{{ route('web.locale', 'es') }}">
                                Español
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- / Header -->

    <!--main -->
    <main>
      <div>
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
    </main>
    <!--main -->
</div>
</body>

</html>