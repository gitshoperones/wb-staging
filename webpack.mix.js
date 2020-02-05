let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
	.copy('resources/assets', 'public/assets')
	.copy('resources/assets/js/nprogress/nprogress.js', 'public/assets/js')
	.copy('resources/assets/js/stupidtable/stupidtable.min.js', 'public/assets/js')
	.copy('resources/assets/js/nprogress/nprogress.css', 'public/assets/css')
	.copy('resources/assets/js/dropzone/dropzone.min.js', 'public/assets/js')
	.copy('resources/assets/js/masonry/masonry.pkgd.js', 'public/assets/js')
	.copy('resources/assets/js/dropzone/dropzone.min.css', 'public/assets/css')
	.copy('resources/assets/js/dropzone/dropzone.min.css', 'public/assets/css')
	.copy('resources/assets/sass/admin_custom.css', 'public/assets/css')
	.sass('resources/assets/sass/app.scss', 'public/assets/css')
	.options({
	   processCssUrls: false
	})
	.sourceMaps();
