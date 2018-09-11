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

mix.js('resources/assets/js/app.js', 'public/js')
    .babel(['resources/views/mmlayouts/components/js/datatables.min.js',
        './resources/assets/js/vendor/popper.min.js',
        'resources/views/mmlayouts/components/js/moment.min.js',
        'resources/views/mmlayouts/components/js/datetime-moment.js',
        'resources/views/mmlayouts/components/login/login.js',
        'resources/views/mmlayouts/components/sidebar/sidebar.js',
        'resources/views/mmlayouts/components/table-list/table-list.js',
        'resources/views/mmlayouts/components/dashboard/dashboard.js',
        'resources/views/mmlayouts/components/employee-register/employee-register.js'], 
        'public/js/scripts.js')
    .babel('resources/views/mmlayouts/components/admin-tabs/hashtag.js', 'public/js/hashtag.js')
    .js('resources/assets/js/vue/vc.js', 'public/js')
    .copy('./resources/assets/js/vendor/clipboard.js', 'public/js')
    .extract([
        'vue', 
        './resources/assets/js/vendor/slick.js',
        './resources/assets/js/vendor/velocity.js',
    ])
    .sourceMaps();
        
mix.copy('resources/assets/css/ionicons.min.css', 'public/css')
    .copy('resources/views/mmlayouts/components/vendor/datatables.css', 'public/css')
    .copy('resources/views/mmlayouts/components/vendor/fontawesome.css', 'public/css')
    .sass('resources/views/mmlayouts/components/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
   
