let mix = require('laravel-mix')
mix.extend('nova', new require('laravel-nova-devtool'))

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .vue({version: 3 })
    .nova('spatie/nova-tags-field');
