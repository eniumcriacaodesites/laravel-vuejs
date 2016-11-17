var webpack = require('webpack');
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var extractCss = new ExtractTextPlugin('css/app.css')

module.exports = {
    devtool: 'source-map',
    entry: './src/js/main.js',
    output: {
        path: __dirname + '/dist',
        filename: 'app.bundle.js',
        publicPath: '/dist/'
    },
    plugins: [
        extractCss,
        new webpack.ProvidePlugin({
            'window.$': 'jquery',
            'window.jQuery': 'jquery'
        }),
        new webpack.HotModuleReplacementPlugin()
    ],
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel'
            },
            {
                test: /\.(woff|woff2|ttf|svg|eot)$/,
                loader: 'url?limit=100000'
            },
            {
                test: /\.scss$/,
                loader: extractCss.extract(['css', 'sass'])
            },
            {
                test: /\.vue$/,
                loader: 'vue'
            }
        ]
    },
    devServer: {
        host: '0.0.0.0',
        inline: true,
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        }
    }
};
