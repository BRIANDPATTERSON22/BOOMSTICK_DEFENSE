let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');


// mix.combine([
//     'resources/assets/css/plugins.css',
//     'resources/assets/css/toastr.min.css',
//     'resources/assets/css/xzoom.css',
//     'resources/assets/css/style.css',
// ], 'public/css/app.css');

mix.styles([
    'public/site/css/plugins.css',
    'public/site/css/toastr.min.css',
    'public/site/css/xzoom.css',
    'public/site/css/style.css',
], 'public/css/app.css');


// mix.combine([
//     'public/site/js/plugins.js',
//     'public/site/js/main.js',
//     'public/site/js/xzoom.min.js',
//     'public/site/js/toastr.min.js',
//     'public/site/js/customizer.min.js',
// ], 'public/js/app.js');

mix.scripts([
    'public/site/js/plugins.js',
    'public/site/js/main.js',
    'public/site/js/xzoom.min.js',
    'public/site/js/toastr.min.js',
    'public/site/js/customizer.min.js',
], 'public/js/app.js');
