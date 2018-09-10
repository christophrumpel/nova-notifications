let mix = require('laravel-mix')
let tailwindcss = require('tailwindcss')

mix.js('resources/js/tool.js', 'dist/js')
   .sass('resources/sass/tool.scss', 'dist/css')
    .postCss('resources/css/app.css', 'dist/css/tool.css', [tailwindcss('tailwind.js')]);
