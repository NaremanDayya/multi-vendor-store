const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/cart.js', 'public/js')
.postCss('resources/sass/app.scss', 'public/css',[

]);
//كل ما نعدل عليه بدنا نعمل npm run production