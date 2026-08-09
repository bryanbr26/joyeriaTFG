FROM php:8.2-fpm

# Instalar dependencias del sistema incluyendo herramientas de optimización de imágenes/video
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libssl-dev \
    libmagickwand-dev \
    imagemagick \
    webp \
    jpegoptim \
    optipng \
    pngquant \
    ffmpeg \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar e instalar GD con soporte JPEG y WebP (PNG viene por defecto)
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Instalar extensiones adicionales de PHP: Redis (cache/sesiones) y Imagick (procesamiento de imágenes grandes)
RUN pecl install redis imagick \
    && docker-php-ext-enable redis imagick

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuracion de subida de archivos y memoria para procesamiento de imágenes
COPY .docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory.ini

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Verificar instalaciones
RUN php --version && composer --version && node --version && php -m | grep -E 'redis|imagick'

# Crear usuario para la aplicación
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar código y establecer permisos
COPY --chown=www:www . /var/www/html

# Crear enlace simbólico de storage y permisos necesarios
RUN php artisan storage:link || true

# Instalamos las dependencias de Laravel y compilamos assets de producción
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install \
    && npm run prod \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Ajustar permisos finales
RUN chown -R www:www /var/www/html

USER www

EXPOSE 9000

# Arrancamos el servidor
CMD ["php-fpm"]
