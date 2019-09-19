const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/pages/home.js', 'public/js')
  .js('resources/js/pages/login.js', 'public/js')
  .js('resources/js/pages/checkout.js', 'public/js')
  .sass('resources/sass/web/main.scss', 'public/css/web.css')
  .sass('resources/sass/app/main.scss', 'public/css/app.css')
  .copyDirectory('resources/img', 'public/img');
