const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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

elixir(mix => {
    // Copy all required CSS
    mix.copy('resources/assets/frontend/css/main.css', 'public/frontend/css/main.css');
    mix.copy('resources/assets/frontend/css/bootstrap.min.css', 'public/frontend/css/bootstrap.min.css');

    mix.copy('resources/assets/backend/adminlte-2.3.11/bootstrap/css/bootstrap.min.css', 'public/backend/bootstrap/css/bootstrap.min.css');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-1.2.2.css', 'public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css');
    mix.copy('resources/assets/backend/adminlte-2.3.11/dist/css/AdminLTE.min.css', 'public/backend/css/admin-lte.min.css');
    mix.copy('resources/assets/backend/adminlte-2.3.11/dist/css/skins/skin-blue.min.css', 'public/backend/css/skins/skin-blue.min.css');
    
    // Copy all required JS
    mix.copy('resources/assets/js/jquery-1.12.4.min.js', 'public/frontend/jquery-1.12.4.min.js');
    mix.copy('resources/assets/js/bootstrap.min.js', 'public/frontend/bootstrap.min.js');

    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/jQuery/jquery-2.2.3.min.js', 'public/backend/plugins/jquery/jquery-2.2.3.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/bootstrap/js/bootstrap.min.js', 'public/backend/bootstrap/js/bootstrap.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/fastclick/fastclick.js', 'public/backend/plugins/fastclick/fastclick.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/dist/js/app.min.js', 'public/backend/js/app.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/sparkline/jquery.sparkline.min.js', 'public/backend/plugins/sparkline/jquery.sparkline.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js', 'public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-world-mill-en.js', 'public/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/slimScroll/jquery.slimscroll.min.js', 'public/backend/plugins/slim-scroll/jquery.slimscroll.min.js');
    mix.copy('resources/assets/backend/adminlte-2.3.11/plugins/chartjs/Chart.min.js', 'public/backend/plugins/chartjs/chart.min.js');

    mix.copy('resources/assets/backend/js/paypal.js', 'public/backend/js/paypal.js');
});
