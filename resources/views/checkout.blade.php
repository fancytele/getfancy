<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>GetFancy</title>

    <script src="https://js.stripe.com/v3/"></script>

    <!-- Scripts -->
    <script
        src="{{ asset('js/home.js') }}"
        defer
    ></script>

    <script
        src="{{ asset('js/stripe.js') }}"
        defer
    ></script>

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
    @include('partials.header')

    <main class="py-5">
        <section class="skew-section-primary"></section>

        <section
            id="checkout"
            class="pt-7"
        >
            <div class="container">
                <div class="border-4 card shadow">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-8 pt-3">
                                <form
                                    action=""
                                    id="payment-form"
                                >
                                    <div class="card-body">
                                        <div>
                                            <h2 class="display-4">
                                                Checkout
                                                <span
                                                    class="d-block d-lg-none h4 text-primary"
                                                >
                                                    {{ $plan->name }} -
                                                    ${{ $plan->cost }}
                                                </span>
                                            </h2>
                                        </div>

                                        <hr class="mx-n5">

                                        <!-- Create Account -->
                                        <div class="pt-4">
                                            <h3 class="ml-n2">
                                                <span
                                                    class="fa-stack text-primary"
                                                >
                                                    <i
                                                        class="far fa-circle fa-stack-2x"></i>
                                                    <span
                                                        class="fa-stack-1x">1</span>
                                                </span>
                                                Create Account
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
                                                        <label
                                                            for="verify_email"
                                                        >
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">
                                                            Password
                                                        </label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id="password"
                                                            name="password"
                                                            placeholder="********"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="repeat-password"
                                                        >
                                                            Verify Password
                                                        </label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id="repeat-password"
                                                            name="repeat-password"
                                                            placeholder="********"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mx-n5">

                                        <!-- Billing Information -->
                                        <div class="pt-4">
                                            <h3 class="ml-n2">
                                                <span
                                                    class="fa-stack text-primary"
                                                >
                                                    <i
                                                        class="far fa-circle fa-stack-2x"></i>
                                                    <span
                                                        class="fa-stack-1x">2</span>
                                                </span>
                                                Your Billing Information
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="country">
                                                            Country
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="country"
                                                            name="country"
                                                            placeholder="---"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city">
                                                            City
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="city"
                                                            name="city"
                                                            placeholder="---"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state">
                                                            State, Providence,
                                                            Region
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="state"
                                                            name="state"
                                                            placeholder="---"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="zip_code">
                                                            Zip Code
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="zip_code"
                                                            name="zip_code"
                                                            placeholder="---"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">
                                                            Address
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="address"
                                                            name="address"
                                                            placeholder="Street address, P.O. box, company name, c/o"
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Features -->
                                        <hr class="mx-n5">

                                        <div class="pt-4">
                                            <h3 class="ml-n2">
                                                <span
                                                    class="fa-stack text-primary"
                                                >
                                                    <i
                                                        class="far fa-circle fa-stack-2x"></i>
                                                    <span
                                                        class="fa-stack-1x">3</span>
                                                </span>
                                                Additional Features
                                            </h3>
                                            <div>
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="professional_recordings"
                                                        >
                                                        <label
                                                            class="custom-control-label"
                                                            for="professional_recordings"
                                                        >
                                                            Professional
                                                            Greeting/Custom
                                                            Recordings
                                                            <small
                                                                class="d-block text-black-50"
                                                            >
                                                                $8
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="multi_ring"
                                                        >
                                                        <label
                                                            class="custom-control-label"
                                                            for="multi_ring"
                                                        >
                                                            Multi-Ring
                                                            <small
                                                                class="d-block text-black-50"
                                                            >
                                                                $5
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="fraud_alert"
                                                        >
                                                        <label
                                                            class="custom-control-label"
                                                            for="fraud_alert"
                                                        >
                                                            Fraud Alert
                                                            <small
                                                                class="d-block text-black-50"
                                                            >
                                                                $5
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="call_blocker"
                                                        >
                                                        <label
                                                            class="custom-control-label"
                                                            for="call_blocker"
                                                        >
                                                            Call Blocker
                                                            <small
                                                                class="d-block text-black-50"
                                                            >
                                                                $5
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="additional_number"
                                                        >
                                                        <label
                                                            class="custom-control-label"
                                                            for="additional_number"
                                                        >
                                                            Additional
                                                            Numbers
                                                            <small
                                                                class="d-block text-black-50"
                                                            >
                                                                $5 (per number)
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mx-n5">

                                        <div class="pt-4">
                                            <h3 class="ml-n2">
                                                <span
                                                    class="fa-stack text-primary"
                                                >
                                                    <i
                                                        class="far fa-circle fa-stack-2x"></i>
                                                    <span
                                                        class="fa-stack-1x">4</span>
                                                </span>
                                                Your Payment Information
                                            </h3>
                                            <div>
                                                <div class="form-group">
                                                    <label for="credit-card">
                                                        Credict Card
                                                    </label>
                                                    <div id="stripe-card"></div>
                                                    <!-- Used to display form errors. -->
                                                    <div
                                                        id="card-errors"
                                                        class="invalid-feedback"
                                                        role="alert"
                                                    ></div>
                                                </div>
                                            </div>
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
                                        {{-- <h4 class="mb-4">{{ $plan->name }}
                                        </h4> --}}
                                        <div>
                                            <span
                                                class="align-top d-inline-block h2 mb-0 plan-price-sign"
                                            >$</span>
                                            <span
                                                class="d-inline-block display-1 font-weight-light mt-n3 plan-price-amount"
                                            >{{ $plan->cost }}</span>
                                            <span
                                                class="d-inline-block h3 mb-0 plan-price-time text-white"
                                            >
                                                / {{ $plan->slug }}
                                            </span>
                                        </div>
                                        <p class="font-italic mb-0">
                                            Automatically renews
                                        </p>
                                    </div>

                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <span class="mr-2">
                                                <i
                                                    class="far fa-check-circle"></i>
                                            </span>
                                            Unlimited extensions
                                        </li>
                                        <li class="mb-2">
                                            <span class="mr-2">
                                                <i
                                                    class="far fa-check-circle"></i>
                                            </span>
                                            Customer support
                                        </li>
                                        <li class="mb-2">
                                            <span class="mr-2">
                                                <i
                                                    class="far fa-check-circle"></i>
                                            </span>
                                            All minutes = fixed
                                        </li>
                                        <li class="mb-2">
                                            <span class="mr-2">
                                                <i
                                                    class="far fa-check-circle"></i>
                                            </span>
                                            Choose your number
                                        </li>
                                        <li class="mb-2">
                                            <span class="mr-2">
                                                <i
                                                    class="far fa-check-circle"></i>
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
                                                Like you, our mission is to
                                                connect
                                                people, therefore the needs of
                                                our
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
        </section>
    </main>
</body>

</html>