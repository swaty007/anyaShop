const path = require("path");
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
                        presets: ["@babel/preset-env"],
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
    ],
    mode: "production",
    // mode: "development",
};
