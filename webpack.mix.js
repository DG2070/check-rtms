const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 */


mix.js("resources/js/dashboard/app.js", "public/dashboard/js/app.js")
    .sass("resources/sass/dashboard/app.scss", "public/dashboard/css/app.css")
    .sass("resources/sass/login/app.scss", "public/dashboard/css/login.css")
    .vue().version();


/**Added by Kishor for browser hot reload */

mix.browserSync({
    proxy: "http://localhost:8000",
    snippetOptions: {
        rule: {
            match: /<\/body>/i,
            fn: function (snippet, match) {
                return snippet + match;
            },
        },
    },
});

//Diable Build Notifications
mix.disableNotifications();
