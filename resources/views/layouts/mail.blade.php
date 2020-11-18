<!DOCTYPE html
          PUBLIC "-//W3C//DTD XHTML 1.0 Transitional" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"
      style="margin: 0;padding: 0;border: 0;" class="gr__dashboard_stripe_com">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Your receipt from Fancy, {{ $receipt->id }}</title>

    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow, noarchive">

    <style type="text/css">
        img+div {
            display: none !important;
            /* Hides image downloading in Gmail */
        }

        @media screen and (max-width: 600px) {

            /** Gmail **/
            *[class="Gmail"] {
                display: none !important
            }

            /** Wrapper **/
            .Wrapper {
                max-width: 600px !important;
                min-width: 320px !important;
                width: 100% !important;
                border-radius: 0 !important;
            }

            .Section {
                width: 100% !important;
            }

            .Section--last {
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            /** Notice **/
            .Notice {
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            /** Header **/
            .Header .Header-left,
            .Header .Header-right {
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
            }

            /** Content **/
            .Content {
                width: auto !important;
            }

            /** Divider **/
            .Divider--kill {
                display: none !important;
                height: 0 !important;
                width: 0 !important;
            }

            /** Spacer **/
            .Spacer--gutter {
                width: 20px !important;
            }

            .Spacer--kill {
                height: 0 !important;
                width: 0 !important;
            }

            .Spacer--emailEnds {
                height: 0 !important;
            }

            /** Target **/
            .Target img {
                display: none !important;
                height: 0 !important;
                margin: 0 !important;
                max-height: 0 !important;
                min-height: 0 !important;
                mso-hide: all !important;
                padding: 0 !important;
                width: 0 !important;
                font-size: 0 !important;
                line-height: 0 !important;
            }

            .Target::before {
                content: '' !important;
                display: block !important;
            }

            /** Header **/
            .Header-area {
                width: 100% !important;
            }

            .Header-left,
            .Header-left::before,
            .Header-right,
            .Header-right::before {
                height: 156px !important;
                width: auto !important;
                background-size: 252px 156px !important;
            }

            .Header-left {
                background-image: url('{{ asset('img/mail/header-left.png') }}') !important;
                background-position: bottom right !important;
            }

            .Header-right {
                background-image: url('{{ asset('img/mail/header-center.png') }}') !important;
                background-position: bottom left !important;
            }

            .Header-icon,
            .Header-icon::before {
                width: 96px !important;
                height: 156px !important;
                background-size: 96px 156px !important;
            }

            .Header-icon {
                width: 96px !important;
                height: 156px !important;
                background-image: url('{{ asset('img/mail/header-right.png') }}') !important;
                background-position: bottom center !important;
            }

            /** Table **/
            .Table-content {
                width: auto !important;
            }

            .Table-rows {
                width: 100% !important;
            }
        }

        @media screen and (max-width: 599px) {

            /** Data Blocks **/
            .DataBlocks-item {
                display: block !important;
                height: 50px;
                text-align: left !important;
                width: 100% !important;
            }

            .DataBlocks-spacer {
                display: block !important;
                height: 12px !important;
                width: auto !important;
            }
        }
    </style>
</head>

<body class="Email"
      style="margin: 0;padding: 0;border: 0;background-color: #f1f5f9;font-family: -apple-system, BlinkMacSystemFont, &#39;Segoe UI&#39;, Roboto, &#39;Helvetica Neue&#39;, Ubuntu, sans-serif;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;min-width: 100% !important;width: 100% !important;"
      data-gr-c-s-loaded="true">
    <table class="Wrapper" align="center"
           style="border: 0;border-collapse: collapse;margin: 0 auto !important;padding: 0;max-width: 600px;min-width: 600px;width: 600px;">
        <tbody>
            <tr>
                <td
                    style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;">
                    <table class="Divider Divider--small Divider--kill"
                           width="100%"
                           style="border: 0;border-collapse: collapse;margin: 0;padding: 0;">
                        <tbody>
                            <tr>
                                <td class="Spacer Spacer--divider" height="30"
                                    style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="Shadow"
                         style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;box-shadow: 0 7px 14px 0 rgba(50,50,93,0.10), 0 3px 6px 0 rgba(0,0,0,0.07);">
                       <!-- <table dir="ltr" class="Section Header" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Header-left Target"
                                        style="background-color: #704895;border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;font-size: 0;line-height: 0px;mso-line-height-rule: exactly;background-size: 100% 100%;border-top-left-radius: 5px;"
                                        align="right" height="156"
                                        valign="bottom" width="252">
                                        <a href="#"
                                           style="pointer-events: none;cursor: default;">
                                            <img alt="" height="156" width="252"
                                                 src="{{ URL::asset('img/mail/header-left.png') }}"
                                                 style="display: block;border: 0;line-height: 100%;width: 100%;">
                                        </a>
                                    </td>
                                    <td class="Header-icon Target"
                                        style="background-color: #704895;border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;font-size: 0;line-height: 0px;mso-line-height-rule: exactly;background-size: 100% 100%;"
                                        align="center" height="156"
                                        valign="bottom" width="96">
                                        <a href="#" target="_blank"
                                           style="pointer-events: none;cursor: default;">
                                            <img alt=""
                                                 src="{{ URL::asset('img/mail/header-center.png') }}"
                                                 style="display: block;border: 0;line-height: 100%;width: 100%;">
                                        </a>
                                    </td>
                                    <td class="Header-right Target"
                                        style="background-color: #704895;border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;font-size: 0;line-height: 0px;mso-line-height-rule: exactly;background-size: 100% 100%;border-top-right-radius: 5px;"
                                        align="left" height="156"
                                        valign="bottom" width="252">
                                        <a href="#"
                                           style="pointer-events: none;cursor: default;">
                                            <img alt="" height="156" width="252"
                                                 src="{{ URL::asset('img/mail/header-right.png') }}"
                                                 style="display: block;border: 0;line-height: 100%;width: 100%;">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->

                        @yield('content')

                        <table class="Section Divider Divider--large"
                               width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="44"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Separator" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Spacer" bgcolor="e6ebf1"
                                        height="1"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Divider" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="32"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Copy"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Content Footer-help Font Font--body"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;width: 472px;font-family: -apple-system, BlinkMacSystemFont, &#39;Segoe UI&#39;, Roboto, &#39;Helvetica Neue&#39;, Ubuntu, sans-serif;mso-line-height-rule: exactly;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">
                                        If you have any questions, contact
                                        <span dir="ltr">Fancyy support</span>
                                        at <a href="mailto:{{ config('fancy.email') }}"
                                           style="white-space: nowrap;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;outline: 0;text-decoration: none;color: #556cd6;">
                                           {{ config('fancy.email') }}
                                        </a>
                                        or call at <a href="tel:{{ config('fancy.phone') }}"
                                           style="white-space: nowrap;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;outline: 0;text-decoration: none;color: #556cd6;">
                                            {{ config('fancy.phone') }}
                                        </a>.
                                    </td>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Divider" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="16"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Divider" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="16"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Separator" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Spacer" bgcolor="e6ebf1"
                                        height="1"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Divider" width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="32"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Copy"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Content Footer-legal Font Font--caption Font--mute"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;width: 472px;font-family: -apple-system, BlinkMacSystemFont, &#39;Segoe UI&#39;, Roboto, &#39;Helvetica Neue&#39;, Ubuntu, sans-serif;mso-line-height-rule: exactly;vertical-align: middle;color: #8898aa;font-size: 12px;line-height: 16px;">
                                        Something wrong with the email? <a
                                           class="browser-link"
                                           href="{{ route('mail.receipt', $receipt->id) }}"
                                           style="border: 0; margin: 0; padding: 0; color: #556cd6; font-family: -apple-system, BlinkMacSystemFont, &#39;Segoe UI&#39;, Roboto, &#39;Helvetica Neue&#39;, Ubuntu, sans-serif; text-decoration: none;"
                                           target="_blank"
                                           rel="noreferrer"><span
                                                  style="border: 0; margin: 0; padding: 0; color: #556cd6; text-decoration: none;">View
                                                it in your browser.</span></a>
                                    </td>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Copy"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                    <td class="Content Footer-legal Font Font--caption Font--mute"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;width: 472px;font-family: -apple-system, BlinkMacSystemFont, &#39;Segoe UI&#39;, Roboto, &#39;Helvetica Neue&#39;, Ubuntu, sans-serif;mso-line-height-rule: exactly;vertical-align: middle;color: #8898aa;font-size: 12px;line-height: 16px;">
                                        You're receiving this email because you
                                        made a purchase at
                                        <a href="{{ route('web.homepage') }}"
                                           style="-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; outline: 0; text-decoration: none; color: #556cd6;">
                                            <span dir="ltr">Fancy</span>
                                        </a>
                                    </td>
                                    <td class="Spacer Spacer--gutter" width="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="Section Section--last Divider Divider--large"
                               width="100%"
                               style="border: 0;border-collapse: collapse;margin: 0;padding: 0;background-color: #ffffff;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
                            <tbody>
                                <tr>
                                    <td class="Spacer Spacer--divider"
                                        height="64"
                                        style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <table class="Divider Divider--small Divider--kill"
                           width="100%"
                           style="border: 0;border-collapse: collapse;margin: 0;padding: 0;">
                        <tbody>
                            <tr>
                                <td class="Spacer Spacer--divider" height="30"
                                    style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>