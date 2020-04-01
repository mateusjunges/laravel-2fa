const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .purgeCss();

mix.sass('resources/sass/app.scss', 'public/css/tailwind/tailwind.css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
    });


/* while developing make sure public/vendor/junges/laravel-2fa is fresh */
mix.copy('public/css/app.css', '../../public/vendor/junges/laravel-2fa/css/app.css');
mix.copy('public/js/app.js', '../../public/vendor/junges/laravel-2fa/js/app.js');
mix.copy('public/css/tailwind/tailwind.css', '../../public/vendor/junges/laravel-2fa/css/tailwind/tailwind.css');

mix.disableSuccessNotifications();
if (mix.inProduction()) {
    mix.version();
}
