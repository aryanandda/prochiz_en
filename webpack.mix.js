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

mix.copyDirectory('resources/assets/img', 'public/assets/web/img')
   .copy('node_modules/jquery/dist/jquery.min.js', 'public/assets/web/js/jquery.min.js')
   .copy('node_modules/select2/dist/js/select2.min.js', 'public/assets/web/js/select2.min.js')
   .copy('node_modules/select2/dist/css/select2.min.css', 'public/assets/web/css/select2.min.css')
   .copy('node_modules/what-input/dist/what-input.min.js', 'public/assets/web/js/what-input.min.js')
   .copy('node_modules/foundation-sites/dist/js/foundation.min.js', 'public/assets/web/js/foundation.min.js')
   .copy('node_modules/magnific-popup/dist/jquery.magnific-popup.min.js', 'public/assets/web/js/magnific-popup.min.js')
   .copy('resources/assets/js/infinite-scroll.js', 'public/assets/web/js/infinite-scroll.js')
   .js('resources/assets/js/app.js', 'public/assets/web/js')
   .sass('resources/assets/sass/app.scss', 'public/assets/web/css')
   .styles('node_modules/vegas/dist/vegas.css', 'public/assets/web/css/vegas.css')
   .styles('node_modules/magnific-popup/dist/magnific-popup.css', 'public/assets/web/css/magnific-popup.css')
   .options({
        processCssUrls: false
   });

if (mix.inProduction()) {
    mix.version();
}