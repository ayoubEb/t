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
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/password.scss', 'public/css')
.sass('resources/sass/buy_sell.scss', 'public/css')
.sass('resources/sass/style.scss', 'public/css')
.sass('resources/sass/recu.scss', 'public/css')
.sass('resources/sass/rapport.scss', 'public/css')
.sass('resources/sass/login.scss', 'public/css')
.sass('resources/sass/basic.scss', 'public/css')
.sourceMaps();
