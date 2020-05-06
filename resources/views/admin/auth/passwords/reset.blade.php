<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @lang('Reset Password')</title>

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

                <div class="mb-5 text-center">
                    <img class="w-50"
                            src="{{ asset('img/logo-primary.png') }}"
                            alt="Fancy Logo">
                </div>

                <!-- Heading -->
                <h1 class="display-4 text-center mb-5">
                    @lang('Set a Password')
                </h1>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email address -->
                    <div class="form-group">
                        <label for="email">@lang('E-mail')</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ $email ?? old('email') }}"
                               autocomplete="email" required readonly>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                            This email is not in our database. Please 
                            <a class="text-danger text-decoration-underline" href="mailto:{{ config('fancy.email') }}">contact support</a> 
                            if you think this is an error.
                            </strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">@lang('Password')</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required
                               autofocus>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">@lang('Confirm
                            Password')</label>
                        <input type="password" id="password-confirm"
                               name="password_confirmation" class="form-control"
                               required>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-lg btn-block btn-primary ladda-button js-ladda-submit mb-3"
                            data-style="zoom-out">
                        @lang('Submit')
                    </button>
                </form>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</body>

</html>
