var Encore = require('@symfony/webpack-encore');
const path = require('path');
const GoogleFontsPlugin = require("@beyonk/google-fonts-webpack-plugin");
const fontsConf = require('./fonts.json');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    
    .setPublicPath('/build')

    .addEntry('app', './assets/app.js')

    .disableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()

    .enableBuildNotifications(!Encore.isProduction())

    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())

    //.enableTypeScriptLoader()

    .enableSassLoader()

    //.addPlugin(new GoogleFontsPlugin(fontsConf))
    
    .autoProvidejQuery()
;
let config = Encore.getWebpackConfig();
// config.resolve.alias = {
//     ...config.resolve.alias, ...{
//         '@': path.resolve(__dirname, 'assets/ts'),
//         '#': path.resolve(__dirname, 'assets/scss'),
//     },
//     ...config.resolve.extensions.push('.scss')
// };

// config.watchOptions.poll = true;

module.exports = config;

