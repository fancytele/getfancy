<!DOCTYPE html
          PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body
      style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #EBE4F0; color: #1d2c3c; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #EBE4F0; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        <tr>
            <td align="center"
                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0"
                       cellspacing="0"
                       style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                    <tr>
                        <td class="header"
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
                            <a href="{{ config('app.url') }}"
                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #ffffff; font-size: 19px; font-weight: bold; text-decoration: none;">
                               <img class="fancy-logo" src="{{ URL::asset('img/logo-light.png') }}" style="width: 200px" alt="Fancy Logo">
                            </a>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0"
                            cellspacing="0"
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <table class="inner-body" align="center" width="570"
                                   cellpadding="0" cellspacing="0"
                                   style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell"
                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <h1
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">
                                            Welcome {{ $user->display_name }}!
                                        </h1>
                                        <p
                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                           Give your phone system the power and intelligence it deserves! Set up your account in minutes!
                                        </p>

                                        <table class="action" align="center"
                                               width="100%" cellpadding="0"
                                               cellspacing="0"
                                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                            <tr>
                                                <td align="center"
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                    <table width="100%"
                                                           border="0"
                                                           cellpadding="0"
                                                           cellspacing="0"
                                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                        <tr>
                                                            <td align="center"
                                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                <table border="0"
                                                                       cellpadding="0"
                                                                       cellspacing="0"
                                                                       style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                    <tr>
                                                                        <td
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                            <a href="{{ route('password.reset', ['token' => $token, 'email' => $user->email]) }}"
                                                                               class="button button-blue"
                                                                               target="_blank"
                                                                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #ffffff; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #704895; border-top: 10px solid #704895; border-right: 18px solid #704895; border-bottom: 10px solid #704895; border-left: 18px solid #704895;">
                                                                                Get Started
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <p
                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                           You are receiving this email because you signed up for Fancy. <br><small>If you did not, then no further action is required.</small>
                                        </p>

                                        <p
                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            Regards,<br>
                                            The Fancy Team.
                                        </p>
                                        <table class="subcopy" width="100%"
                                               cellpadding="0" cellspacing="0"
                                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #edeff2; margin-top: 25px; padding-top: 25px;">
                                            <tr>
                                                <td
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                    <p
                                                       style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">
                                                        If you’re having trouble clicking the button, 
                                                        copy and paste the URL below into your web browser: {{ route('password.reset', ['token' => $token, 'email' => $user->email]) }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <table class="footer" align="center" width="570"
                                   cellpadding="0" cellspacing="0"
                                   style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <tr>
                                    <td class="content-cell" align="center"
                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <p
                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #7C2C9C; font-size: 12px; text-align: center;">
                                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
