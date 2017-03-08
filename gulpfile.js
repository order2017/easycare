var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    //
    mix.styles([
        'node_modules/normalize.css/normalize.css',
        'resources/assets/fonts/iconfont.css',
        'resources/assets/css/all.css'
    ], 'public/css/all.css', './');
    //
    mix.styles([
        'node_modules/amazeui/dist/css/amazeui.min.css',
        'node_modules/toastr/build/toastr.min.css',
        'node_modules/amazeui-datetimepicker-se/dist/amazeui.datetimepicker-se.css',
        'node_modules/select2/dist/css/select2.min.css',
        'resources/assets/css/admin.css'
    ], 'public/css/admin.css', './');
    //
    mix.scripts([
        'node_modules/jquery/dist/jquery.js',
        //'resources/assets/js/mobile-ajax-load.js',
        'resources/assets/js/all.js'
    ], 'public/js/all.js', './');
    //
    mix.scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/amazeui/dist/js/amazeui.min.js',
        'node_modules/moment/min/moment-with-locales.js',
        'node_modules/amazeui-datetimepicker-se/dist/amazeui.datetimepicker-se.js',
        'node_modules/toastr/build/toastr.min.js',
        'node_modules/jquery-pjax/jquery.pjax.js',
        'node_modules/select2/dist/js/select2.full.js',
        'resources/assets/js/admin.js'
    ], 'public/js/admin.js', './');
    //
    mix.scripts(['node_modules/jquery/dist/jquery.min.js',
        'resources/assets/js/login.js'
    ], 'public/js/login.js', './');
    //
    mix.version(['css/all.css', 'css/admin.css', 'js/all.js', 'js/admin.js', 'js/login.js'], 'public/assets');
    mix.copy('resources/assets/fonts', 'public/assets/css');
    mix.copy('node_modules/amazeui/dist/fonts', 'public/assets/fonts');
    mix.copy('resources/assets/images', 'public/assets/images');
});
