<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @lang('Login')</title>

    <!-- Links -->
    <script src="{{ asset('js/login.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body
      class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">
                <div class="text-center">
                    <a href="{{ route('web.homepage') }}">
                        <img class="w-50"
                             src="{{ asset('img/logo-light-big.png') }}"
                             alt="Fancy Logo Light">
                    </a>
                </div>

                <p class="text-muted text-center mb-5">
                    @lang('Access to your dashboard').
                </p>

                <!-- Form -->
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <!-- Email address -->
                    <div class="form-group">

                        <!-- Label -->
                        <label for="email">@lang('E-mail')</label>

                        <!-- Input -->
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="john@doe.com" autocomplete="email"
                               value="{{ old('email') }}" required autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">

                        <div class="row">
                            <div class="col">

                                <!-- Label -->
                                <label for="password">@lang('Password')</label>

                            </div>
                            <div class="col-auto">

                                <!-- Help text -->
                                @if (Route::has('password.request'))
                                <a href="{{ route('web.homepage') }}"
                                   class="form-text small text-muted">
                                    @lang('Forgot Your Password?')
                                </a>
                                @endif
                            </div>
                        </div> <!-- / .row -->

                        <!-- Input -->
                        <input type="password" id="password" name="password"
                               class="form-control form-control-appended @error('password') is-invalid @enderror"
                               placeholder="@lang('Enter your password')"
                               required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="btn btn-lg btn-block btn-primary ladda-button js-ladda-submit mb-3"
                            data-style="zoom-out">
                        <span class="ladda-label">@lang('Login')</span>
                    </button>

                    <!-- Link -->
                    <p class="text-center">
                        <small class="text-muted text-center">
                            @lang('Don\'t have an account yet?') <a
                               href="{{ route('web.checkout', 'annually') }}">
                                @lang('Checkout here')</a>.
                        </small>
                    </p>

                </form>
            </div>
        </div> <!-- / .row -->
    </div>
</body>

</html>