var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass(['app.sass', 'screen.sass'])
    .coffee()
    .version('css/all.css')
    .styles([
    	'app.css',
    	'font-awesome.min.css',
    	'animate.css'
    ], 'public/css/all.css', 'public/css');
});
