const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/dist/js')
mix.css('resources/css/app.css', 'public/dist/css', [
  require('postcss-import'),
  require('tailwindcss/nesting'),
  require('tailwindcss'),
  require('postcss-preset-env')({ stage: 0 })
])

mix.version()
