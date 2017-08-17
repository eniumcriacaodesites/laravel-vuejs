const HOST = '0.0.0.0';
const gulp = require('gulp');
const elixir = require('laravel-elixir');
const webpack = require('webpack');
const WebpackDevServer = require('webpack-dev-server');
const webpackMerge = require('webpack-merge');
const webpackConfig = require('./webpack.config');
const webpackDevConfig = require('./webpack.dev.config');
const env = require('gulp-env');
const stringifyObject = require('stringify-object');
const file = require('gulp-file');
const argv = require('yargs').argv;

// require('laravel-elixir-vue');
// require('laravel-elixir-webpack-official');
//
// Elixir.webpack.config.module.loaders = [];
// Elixir.webpack.mergeConfig(webpackConfig);
// Elixir.webpack.mergeConfig(webpackDevConfig);

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

gulp.task('spa-config', () => {
    if (argv._.includes('watch')) {
        env({
            file: '.env',
            type: 'ini'
        });
    }

    let spaConfig = require('./spa.config');
    let string = stringifyObject(spaConfig);

    return file('config.js', `module.exports = ${string};`, {src: true})
        .pipe(gulp.dest('./resources/assets/spa/js'));
});

gulp.task('webpack-dev-server', () => {
    let config = webpackMerge(webpackConfig, webpackDevConfig);
    let inlineHot = ['webpack/hot/dev-server', `webpack-dev-server/client?http://${HOST}:8088`];

    for (let key of Object.keys(config.entry)) {
        config.entry[key] = [config.entry[key]].concat(inlineHot);
    }

    // config.entry.admin = [config.entry.admin].concat(inlineHot);

    new WebpackDevServer(webpack(config), {
        hot: true,
        proxy: {
            '*': `http://${HOST}:8000` // app laravel
        },
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        },
        publicPath: config.output.publicPath,
        noInfo: true,
        stats: {
            colors: true
        },
    }).listen(8088, HOST, () => {
        console.log("Building project...");
    });
});

elixir((mix) => {
    mix
        .sass('./resources/assets/admin/sass/admin.scss')
        .sass('./resources/assets/spa/sass/spa.scss')
        .sass('./resources/assets/site/sass/site.scss')
        .copy('./node_modules/materialize-css/fonts/roboto', './public/fonts/roboto')
    ;

    if (argv._.includes('watch')) {
        gulp.start('spa-config', 'webpack-dev-server');

        mix.browserSync({
            host: HOST,
            proxy: `http://${HOST}:8088`
        });
    } else {
        gulp.start('spa-config');
        webpack(require('./webpack.config'), () => {
            console.log("Building project...");
        });
    }

});
