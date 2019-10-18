const mix = require('laravel-mix');

mix
    //
    // ─── STYLESHEETS ─────────────────────────────────────────────────
    //

    .styles(
        [
            'resources/assets/libs/css/bootstrap.scss',
            'resources/assets/libs/css/fontawesome.scss',
            'resources/assets/libs/css/alertify.scss',
            'resources/assets/libs/css/adminlte.scss',
            'resources/assets/libs/css/adminlte-green.scss',
            'resources/assets/libs/css/autocomplete.scss',
            'resources/assets/libs/css/multiselect.scss',
        ],
        'public/dist/vendor.css',
    )
    .sass('resources/assets/sass/panel.scss', 'public/dist')

    //
    // ─── JAVASCRIPTS ─────────────────────────────────────────────────
    //

    .scripts(
        [
            'resources/assets/libs/js/jquery.js',
            'resources/assets/libs/js/bootstrap.js',
            'resources/assets/libs/js/vue.js',
            'resources/assets/libs/js/alertify.js',
            'resources/assets/libs/js/jquery.datatable.js',
            'resources/assets/libs/js/jquery.datatable.bootstrap.js',
            'resources/assets/libs/js/adminlte.js',
            'resources/assets/libs/js/autocomplete.js',
            'resources/assets/libs/js/jquery.form.js',
            'resources/assets/libs/js/maskinput.js',
            'resources/assets/libs/js/slimscroll.js',
        ],
        'public/dist/vendor.js',
    )
    // Panel JS
    .babel(
        [
            'resources/assets/js/directives/focus.js',
            'resources/assets/js/directives/input-number.js',
            'resources/assets/js/inc/sidebar-timer.js',
            'resources/assets/js/inc/camera-helper.js',
            'resources/assets/js/inc/camera.js',
            'resources/assets/js/inc/person-register.js',
            'resources/assets/js/inc/person-search.js',
            'resources/assets/js/inc/page-taradod.js',
            'resources/assets/js/inc/page-screenshot.js',
            'resources/assets/js/inc/page-persontocode.js',
            'resources/assets/js/inc/page-bankarevan.js',
            'resources/assets/js/inc/quick-person-search.js',

            'resources/assets/js/panel.js',
        ],
        'public/dist/panel.js',
    )

    //
    // ─── STATIC FILES ────────────────────────────────────────────────
    //

    .copy(
        [
            'resources/assets/images/favicon.ico',
            'resources/assets/images/logo.png',
            'resources/assets/images/banner.jpg',
            'resources/assets/images/avatar.png',
        ],
        'public/images/',
    )

    //
    // ─── WEBPACK MIX OTHER CONFIGURATIONS ────────────────────────────
    //

    .version();
