FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar e instalar GD con soporte JPEG y WebP (PNG viene por defecto)
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Verificar instalaciones
RUN php --version && composer --version && node --version

# Crear usuario para la aplicación
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar código y establecer permisos
COPY . /var/www/html
RUN chown -R www:www /var/www/html

# Cambiar al usuario www
USER www

# Establecer directorio de trabajo
WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]