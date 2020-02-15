const SvgStorePlugin = require('external-svg-sprite-loader');

const path = require('path');
const glob = require('glob');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MediaQueryPlugin = require('media-query-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const pugVue = require('./pugVue');
const {
  BundleAnalyzerPlugin
} = require('webpack-bundle-analyzer');
global.isFront = true;
global.util = require('./util');
const IdemSplitPlugin = require('./modules/idem-split-plugin');
var HashPlugin = require('hash-webpack-plugin');

let pages = glob.sync(__dirname + '/source/pages/*.pug');
const plugins = [
  new CleanWebpackPlugin(),
  new MiniCssExtractPlugin({
    filename: "./assets/styles/[name]-[hash].css",
    chunkFilename: "./assets/styles/chunk/[name]-[hash].css"
  }),
  new BundleAnalyzerPlugin({
    analyzerMode: 'static',
    openAnalyzer: false,
  }),
  new HashPlugin({
    path: './',
    fileName: 'hash.txt'
  }),
  new CopyWebpackPlugin([{
    from: './source/static',
    to: './',
    ignore: ['*.md']
  }]),
  new SvgStorePlugin({
    sprite: {
      startX: 10,
      startY: 10,
      deltaX: 20,
      deltaY: 20,
      iconHeight: 20,
    },
    prefix: '',
    suffix: ''
  }),
  /*new IdemSplitPlugin({
    tablet: 768,
    laptop: 1024,
    desctop: 1280,
  }),*/
  // new MediaQueryPlugin({
  //   include: true,
  //   queries: {
  //     '(min-width: 1280px)': 'desctop',
  //     '(min-width: 1024px)': 'tablet',
  //     // '(min-width: 1024px)': 'desctop_md',
  //     // '(min-width: 1023px)': 'tablet',
  //     // '(min-width: 768px) and (max-width: 1279px)': 'tablet',
  //     // '(min-width: 768px)': 'tablet',
  //   },
  // })
];
pages.map(function (file) {
  let base = path.basename(file, '.pug');
  plugins.push(new HtmlWebpackPlugin({
    filename: './' + base + '.html',
    template: './source/pages/' + base + '.pug',
    inject: false
  }));
});

module.exports = (env, argv) => {
  return {
    devtool: '',
    entry: {
      autoload: './source/autoload.js',
      pdf: './source/entry/pdf/pdf.js',
      catalog: './source/entry/catalog/catalog.js',
      about: './source/entry/about/about.js',
      contacts: './source/entry/contacts/contacts.js',
      detail: './source/entry/detail/detail.js',
      favorite: './source/entry/favorite/favorite.js',
      home: './source/entry/home/home.js',
      sitemap: './source/entry/sitemap/sitemap.js',
      map: './source/entry/map/map.js',
      stub: './source/entry/stub/stub.js',
      visual: './source/entry/visual/visual.js',
      privacy: './source/entry/privacy/privacy.js'
    },
    output: {
      filename: './assets/scripts/[name]-[hash].js',
      chunkFilename: './assets/scripts/chunk/[name]-[hash].js',
      path: path.resolve(__dirname, 'dist'),
      publicPath: "/"
    },
    plugins,
    module: {
      rules: [{
          test: /\.scss$/,
          use: [{
              loader: MiniCssExtractPlugin.loader,
              // options: {
              //   publicPath: './../../'
              // }
            },
            {
              loader: "css-loader",
              // options: {
              //   modules: true,
              // }
            },
            // {
            //   loader: MediaQueryPlugin.loader
            // },
            // {
            //   loader: 'postcss-loader',
            //   options: {
            //     plugins: function () {
            //       return [
            //         require('autoprefixer')({browsers: "last 5 versions"})
            //       ];
            //     }
            //   }
            // },
            "group-css-media-queries-loader",
            {
              loader: "sass-loader",
              options: {
                includePaths: [
                  path.resolve(__dirname, 'source/base/styles'),
                ]
              }
            },
            path.resolve(__dirname, './modules/vue-sass-loader'),
          ]
        },
        {
          test: /\.js$/,
          exclude: /node_modules\/(?!(dom7|swiper)\/).*/,
          use: [{
            loader: 'babel-loader',
            options: {
              "presets": ["@babel/preset-env"],
              "plugins": ["@babel/plugin-syntax-dynamic-import"]
            }
          }]
        },
        {
          loader: SvgStorePlugin.loader,
          test: /\.svg$/,
          options: {
            iconName: '[name]',
            name: './assets/sprite.svg',
          },
        },
        {
          test: /\.(png|jpg?)(\?.+)?$/,
          loader: 'file-loader',
          options: {
            name: 'assets/images/[name].[ext]',
          }
        },
        {
          test: /\.(ttf|eot|woff|woff2)$/,
          use: [{
            loader: "file-loader",
            options: {
              name: "assets/fonts/[name].[ext]",
            },
          }],
        },
        // {
        //   enforce: 'pre',
        //   test: /\.pug$/,
        //   exclude: /node_modules/,
        //   loader: 'pug-lint-loader',
        //   options: require('./.pug-lintrc.js'),
        // },
        {
          test: /^(?!.*?.ajax).*\.pug$/,
          exclude: [
            path.resolve(__dirname, 'source/pages'),
          ],
          use: [{
              loader: path.resolve(__dirname, './modules/vue-pug-loader'),
              options: {
                // pretty: true,
                plugins: [pugVue],
                globals: ['isFront', 'util'],
              }
            },
            {
              loader: path.resolve('noSsrLoader.js'),
            }
          ]
        },
        {
          test: /\.pug$/,
          loader: 'pug-loader',
          include: [
            path.resolve(__dirname, 'source/pages'),
          ],
          options: {
            // pretty: true,
            globals: ['isFront', 'util'],
          }
        }
      ]
    },
    resolve: {
      extensions: [".js", ".json", ".sass"],
      alias: {
        app: path.resolve(__dirname, './source'),
        static: path.resolve(__dirname, './source/static'),
        assets: path.resolve(__dirname, './source/assets'),
        vue$: 'vue/dist/vue.esm.js',
        pugVue: path.resolve(__dirname, 'pugVue.js'),
      },
    },
    // watch: true,
    optimization: {
      minimizer: [
        new UglifyJSPlugin({
          sourceMap: true,
          uglifyOptions: {
            compress: {
              inline: false
            }
          }
        }),
        new OptimizeCSSAssetsPlugin(),
      ],
      splitChunks: {
        cacheGroups: {
          default: false,
          commons: {
            name: 'common',
            minChunks: 2,
            reuseExistingChunk: true,
            chunks: 'all'
          },
          styles: {
            name: 'common',
            test: /\.s?css$/,
            chunks: 'all',
            minChunks: 2,
            reuseExistingChunk: true,
            enforce: true,
          },
        }
      }
    },
    target: "web",
    devServer: {
      //contentBase: path.resolve(__dirname, './source/pages/'),
      host: '0.0.0.0',
      watchContentBase: true,
      port: 9002,
      open: true,
      disableHostCheck: true,
      noInfo: true,
      compress: true,
      hot: false,
      stats: 'minimal',
      publicPath: "/"
    },
    // stats: 'errors-only',
  }
};
