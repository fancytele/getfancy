<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GetFancy</title>

    <!-- Scripts -->
    <script src="{{ asset('js/home.js') }}" defer></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet"
          href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    @include('partials.header', ['show_nav' => true])

    <main class="overflow-hidden">
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
                        <i
                           class="la la-mobile la-5x px-5 bg-lighter text-blue-solid"></i>
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
                                @lang('Record greetings or use recording
                                service')
                            </h5>
                            <p>@lang('Record greetings Message')</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up"
                         data-aos-anchor-placement="center-bottom">
                        <i
                           class="la la-headphones la-5x px-5 bg-lighter text-blue-solid"></i>
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

        <section id="testimonial" class="fancy-section text-white">
            <div class="container py-5">
                <blockquote class="blockquote mb-5 mt-4">
                    <p>@lang('Testimony Message')</p>
                    <footer class="blockquote-footer">
                        @lang('Testimony Footer')
                    </footer>
                </blockquote>
            </div>
        </section>

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
                                </span>
                                @endforeach
                            </h2>

                            <div class="btn-group" role="group"
                                 aria-label="Our Plans Button Groups">
                                @foreach ($products as $product)
                                <button type="button"
                                        class="btn btn-outline-light{{ $product->is_primary ? ' active' : '' }}"
                                        data-type="{{ $product->slug }}">{{ $product->name }}</button>
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
                           class="btn btn-primary px-7">@lang('Buy now')</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer overflow-hidden text-white">
        <div class="container">
            <h3 class="display-4 font-weight-bold mb-4 text-center">
                @lang('Contact Us')
            </h3>

            <form action="" method="POST" class="mb-5" data-aos="flip-up">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name" class="sr-only">
                                        @lang('Full Name')
                                    </label>
                                    <input type="text"
                                           class="form-control w-100"
                                           name="full_name" id="full_name"
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