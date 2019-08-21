<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fancy Email Info
    |--------------------------------------------------------------------------
    |
    | This value is the support Email of Fancy
    |
    */
    'email' => env('FANCY_EMAIL', ''),

    /*
    |--------------------------------------------------------------------------
    | Fancy Phone Info
    |--------------------------------------------------------------------------
    |
    | This value is the phone of Fancy
    |
    */
    'phone' => env('FANCY_PHONE', ''),

    /*
    |--------------------------------------------------------------------------
    | Fancy Supported Langs
    |--------------------------------------------------------------------------
    |
    | This is the list of locales supported separated by comma
    |
    */
    'supported_lang' => env('FANCY_LANG', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Fancy Recaptcha Secret Key
    |--------------------------------------------------------------------------
    |
    | This is the Recaptcha Secret Key
    |
    */
    'recaptcha_secret_key' => env('RECATPCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Fancy Recaptcha Site Key
    |--------------------------------------------------------------------------
    |
    | This is the Recaptcha Site Key
    |
    */
    'recaptcha_site_key' => env('RECATPCHA_SITE_KEY', ''),
];
