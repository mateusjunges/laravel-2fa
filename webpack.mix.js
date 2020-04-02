const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

require('laravel-mix-purgecss');

mix.sass('resources/sass/app.scss', 'public/css/tailwind/tailwind.css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
    })
    .purgeCss({
        enabled: true,
        folders: ['public', 'resources'],
        extensions: ['html', 'js', 'css', 'php'],
    });


/* while developing make sure public/vendor/junges/laravel-2fa is fresh */
mix.copy('public/css/tailwind/tailwind.css', '../../public/vendor/junges/laravel-2fa/css/tailwind/tailwind.css');

mix.disableSuccessNotifications();
if (mix.inProduction()) {
    mix.version();
}
