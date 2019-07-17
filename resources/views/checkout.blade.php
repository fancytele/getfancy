<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>GetFancy</title>

    <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
        crossorigin="anonymous"
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
            class="navbar navbar-light navbar-expand-md"
        >
            <div class="container">
                <a
                    class="font-weight-bold navbar-brand pl-3 py-4 text-uppercase"
                    href="{{ url('/') }}"
                >
                    <span class="getfancy-logo">
                        GetFancy
                    </span>
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
                    class="collapse h5 mb-0 navbar-collapse"
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

    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 pt-3">
                            <form action="">
                                <div class="card-body">
                                    <div>
                                        <h2 class="display-4">
                                            Checkout
                                            <small class="d-block d-lg-none h5 text-primary">
                                                Standard Plan ($
                                                <span
                                                    class="h4">99</span>
                                                /year)
                                            </small>
                                        </h2>
                                    </div>

                                    <hr class="mx-n5">

                                    <div class="pt-4">
                                        <h3 class="ml-n2">
                                            <span class="fa-stack text-primary">
                                                <i
                                                    class="far fa-circle fa-stack-2x"></i>
                                                <span
                                                    class="fa-stack-1x">1</span>
                                            </span>
                                            Your Basic Information
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name">
                                                        First Name
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="first_name"
                                                        name="first_name"
                                                        placeholder="John"
                                                        required
                                                        autofocus
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">
                                                        Last Name
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="last_name"
                                                        name="last_name"
                                                        placeholder="Doe"
                                                        required
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">
                                                        E-mail
                                                    </label>
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="email"
                                                        name="email"
                                                        placeholder="johndoe@example.com"
                                                        required
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="verify_email">
                                                        Verify E-mail
                                                    </label>
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="verify_email"
                                                        name="verify_email"
                                                        placeholder="johndoe@example.com"
                                                        required
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="mx-n5">

                                    <div class="pt-4">
                                        <h3 class="ml-n2">
                                            <span class="fa-stack text-primary">
                                                <i
                                                    class="far fa-circle fa-stack-2x"></i>
                                                <span
                                                    class="fa-stack-1x">2</span>
                                            </span>
                                            Your Payment Information
                                        </h3>
                                    </div>

                                    <hr class="mx-n5">

                                    <div class="pt-4">
                                        <button
                                            type="submit"
                                            class="btn btn-block btn-lg btn-primary font-weight-bold py-3"
                                        >
                                            Checkout
                                        </button>
                                        <p class="mt-4 text-center">
                                            <span
                                                class="align-middle h2 mb-0 text-primary"
                                            >
                                                <i
                                                    class="fa-question-circle far"></i>
                                            </span>
                                            <span class="font-weight-bold">
                                                Need any help?
                                            </span>
                                            Don't hesitate to
                                            <a
                                                href="mailto:info@getfancy.co"
                                                class="text-body text-decoration-underline"
                                            >
                                                contact support!
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div
                            class="bg-primary col-lg-4 d-none d-lg-block pt-4 rounded-right text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <h4 class="mb-4">Standard Plan</h4>
                                    <div>
                                        <span
                                            class="align-top d-inline-block h2 mb-0 plan-price-sign"
                                        >$</span>
                                        <span
                                            class="d-inline-block display-1 font-weight-light mt-n3 plan-price-amount"
                                        >99</span>
                                        <span
                                            class="d-inline-block h3 mb-0 plan-price-time text-white"
                                        >
                                            / year
                                        </span>
                                    </div>
                                    <p class="font-italic mb-0">
                                        Automatically renews after 1 year
                                    </p>
                                </div>

                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                        Unlimited extensions
                                    </li>
                                    <li class="mb-2">
                                        <span class="mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                        Customer support
                                    </li>
                                    <li class="mb-2">
                                        <span class="mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                        All minutes = fixed
                                    </li>
                                    <li class="mb-2">
                                        <span class="mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                        Choose your number
                                    </li>
                                    <li class="mb-2">
                                        <span class="mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                        Conference call
                                    </li>
                                </ul>

                                <div class="mt-5">
                                    <p
                                        class="border-bottom border-bottom-5 border-info d-inline-block mb-0">
                                        Need
                                        <span class="font-weight-bold">
                                            Custom Voice Recording?
                                        </span>
                                    </p>
                                    <p>
                                        Switch to the
                                        <a
                                            href="{{ route('checkout', 'annually') }}"
                                            class="font-italic text-decoration-underline text-white"
                                        >Enterprise</a>
                                        plan.
                                    </p>
                                </div>

                                <hr class="border-white-50">

                                <div class="mt-6">
                                    <blockquote
                                        class="blockquote blockquote-fancy"
                                    >
                                        <p class="font-italic">
                                            Like you, our mission is to connect
                                            people, therefore the needs of our
                                            clients come first.
                                        </p>
                                        <footer
                                            class="blockquote-footer font-weight-bold text-white"
                                        >
                                            <img
                                                class="mr-3 rounded-circle w-15"
                                                src="https://media.licdn.com/dms/image/C5103AQGWZc65_HDAOQ/profile-displayphoto-shrink_800_800/0?e=1568246400&v=beta&t=hpibmKZIeORLRXDltT5pp196r-q2IR9Bd-8EJ25gDj8"
                                                alt="Johnny Bosche"
                                            >
                                            Johnny Bosche
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>