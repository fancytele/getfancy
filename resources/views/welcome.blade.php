<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>GetFancy</title>

    <!-- Scripts -->
    <script
        src="{{ asset('js/home.js') }}"
        defer
    ></script>

    <link
        rel="stylesheet"
        href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
    >

    <!-- Styles -->
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >
</head>

<body>
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
                        src="img/logo-light.png"
                        alt="Fancy Logo"
                    >
                    <img
                        class="getfancy-logo getfancy-dark-logo"
                        src="img/logo-primary.png"
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
            </div>
        </nav>
    </header>

    <main>
        <section
            id="home"
            class="hero text-white d-flex align-items-center"
            style="background-image: url(img/hero_blue.jpg)"
        >
            <div class="container">
                <div class="hero-content">
                    <h3 class="display-3">Virtual Phone System</h3>
                    <p>
                        GetFancy is a virtual phone system for startups and
                        small business
                    </p>
                    <ul class="list-unstyled pl-3">
                        <li class="mb-3">
                            <i
                                class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            Get a Toll Free, Local Phone Number.
                        </li>
                        <li class="mb-3">
                            <i
                                class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            Create Custom Greetings, Unlimited Extensions.
                        </li>
                        <li>
                            <i
                                class="align-bottom h1 la la-check-circle mb-0 mr-2 text-info"></i>
                            Get Voicemails by email, Manage Your Phone
                            System Online.
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section
            id="features"
            class="features bg-white-ghost"
        >
            <div class="container">
                <div class="row d-flex">
                    <div class="col-lg-6 ml-auto getfancy-section">
                        <h3 class="display-4 text-primary">Features</h3>
                        <p class="mb-5 text-blue-solid">
                            Make it easy to provide your business powerful phone
                            service.
                            No complex hardware to install or mantain. GetFancy
                            is simple to use
                            and manage, requiring no technical expertise
                        </p>
                        <div class="row d-flex">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Work Anywhere</h5>
                                <p>
                                    Plug in your existing phone anyhwere and it
                                    work just like
                                    at
                                    the office.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Relability</h5>
                                <p>
                                    Our proven 99.9% up-time and our system wide
                                    redundancy
                                    makes us
                                    the most reliable cloud phone service
                                    carrier in the nation.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">
                                    Management Tools
                                </h5>
                                <p>
                                    The management system allows you to change
                                    or add
                                    extensions,
                                    create call log reports, manage incoming and
                                    outgoing calls,
                                    record phone calls and much, mucho more.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Easy Setup</h5>
                                <p>
                                    No technical knowledge required! Our cloud
                                    phone systems are
                                    simple to install. Our support specialists
                                    are available to
                                    walk
                                    you through using customer dashboard if
                                    needed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="how-it-works"
            class="getfancy-section text-center"
        >
            <div class="container">
                <div class="mb-5 work-heading">
                    <h3 class="display-4 text-primary">How It Works</h3>
                    <p class="m-auto text-blue-solid">
                        GetFancy is an all-in-one virtual phone service
                        featuring
                        auto-attendant, professional greeting and a simple web
                        interface
                        that allows you to easyly manage all of your business
                        communications
                        without hardware.
                    </p>
                </div>
                <div class="row work-list">
                    <div class="col-md-4 mb-3">
                        <i
                            class="la la-mobile la-5x px-5 bg-lighter text-blue-solid"></i>
                        <div class="mt-4">
                            <h5 class="font-weight-bold">
                                Pick a number of your choice
                            </h5>
                            <p>
                                You can also port your number to GetFancy for
                                free.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i
                            class="la la-microphone la-5x px-5 bg-lighter text-blue-solid"></i>
                        <div class="mt-4">
                            <h5 class="font-weight-bold">
                                Record greetings or use recording service
                            </h5>
                            <p>
                                Create your custom main greeting for auto
                                attendant.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i
                            class="la la-headphones la-5x px-5 bg-lighter text-blue-solid"></i>
                        <div class="mt-4">
                            <h5 class="font-weight-bold">Add extensions</h5>
                            <p>
                                Create & customize extensions to forward call
                                anywhere, home, office or your mobile.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="testimonial"
            class="getfancy-section text-white"
        >
            <div class="container py-5">
                <blockquote class="blockquote mb-5 mt-4">
                    <p>
                        "GetFancy is amazing.
                        <br>
                        Decisions that used to take weeks, now only takes
                        minutes and is available to everyone on my team."
                    </p>
                    <footer class="blockquote-footer">
                        Cindy Smith, founder of Cool Starup
                    </footer>
                </blockquote>
            </div>
        </section>

        <section
            id="plans"
            class="getfancy-section text-center"
        >
            <h3 class="display-4 mb-5 text-primary">Our Plans</h3>

            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-5 plan-item">
                        <h5 class="font-weight-normal text-uppercase">Starter
                        </h5>
                        <div class="plan-price text-primary">
                            <span
                                class="font-weight-bold h4 mr-n1 plan-price-sign"
                            >$</span>
                            <span
                                class="font-weight-bold h1 plan-price-amount">14.95</span>
                            <span
                                class="plan-price-time small text-black-50">/mon</span>
                        </div>
                        <ul
                            class="list-group list-group-flush mb-3 mt-4 text-left">
                            <li class="list-group-item">
                                <span class="font-weight-bold">90k</span>
                                monthly requests
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">8am-5pm</span>
                                technical support
                            </li>
                            <li class="border-bottom list-group-item">
                                <span class="font-weight-bold">Public</span> API
                                access
                            </li>
                        </ul>
                        <a
                            href="{{ route('checkout') }}"
                            class="btn btn-block btn-primary py-2"
                        >
                            Start a personal account
                        </a>
                    </div>

                    <div class="col-md-4 mb-5 plan-item">
                        <h5 class="font-weight-normal text-uppercase">Basic</h5>
                        <div class="plan-price text-primary">
                            <span
                                class="font-weight-bold h4 mr-n1 plan-price-sign"
                            >$</span>
                            <span
                                class="font-weight-bold h1 plan-price-amount">19.95</span>
                            <span
                                class="plan-price-time small text-black-50">/mon</span>
                        </div>
                        <ul
                            class="list-group list-group-flush mb-3 mt-4 text-left">
                            <li class="list-group-item">
                                <span class="font-weight-bold">100k</span>
                                monthly requests
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">24/7</span>
                                technical support
                            </li>
                            <li class="border-bottom list-group-item">
                                <span class="font-weight-bold">Public</span> API
                                access
                            </li>
                        </ul>
                        <a
                            href="{{ route('checkout') }}"
                            class="btn btn-block btn-primary py-2"
                        >
                            Start a personal account
                        </a>
                    </div>

                    <div class="col-md-4 mb-5 plan-item">
                        <h5 class="font-weight-normal text-uppercase">Pro</h5>
                        <div class="plan-price text-primary">
                            <span
                                class="font-weight-bold h4 mr-n1 plan-price-sign"
                            >$</span>
                            <span
                                class="font-weight-bold h1 plan-price-amount">27.95</span>
                            <span
                                class="plan-price-time small text-black-50">/mon</span>
                        </div>
                        <ul
                            class="list-group list-group-flush mb-3 mt-4 text-left">
                            <li class="list-group-item">
                                <span class="font-weight-bold">Unlimited</span>
                                monthly requests
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">24/7</span>
                                technical support
                            </li>
                            <li class="border-bottom list-group-item">
                                <span class="font-weight-bold">Public</span> API
                                access
                            </li>
                        </ul>
                        <a
                            href="{{ route('checkout') }}"
                            class="btn btn-block btn-primary py-2"
                        >
                            Start a personal account
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer text-white">
        <div class="container">
            <h3 class="display-4 font-weight-bold mb-4 text-center">
                Contact Us
            </h3>

            <form
                action=""
                method="POST"
                class="mb-5"
            >
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        for="full_name"
                                        class="sr-only"
                                    >Full Name</label>
                                    <input
                                        type="text"
                                        class="form-control w-100"
                                        name="full_name"
                                        id="full_name"
                                        placeholder="Full Name"
                                        required
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        for="email"
                                        class="sr-only"
                                    >E-mail</label>
                                    <input
                                        type="email"
                                        class="form-control w-100"
                                        name="email"
                                        id="email"
                                        placeholder="E-mail"
                                        required
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label
                                        for="message"
                                        class="sr-only"
                                    >Message</label>
                                    <textarea
                                        class="form-control"
                                        name="message"
                                        id="message"
                                        rows="5"
                                        placeholder="Mesage"
                                        required
                                    ></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button
                                    type="submit"
                                    class="btn btn-primary font-weight-bold px-6"
                                >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <p class="border-top pt-2 text-center">
                <small>&copy; GetFancy 2019</small>
            </p>
        </div>
    </footer>
</body>

</html>