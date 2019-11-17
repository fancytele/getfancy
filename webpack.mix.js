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

const productionSourceMaps = false;

// General
mix.js('resources/js/app.js', 'public/js')
  .copyDirectory('resources/img', 'public/img');

// Web
mix.js('resources/js/web/home.js', 'public/js')
  .js('resources/js/web/checkout.js', 'public/js')
  .sass('resources/sass/web/main.scss', 'public/css/web.css')

// App
mix.js('resources/js/app/login.js', 'public/js')
  .js(['resources/js/app/admin.js'], 'public/js/admin.js')
  .sass('resources/sass/app/main.scss', 'public/css/app.css')
  .sourceMaps(productionSourceMaps, 'source-map');
