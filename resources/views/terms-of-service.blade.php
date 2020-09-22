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
          <h2>Hyper Telecom LLC Terms of Service</h2>
          <h3>1. Terms</h3>
          <p>By accessing the website at <a href="http://fancyy.co">http://fancyy.co</a>, you are agreeing to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this website are protected by applicable copyright and trademark law.</p>
          <h3>2. Use License</h3>
          <ol type="a">
              <li>Permission is granted to temporarily download one copy of the materials (information or software) on Hyper Telecom LLC's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                  <ol type="i">
                      <li>modify or copy the materials;</li>
                      <li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
                      <li>attempt to decompile or reverse engineer any software contained on Hyper Telecom LLC's website;</li>
                      <li>remove any copyright or other proprietary notations from the materials; or</li>
                      <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                  </ol>
              </li>
              <li>This license shall automatically terminate if you violate any of these restrictions and may be terminated by Hyper Telecom LLC at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.</li>
          </ol>
          <h3>3. Disclaimer</h3>
          <ol type="a">
              <li>The materials on Hyper Telecom LLC's website are provided on an 'as is' basis. Hyper Telecom LLC makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</li>
              <li>Further, Hyper Telecom LLC does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its website or otherwise relating to such materials or on any sites linked to this site.</li>
          </ol>
          <h3>4. Limitations</h3>
          <p>In no event shall Hyper Telecom LLC or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Hyper Telecom LLC's website, even if Hyper Telecom LLC or a Hyper Telecom LLC authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.</p>
          <h3>5. Accuracy of materials</h3>
          <p>The materials appearing on Hyper Telecom LLC's website could include technical, typographical, or photographic errors. Hyper Telecom LLC does not warrant that any of the materials on its website are accurate, complete or current. Hyper Telecom LLC may make changes to the materials contained on its website at any time without notice. However Hyper Telecom LLC does not make any commitment to update the materials.</p>
          <h3>6. Links</h3>
          <p>Hyper Telecom LLC has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Hyper Telecom LLC of the site. Use of any such linked website is at the user's own risk.</p>
          <h3>7. Modifications</h3>
          <p>Hyper Telecom LLC may revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.</p>
          <h3>8. Governing Law</h3>
          <p>These terms and conditions are governed by and construed in accordance with the laws of Miami and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.</p>

      </div>
    </main>
    <!--main -->
</div>
</body>

</html>