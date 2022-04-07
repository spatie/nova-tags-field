let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .vue({version: 3})
    .sass('resources/sass/field.scss', 'dist/css')
    .webpackConfig({
        externals: {
            vue: 'Vue',
        },
        output: {
            uniqueName: 'spatie/nova-tags-field',
        },
        resolve: {
            symlinks: false
        }
    })
