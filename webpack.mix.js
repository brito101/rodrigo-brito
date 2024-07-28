const mix = require("laravel-mix");
require("laravel-mix-purgecss");

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

mix.js("resources/js/app.js", "public/js")
    .copy("resources/img", "public/img")
    .sass("resources/sass/app.scss", "public/css")
    /** Admin */
    .scripts(["resources/js/company.js"], "public/js/company.js")
    .scripts(["resources/js/address.js"], "public/js/address.js")
    .scripts(["resources/js/phone.js"], "public/js/phone.js")
    /** Site */
    .sass("resources/sass/site/style.scss", "public/css/site/style-v1.css")
    .copy("resources/fonts", "public/site/fonts")
    .scripts(
        [
            "resources/js/site/anime.js",
            "resources/js/site/button-top.js",
            "resources/js/site/cookie.js",
            "resources/js/site/fade.js",
            "resources/js/site/mobile.js",
        ],
        "public/js/site/script.js"
    )
    .scripts(
        [
            "resources/js/site/home/goto.js",
            "resources/js/site/home/snow.js",
            "resources/js/site/home/typewrite.js",
        ],
        "public/js/site/home.js"
    )
    .scripts(["resources/js/site/post/post.js"], "public/js/site/post.js")
    .scripts(["resources/js/site/about/slide.js"], "public/js/site/slide.js")
    .scripts(["resources/js/site/google-tag-manager.js"], "public/js/site/google-tag-manager.js")
    .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .purgeCss();
