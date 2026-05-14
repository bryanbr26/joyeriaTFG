const mix = require('laravel-mix');

// Configuración para desarrollo con Docker
if (process.env.NODE_ENV !== 'production') {
    mix.webpackConfig({
        watchOptions: {
            poll: 1000,
            ignored: /node_modules/
        }
    });
}

// Bundles por página + app global
// app.js se define al final para que manifest.js y vendor.js se generen en public/js/
mix.js('resources/js/pages/home.js', 'public/js/pages')
    .js('resources/js/pages/joyas-index.js', 'public/js/pages')
    .js('resources/js/pages/show.js', 'public/js/pages')
    .js('resources/js/pages/panel-carrito.js', 'public/js/pages')
    .js('resources/js/pages/orfebreria.js', 'public/js/pages')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps(false, 'source-map');

// Extraer vendor común: Vue, Bootstrap, Axios, Lodash
mix.extract(['vue', 'bootstrap', 'axios', 'lodash']);

// Activar versionado de assets
mix.version();

// BrowserSync (solo desarrollo)
if (process.env.NODE_ENV !== 'production') {
    mix.browserSync({
        proxy: 'webserver',
        host: '0.0.0.0',
        port: 3000,
        open: false,
        files: [
            'public/css/*.css',
            'public/js/**/*.js',
            'resources/views/**/*.blade.php'
        ],
        watchOptions: {
            usePolling: true,
            interval: 1000
        }
    });
}
