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

// Compilar a la ubicación ESTÁNDAR de Laravel
mix.js('resources/js/app.js', 'public/js')      // → public/js/app.js
   .sass('resources/sass/app.scss', 'public/css') // → public/css/app.css
   .sourceMaps(false, 'source-map');

// BrowserSync (solo desarrollo)
if (process.env.NODE_ENV !== 'production') {
   mix.browserSync({
      proxy: 'webserver',
      host: '0.0.0.0',
      port: 3000,
      open: false,
      files: [
         'public/css/*.css',
         'public/js/*.js',
         'resources/views/**/*.blade.php'
      ],
      watchOptions: {
         usePolling: true,
         interval: 1000
      }
   });
}