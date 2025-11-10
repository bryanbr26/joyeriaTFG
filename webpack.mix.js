const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')      // Compila tu JS (y Bootstrap JS)
   .sass('resources/sass/app.scss', 'public/css') // Compila tu SCSS (Bootstrap incluido)
   .sourceMaps();
