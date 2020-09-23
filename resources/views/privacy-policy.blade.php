
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
                    <h2>Privacy Policy</h2>
                    <p>Your privacy is important to us. It is Hyper Telecom LLC's policy to respect your privacy regarding any information we may collect from you across our website, <a href="http://fancyy.co">http://fancyy.co</a>, and other sites we own and operate.</p>
                    <h3>1. Information we collect</h3>
                    <h4>Log data</h4>
                    <p>When you visit our website, our servers may automatically log the standard data provided by your web browser. It may include your computer’s Internet Protocol (IP) address, your browser type and version, the pages you visit, the time and date of your visit, the time spent on each page, and other details.</p>
                    <h4>Device data</h4>
                    <p>We may also collect data about the device you’re using to access our website. This data may include the device type, operating system, unique device identifiers, device settings, and geo-location data. What we collect can depend on the individual settings of your device and software. We recommend checking the policies of your device manufacturer or software provider to learn what information they make available to us.</p>
                    <h4>Personal information</h4>
                    <p>We may ask for personal information, such as your:</p>
                    <ul>
                        <li>Name</li>
                        <li>Email</li>
                        <li>Social media profiles</li>
                        <li>Date of birth</li>
                        <li>Phone/mobile number</li>
                        <li>Home/Mailing address</li>
                        <li>Work address</li>
                        <li>Payment information</li>
                    </ul>
                    <h3>2. Legal bases for processing</h3>
                    <p>We will process your personal information lawfully, fairly and in a transparent manner. We collect and process information about you only where we have legal bases for doing so.</p>
                    <p>These legal bases depend on the services you use and how you use them, meaning we collect and use your information only where:</p>
                    <ul>
                        <li>it’s necessary for the performance of a contract to which you are a party or to take steps at your request before entering into such a contract (for example, when we provide a service you request from us);</li>
                        <li>it satisfies a legitimate interest (which is not overridden by your data protection interests), such as for research and development, to market and promote our services, and to protect our legal rights and interests;</li>
                        <li>you give us consent to do so for a specific purpose (for example, you might consent to us sending you our newsletter); or</li>
                        <li>we need to process your data to comply with a legal obligation.</li>
                    </ul>
                    <p>Where you consent to our use of information about you for a specific purpose, you have the right to change your mind at any time (but this will not affect any processing that has already taken place).</p>
                    <p>We don’t keep personal information for longer than is necessary. While we retain this information, we will protect it within commercially acceptable means to prevent loss and theft, as well as unauthorized access, disclosure, copying, use or modification. That said, we advise that no method of electronic transmission or storage is 100% secure and cannot guarantee absolute data security. If necessary, we may retain your personal information for our compliance with a legal obligation or in order to protect your vital interests or the vital interests of another natural person.</p>
                    <h3>3. Collection and use of information</h3>
                    <p>We may collect, hold, use and disclose information for the following purposes and personal information will not be further processed in a manner that is incompatible with these purposes:</p>
                    <ul>
                        <li>to enable you to customize or personalize your experience of our website;</li>
                        <li>to enable you to access and use our website, associated applications and associated social media platforms;</li>
                        <li>to contact and communicate with you;</li>
                        <li>for internal record keeping and administrative purposes;</li>
                        <li>for analytics, market research and business development, including to operate and improve our website, associated applications and associated social media platforms;</li>
                        <li>to run competitions and/or offer additional benefits to you;</li>
                        <li>for advertising and marketing, including to send you promotional information about our products and services and information about third parties that we consider may be of interest to you;</li>
                        <li>to comply with our legal obligations and resolve any disputes that we may have; and</li>
                        <li>to consider your employment application.</li>
                    </ul>
                    <h3>4. Disclosure of personal information to third parties</h3>
                    <p>We may disclose personal information to:</p>
                    <ul>
                        <li>third party service providers for the purpose of enabling them to provide their services, including (without limitation) IT service providers, data storage, hosting and server providers, ad networks, analytics, error loggers, debt collectors, maintenance or problem-solving providers, marketing or advertising providers, professional advisors and payment systems operators;</li>
                        <li>our employees, contractors and/or related entities;</li>
                        <li>sponsors or promoters of any competition we run;</li>
                        <li>credit reporting agencies, courts, tribunals and regulatory authorities, in the event you fail to pay for goods or services we have provided to you;</li>
                        <li>courts, tribunals, regulatory authorities and law enforcement officers, as required by law, in connection with any actual or prospective legal proceedings, or in order to establish, exercise or defend our legal rights;</li>
                        <li>third parties, including agents or sub-contractors, who assist us in providing information, products, services or direct marketing to you; and</li>
                        <li>third parties to collect and process data.</li>
                    </ul>
                    <h3>5. International transfers of personal information</h3>
                    <p>The personal information we collect is stored and processed in United States, or where we or our partners, affiliates and third-party providers maintain facilities. By providing us with your personal information, you consent to the disclosure to these overseas third parties.</p>
                    <p>We will ensure that any transfer of personal information from countries in the European Economic Area (EEA) to countries outside the EEA will be protected by appropriate safeguards, for example by using standard data protection clauses approved by the European Commission, or the use of binding corporate rules or other legally accepted means.</p>
                    <p>Where we transfer personal information from a non-EEA country to another country, you acknowledge that third parties in other jurisdictions may not be subject to similar data protection laws to the ones in our jurisdiction. There are risks if any such third party engages in any act or practice that would contravene the data privacy laws in our jurisdiction and this might mean that you will not be able to seek redress under our jurisdiction’s privacy laws.</p>
                    <h3>6. Your rights and controlling your personal information</h3>
                    <p><strong>Choice and consent:</strong> By providing personal information to us, you consent to us collecting, holding, using and disclosing your personal information in accordance with this privacy policy. If you are under 16 years of age, you must have, and warrant to the extent permitted by law to us, that you have your parent or legal guardian’s permission to access and use the website and they (your parents or guardian) have consented to you providing us with your personal information. You do not have to provide personal information to us, however, if you do not, it may affect your use of this website or the products and/or services offered on or through it.</p>
                    <p><strong>Information from third parties:</strong> If we receive personal information about you from a third party, we will protect it as set out in this privacy policy. If you are a third party providing personal information about somebody else, you represent and warrant that you have such person’s consent to provide the personal information to us.</p>
                    <p><strong>Restrict:</strong> You may choose to restrict the collection or use of your personal information. If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by contacting us using the details below. If you ask us to restrict or limit how we process your personal information, we will let you know how the restriction affects your use of our website or products and services.</p>
                    <p><strong>Access and data portability:</strong> You may request details of the personal information that we hold about you. You may request a copy of the personal information we hold about you. Where possible, we will provide this information in CSV format or other easily readable machine format. You may request that we erase the personal information we hold about you at any time. You may also request that we transfer this personal information to another third party.</p>
                    <p><strong>Correction:</strong> If you believe that any information we hold about you is inaccurate, out of date, incomplete, irrelevant or misleading, please contact us using the details below. We will take reasonable steps to correct any information found to be inaccurate, incomplete, misleading or out of date.</p>
                    <p><strong>Notification of data breaches:</strong> We will comply laws applicable to us in respect of any data breach.</p>
                    <p><strong>Complaints:</strong> If you believe that we have breached a relevant data protection law and wish to make a complaint, please contact us using the details below and provide us with full details of the alleged breach. We will promptly investigate your complaint and respond to you, in writing, setting out the outcome of our investigation and the steps we will take to deal with your complaint. You also have the right to contact a regulatory body or data protection authority in relation to your complaint.</p>
                    <p><strong>Unsubscribe:</strong> To unsubscribe from our e-mail database or opt-out of communications (including marketing communications), please contact us using the details below or opt-out using the opt-out facilities provided in the communication.</p>
                    <h3>7. Cookies</h3>
                    <p>We use “cookies” to collect information about you and your activity across our site. A cookie is a small piece of data that our website stores on your computer, and accesses each time you visit, so we can understand how you use our site. This helps us serve you content based on preferences you have specified. Please refer to our Cookie Policy for more information.</p>
                    <h3>8. Business transfers</h3>
                    <p>If we or our assets are acquired, or in the unlikely event that we go out of business or enter bankruptcy, we would include data among the assets transferred to any parties who acquire us. You acknowledge that such transfers may occur, and that any parties who acquire us may continue to use your personal information according to this policy.</p>
                    <h3>9. Limits of our policy</h3>
                    <p>Our website may link to external sites that are not operated by us. Please be aware that we have no control over the content and policies of those sites, and cannot accept responsibility or liability for their respective privacy practices.</p>
                    <h3>10. Changes to this policy</h3>
                    <p>At our discretion, we may change our privacy policy to reflect current acceptable practices. We will take reasonable steps to let users know about changes via our website. Your continued use of this site after any changes to this policy will be regarded as acceptance of our practices around privacy and personal information. </p>
                    <p>If we make a significant change to this privacy policy, for example changing a lawful basis on which we process your personal information, we will ask you to re-consent to the amended privacy policy.</p>
                    <p><strong>Hyper Telecom LLC Data Controller</strong><br />
                        Johnny Bosche<br />
                        jbosche@hyper-tele.com</p>
                    <p>This policy is effective as of October 1, 2020.</p>
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