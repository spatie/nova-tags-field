let mix = require('laravel-mix');

require('./mix.js');

mix.js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .setPublicPath('dist')
    .vue({ version: 3 })
    .nova('spatie/nova-tags-field');
