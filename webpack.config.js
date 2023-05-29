const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
    .setOutputPath('./www/dist')
    .setPublicPath('/dist')
    .addEntry('main', './www/js/main.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableVueLoader(() => {}, { runtimeCompilerBuild: true });

module.exports = Encore.getWebpackConfig();