const mix = require('laravel-mix');

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

mix
	.webpackConfig({
		module: {
			rules:[
				{
					test: /\.txt$/i,
					use: ['raw-loader'],
				}
			]
		},
		resolve: {
			fallback: {
				"fs": false,
				"path": false,
				"crypto": false,
				"stream": false,
			}
		}
	})


	// --------------------------------------
	// px2-peraichize.js
	.js('src/assets/px2-peraichize.js', 'public/assets/')
	.sass('src/assets/px2-peraichize.scss', 'public/assets/')

	// --------------------------------------
	// peraichizeCceFront.js
	.js('cce/src/peraichizeCceFront.js', 'cce/front/')
	.sass('cce/src/peraichizeCceFront.scss', 'cce/front/')

	.copyDirectory('public/assets/', 'tests/testdata/standard/common/peraichize/assets/')
;
