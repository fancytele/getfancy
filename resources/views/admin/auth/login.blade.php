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
                    <div id="email_display" class="form-group">

                        <!-- Label -->
                        <label for="email">@lang('E-mail')</label>

                        <!-- Input -->
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="john@doe.com" autocomplete="email"
                               value="{{ old('email') }}" required autofocus>

                         <span id="emailError" class="invalid-feedback" style="display: block" role="alert"></span>

                         @if(session()->has('twoFactorCodeExpiredErrorMessage'))
                            <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('twoFactorCodeExpiredErrorMessage') }}</strong></span>
                        @endif


                        @if(session()->has('credentialErrorMessage'))
                            <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('credentialErrorMessage') }}</strong></span>
                        @endif


                            @if(session()->has('InvalidEmailErrorMessage'))
                                <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('InvalidEmailErrorMessage') }}</strong></span>
                            @endif

                        @error('email')
                        <span id="error" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div id="password_display" class="form-group">

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
                        <div id="twoFactoCodeSuccessMessage">
                            <span style="display: block"></span>
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div id="two_factor_code" class="form-group">

                            <div class="row">
                                <div class="col">

                                    <!-- Label -->
                                    <label for="two_factor_code">@lang('Two Factor Code')</label>

                                </div>
                            </div> <!-- / .row -->

                            <!-- Input -->
                            <input type="number" name="two_factor_code"
                                   class="form-control form-control-appended @error('two_factor_code') is-invalid @enderror"
                                   placeholder="@lang('Enter your two factor code')" >

                            @error('two_factor_code')
                            <span id="error" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror


                            @if(session()->has('twoFactorCodeErrorMessage'))
                                <span class="invalid-feedback" style="display: block" role="alert"><strong>{{ session()->get('twoFactorCodeErrorMessage') }}</strong></span>
                            @endif

                        </div>


                    <!-- Submit -->
                    <button type="submit" id="submit-button"
                            class="btn btn-lg btn-block btn-info ladda-button js-ladda-submit mb-3"
                            data-style="zoom-out">
                        <span class="ladda-label">@lang('Login')</span>
                    </button>

                        <button id="login-two-factor-code-button" onclick="return getOtp()"
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
      var l = Ladda.create(document.getElementById('login-two-factor-code-button'));
      l.start();
      var x = new XMLHttpRequest();
      x.open("POST", "{{ route('admin.login.send_two_factor_code') }}", true);
      x.setRequestHeader("Content-type", "application/json");

      var sendData = { email: document.getElementById('email').value , password: document.getElementById('password').value};
      if(!sendData.email)
      {
        document.getElementById('emailError').innerHTML = '<strong>@lang('Please provide some input')</strong>';
      }

      if(!sendData.password)
      {
        document.getElementById('passwordError').innerHTML = '<strong>@lang('Please provide some input')</strong>';
      }

        x.send(JSON.stringify(sendData));

        //---- changed the onreadystatechange with onloadend
        //---- since i dont have anything to do on of the previous states then 4th one
        x.onloadend = function() {
          if (x.readyState === 4 && x.status === 200) {
            l.stop();
             var response = sendData.email;
             var stringSplit = response.split('@');
             var stringSplitFirstPart = stringSplit[0];
             var newStringFrstPart =""

             var stringSplitSecondPart = stringSplit[1].split('.');
             var stringSplitSecond = stringSplitSecondPart[0];

             var newStringSecondPart =""

             for(var i in stringSplitFirstPart){
                if(i>1){
                    newStringFrstPart += "*";
                  }
                else {
                  newStringFrstPart += stringSplitFirstPart[i];
                }
             }


             for(var j in stringSplitSecond){

                if(j>1){
                    newStringSecondPart += "*";
                  }
                else {
                  newStringSecondPart += stringSplitSecond[j];
                }
             }

             slice_response_second_string = newStringSecondPart.slice(0,5);
             slice_response_first_string = newStringFrstPart.slice(0,5);
             modified_response = slice_response_first_string +"@"+ slice_response_second_string+"."+stringSplitSecondPart[1];

            document.getElementById('emailError').innerHTML = '';
            document.getElementById('passwordError').innerHTML = '';
            document.getElementById('twoFactoCodeSuccessMessage').innerHTML= '<strong>@lang('Please enter the code we have sent to ')</strong>' + modified_response;
            document.getElementById('two_factor_code').style.display = "block";
            document.getElementById('submit-button').style.display = "block";
            document.getElementById('login-two-factor-code-button').style.display = "none";
            document.getElementById('email_display').style.display="none";
            document.getElementById('password_display').style.display="none";
          }
          else if(x.status === 401)
          {
            l.stop();
           if(!document.getElementById('password').value){
             document.getElementById('passwordError').innerHTML = '<strong>@lang('Please provide some input')</strong>';
             document.getElementById('emailError').innerHTML = '';
           }
           else{
             document.getElementById('passwordError').innerHTML = '';
             document.getElementById('emailError').innerHTML = '<strong>@lang('These credentials do not match our records.')</strong>';
             document.getElementById('password').value=null;
           }
            document.getElementById('two_factor_code').style.display ="none";
            document.getElementById('submit-button').style.display ="none";
          }
          else if(x.status === 202)
          {
            l.stop();
            document.getElementById('submit-button').click();
          }
          else
          {
            l.stop();
            document.getElementById('two_factor_code').style.display ="none";
            document.getElementById('submit-button').style.display ="none";
          }
        }
        return false;


    }
</script>

    <style>
        @if(session()->has('credentialErrorMessage') OR session()->has('twoFactorCodeErrorMessage'))
               #email_display{
            display: block;
            }
            #password_display{
                display: block;
            }
            #two_factor_code{
                display: block;
            }

            #submit-button{
                display: block;
            }

            #login-two-factor-code-button{
                display: none;
            }


        @elseif(session()->has('twoFactorCodeExpiredErrorMessage') OR session()->has('InvalidEmailErrorMessage'))
                #two_factor_code{
                    display: none;
                }

                #submit-button{
                    display: none;
                }

                #login-two-factor-code-button{
                    display: block;
                }

            @else
                #email_display{
                display: block;
                }
                #password_display{
                    display: block;
                }
                #two_factor_code{
                    display: none;
                }

                #submit-button{
                    display: none;
                }

                #login-two-factor-code-button{
                    display: block;
                }

        @endif

    </style>

</body>

</html>