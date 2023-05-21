const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
    .disableSingleRuntimeChunk()
    .setOutputPath('./www/build')
    .setPublicPath('/build')
    .addEntry('main', './www/main.js')
    .enableVueLoader(() => {}, { runtimeCompilerBuild: true })
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(Encore.isDev());

module.exports = Encore.getWebpackConfig();