const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
    // where webpack files are generated
    .setOutputPath('./www/dist')
    // where webpack generated files are placed to use by webpack
    .setPublicPath('/dist')
    // where Vue config file is
    .addEntry('main', './www/js/main.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableVueLoader(() => {}, { runtimeCompilerBuild: true })
    // setting manifest files 1 folder back
    .configureManifestPlugin(options => {
        options.publicPath = '';
    })
    .configureDevServerOptions(options => {
        options.port = 90;
        options.allowedHosts = 'all';
    })
;

module.exports = Encore.getWebpackConfig();