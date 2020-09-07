<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @lang('Login')</title>

    <!-- Links -->
    <script src="{{ asset(mix('js/login.js')) }}"></script>

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>

<body
      class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
    <div class="container">
        <div class="row justify-content-center">
            <span class="col-12 col-md-5 col-xl-4 my-5">
                <div class="text-center">
                    <a href="{{ route('web.homepage') }}">
                        <img class="w-50"
                             src="{{ asset('img/Fancyy_Logo-02.png') }}"
                             alt="Fancy Logo">
                    </a>
                </div>

                <p class="text-muted text-center mb-5">
                    @lang('Access to your dashboard').
                </p>

                <!-- Form -->
                <form class="bg-primary px-5 py-4 rounded-sm shadow text-white" method="POST" action="{{ route('admin.login') }}">
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

                         <span id="emailError" class="invalid-feedback" style="display: block" role="alert"></span>

                         @if(session()->has('otpExpiredErrorMessage'))
                            <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('otpExpiredErrorMessage') }}</strong></span>
                        @endif


                        @if(session()->has('credentialErrorMessage'))
                            <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('credentialErrorMessage') }}</strong></span>
                        @endif


                        @error('email')
                        <span id="error" class="invalid-feedback" role="alert">
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
                        <span id= "error" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                         <span id="passwordError" class="invalid-feedback" style="display: block" role="alert"></span>
                    </div>


                        <!-- OTP -->
                        <div id="otp" class="form-group">

                            <div class="row">
                                <div class="col">

                                    <!-- Label -->
                                    <label for="otp">@lang('OTP')</label> <?php //TODO: ADD TO LANGUAGE FILE ?>

                                </div>
                            </div> <!-- / .row -->

                            <!-- Input -->
                            <input type="number" name="otp"
                                   class="form-control form-control-appended @error('otp') is-invalid @enderror"
                                   placeholder="@lang('Enter your OTP')" required>

                            @error('otp')
                            <span id="error" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror

                            @if(session()->has('otpErrorMessage'))
                                <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('otpErrorMessage') }}</strong></span>
                            @endif

                        </div>

                        <div id="otpSuccessMessage">
                            <span style="display: block"></span>
                        </div>
                    <!-- Submit -->
                    <button type="submit" id="submit-button"
                            class="btn btn-lg btn-block btn-info ladda-button js-ladda-submit mb-3"
                            data-style="zoom-out">
                        <span class="ladda-label">@lang('Login')</span>
                    </button>

                        <button id="login-otp-button" onclick="return getOtp()"
                                class="btn btn-lg btn-block btn-info ladda-button mb-3"
                                data-style="zoom-out">
                            <span class="ladda-label">@lang('Login')</span>
                        </button>
                    <!-- Link -->
                    <p class="text-center">
                        <small>
                            @lang('Don\'t have an account yet?') 
                            <a class="text-decoration-underline text-white" href="{{ route('web.checkout', 'annually') }}">
                                @lang('Sign Up Here')</a>.
                        </small>
                    </p>
                </form>
            </div>
        </div> <!-- / .row -->
    </div>

<script>
    function getOtp()
    {
      var l = Ladda.create(document.getElementById('login-otp-button'));
      l.start();
      var x = new XMLHttpRequest();
      x.open("POST", "{{ route('admin.login.sendOtp') }}", true);
      x.setRequestHeader("Content-type", "application/json");
      var sendData = { email: document.getElementById('email').value , password: document.getElementById('password').value};
      if(!sendData.email)
      {
        document.getElementById('emailError').innerHTML = '<strong>Please provide some input</strong>';
      }

      if(!sendData.password)
      {
        document.getElementById('passwordError').innerHTML = '<strong>Please provide some input</strong>';
      }

        x.send(JSON.stringify(sendData));

        //---- changed the onreadystatechange with onloadend
        //---- since i dont have anything to do on of the previous states then 4th one
        x.onloadend = function() {
          if (x.readyState === 4 && x.status === 200) {
            l.stop();
            document.getElementById('emailError').innerHTML = '';
            document.getElementById('passwordError').innerHTML = '';
            document.getElementById('otpSuccessMessage').innerHTML= '<strong>@lang('OTP has been sent to your email')</strong>';
            document.getElementById('otp').style.display = "block";
            document.getElementById('submit-button').style.display = "block";
            document.getElementById('login-otp-button').style.display = "none";
          }
          else if(x.status === 401)
          {
            l.stop();
           if(!document.getElementById('password').value){
             document.getElementById('passwordError').innerHTML = '<strong>Please provide some input</strong>';
             document.getElementById('emailError').innerHTML = '';
           }
           else{
             document.getElementById('passwordError').innerHTML = '';
             document.getElementById('emailError').innerHTML = '<strong>These credentials do not match our records.</strong>';
           }
            document.getElementById('otp').style.display ="none";
            document.getElementById('submit-button').style.display ="none";
          }
          else
          {
            l.stop();
            document.getElementById('otp').style.display ="none";
            document.getElementById('submit-button').style.display ="none";
          }
        }
        return false;


    }
</script>

    <style>
        @if(session()->has('credentialErrorMessage') OR session()->has('otpErrorMessage'))
            #otp{
                display: block;
            }

            #submit-button{
                display: block;
            }

            #login-otp-button{
                display: none;
            }

        @elseif(session()->has('otpExpiredErrorMessage'))
                #otp{
                    display: none;
                }

                #submit-button{
                    display: none;
                }

                #login-otp-button{
                    display: block;
                }

            @else
                #otp{
                    display: none;
                }

                #submit-button{
                    display: none;
                }

                #login-otp-button{
                    display: block;
                }

        @endif

    </style>

</body>

</html>