const mix = require('laravel-mix');
const cleanWebpackPlugin = require('clean-webpack-plugin');



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

var pathsToClean = [
   'public/js',
   'public/css'
];

var cleanOptions = {};

mix.webpackConfig({
   plugins: [
      new cleanWebpackPlugin(pathsToClean, cleanOptions)
   ]
})

mix.js('resources/js/main.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts');