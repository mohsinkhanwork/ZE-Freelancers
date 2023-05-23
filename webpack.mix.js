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

// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');
// Import theme assets
mix.copy('frontend/resources/assets', 'public/assets')
    .js('frontend/resources/js/app.js', 'public/js')
    .sass('frontend/resources/sass/app.scss', 'public/css')
    .styles([
        'public/css/bootstrap.min.css',
        'public/css/light-bootstrap-dashboard.css',
        // Include other theme CSS files here if any
    ], 'public/css/theme.css');

