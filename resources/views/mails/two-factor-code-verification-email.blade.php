<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
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
                            <img class="fancy-logo" src="{{ URL::asset('img/logo-light.png') }}" style="width: 200px" alt="Fancyy Logo">
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
                                    <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Please enter the two factor authentication code below to complete your login process. <br><br><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Two Factor Code: {{ $two_factor_code }}</strong><br><br>
                                        The code will expire in <strong>10 minutes.</strong><br><br>
                                        <small>If you didn't try to log in recently, we recommend you change your password ASAP to protect your account.</small>
                                    </p>

                                    <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Regards,<br>
                                        The Fancyy Team.
                                    </p>
                                    <table class="subcopy" width="100%"
                                           cellpadding="0" cellspacing="0"
                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #edeff2; margin-top: 25px; padding-top: 25px;">
                                        <tr>
                                            <td
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                <p
                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #1d2c3c; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">
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
