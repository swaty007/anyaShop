const path = require("path");
import webpack from "webpack";
import settings from "./settings";
// const VueLoaderPlugin = require('vue-loader/lib/plugin');


module.exports = {
  entry: {
    App: settings.themeLocation + "js/scripts.js",
    // vendor: [
    // 'vue',
    // 'vue-router',
    // ]
  },
  output: {
    path: path.resolve(__dirname, settings.themeLocation + "js"),
    filename: "scripts-bundled.js",
  },
  optimization: {
    moduleIds: 'size'
  },
  module: {
    rules: [
      // {
      //     test: /\.vue$/,
      //     loader: 'vue-loader'
      // },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            plugins: ['lodash'],
            presets: [
              "@babel/preset-env",
            ],
          },
        },
      },
    ],
  },
  resolve: {
    extensions: ['.js'],
    alias: {
      // 'vue$': 'vue/dist/vue.common.js',
      // 'vue$': 'vue/dist/vue.esm.js',
    }
  },
  plugins: [
    // убедитесь что подключили плагин!
    // new VueLoaderPlugin()
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
    }),
    // new LodashModuleReplacementPlugin,
  ],
  mode: "production",
  // mode: "development",
};
