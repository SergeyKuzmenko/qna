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

mix.js('resources/js/app.js', 'public/js/app.js').vue();
mix.css('resources/css/normalize.css', 'public/css/app.css')
    .css('resources/css/styles.css', 'public/css/app.css')
    .copy(
        'node_modules/@fortawesome/fontawesome-free/webfonts',
        'public/webfonts'
    );
mix.minify('public/js/app.js').version();
mix.minify('public/css/app.css').version();
//mix.browserSync('qna.loc');
