/* global process __dirname */

const path      = require('path');
const fs        = require('fs');
const webpack   = require('webpack');
const context   = path.join(__dirname);
const npmConfig = JSON.parse(fs.readFileSync('./package.json')).config;

const inProduction = process.env.NODE_ENV === 'production';
const env = inProduction ? 'production' : 'development';

const config = {
  context: context
};

config.watch = false;

config.module = {
  rules: [
    {
      test: /\.jsx?$/,
      // Don't exclude modules from being transformed as many are now written in es6
      //exclude: /(node_modules|bower_components)/,
      loader: 'babel-loader',
      options: {
        babelrc: false,
        presets: [
          ['env', {
            targets: {
              browsers: ['last 4 versions', 'safari >= 7']
            },
            modules: false
          }]
        ],
      }
    },
    {
      test: /\.tsx?$/,
      // exclude: /(node_modules|bower_components)/,
      use: [
        {
          loader: 'babel-loader',
          options: {
            babelrc: false,
            presets: [
              ['env', {
                targets: {
                  browsers: ['last 4 versions', 'safari >= 7']
                },
                modules: false
              }]
            ],
          }
        },
        {
          loader: 'ts-loader'
        }
      ]
    }
  ]
};

config.resolve = {
  modules: [
    path.resolve(`${npmConfig.assetSource}scripts`),
    'node_modules',
    'bower_components'
  ],
  alias: {
    'babylon-grid': 'babylon-grid/dist/jquery.babylongrid.js'
  },
  extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue', '.json']
};


config.externals ={
  'jquery': 'jQuery'
};

config.devtool = inProduction ? '#source-map' : '#eval-source-map';

const providePlugin = new webpack.ProvidePlugin({
  $: 'jquery',
  jQuery: 'jquery'
});

const envProcess = new webpack.DefinePlugin({
  'process.env.NODE_ENV': JSON.stringify(env)
});


const uglifyPlugin = new webpack.optimize.UglifyJsPlugin({
  compress: { warnings: false, drop_console: true }
});

const loaderOptions = new webpack.LoaderOptionsPlugin({
  minimize: true
});

const aggressiveMerging = new webpack.optimize.AggressiveMergingPlugin();

config.plugins = [
  providePlugin,
  envProcess
];


if (inProduction) {
  config.plugins.push( uglifyPlugin, aggressiveMerging, loaderOptions );
}
module.exports = config;
