const Encore = require('@symfony/webpack-encore');
const RtlCssPlugin = require('rtlcss-webpack-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/assets')
    // public path used by the web server to access the output path
    .setPublicPath('/assets')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    // .addEntry('app', './assets/admin/scss/config/creative/app.scss')
    // .addEntry('bootstrap', './assets/admin/scss/config/creative/bootstrap.scss')
    // .addEntry('icons', './assets/admin/scss/icons.scss')
    // .addEntry('custom', './assets/admin/scss/config/creative/custom.scss')

    .addEntry('app_js', './assets/frontend/javascript/app.js')
    // .addEntry('custom_js', './assets/frontend/javascript/custom.js')
    .addEntry('skin_1', './assets/frontend/css/skin/skin-1.css')
    .addEntry('skin_2', './assets/frontend/css/skin/skin-2.css')
    .addEntry('skin_3', './assets/frontend/css/skin/skin-3.css')
    .addEntry('skin_4', './assets/frontend/css/skin/skin-4.css')
    .addEntry('skin_5', './assets/frontend/css/skin/skin-5.css')
    .addEntry('skin_6', './assets/frontend/css/skin/skin-6.css')
    .addEntry('skin_7', './assets/frontend/css/skin/skin-7.css')
    .addEntry('skin_8', './assets/frontend/css/skin/skin-8.css')



  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    .enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    .configureFilenames({
      css: 'css/[name].min.css',
    })

  .copyFiles({
    from: './assets/frontend/fonts',
    to: 'fonts/[name].[ext]',
  })
  .copyFiles({
    from: './assets/frontend/images',
    to: 'images/[name].[ext]',
  })
  .copyFiles({
    from: './assets/frontend/media',
    to: 'media/[name].[ext]',
  })
  .copyFiles({
    from: './assets/frontend/pdf',
    to: 'pdf/[name].[ext]',
  })
  // .copyFiles({
  //   from: './assets/frontend/icons',
  //   to: 'icons/[name].[ext]',
  // })
    // .copyFiles({
    //   from: './assets/fonts',
    //   to: 'fonts/[name].[ext]',
    // })
    //
    // .copyFiles({
    //   from: './assets/images',
    //   to: 'images/[path][name].[ext]',
    // })
    //
    // .copyFiles({
    //   from: './assets/javascript',
    //   to: 'javascript/[path][name].[ext]',
    // })
    //
    // .copyFiles({
    //   from: './assets/json',
    //   to: 'json/[name].[ext]',
    // })
    //
    // .copyFiles({
    //   from: './assets/lang',
    //   to: 'lang/[name].[ext]',
    // })
    //
    // .copyFiles({
    //   from: './assets/libs',
    //   to: 'libs/[path][name].[ext]',
    // })
    // .addPlugin(new RtlCssPlugin({
    //   filename: 'css/[name]-rtl.min.css',
    // }))

;

module.exports = Encore.getWebpackConfig();
