# Guía de Despliegue - E-commerce de Joyas (Laravel)

Este documento detalla los pasos necesarios para desplegar el proyecto en un entorno de producción o staging. Dado que el proyecto cuenta con configuración de **Docker**, esta es la opción recomendada.

## 1. Requisitos Previos

Dependiendo del método de despliegue, necesitarás:

### Opción A: Despliegue con Docker (Recomendado)
- Docker instalado en el servidor.
- Docker Compose instalado.

### Opción B: Despliegue Tradicional (Servidor VPS/Ubuntu)
- **PHP 8.2** con extensiones necesarias (bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml).
- **MySQL 8.0** o superior.
- **Nginx** o **Apache**.
- **Composer**.
- **Node.js** y **NPM** (para compilar assets).

---

## 2. Pasos Comunes (Preparación)

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/bryanbr26/joyeriaTFG.git
   cd joyeriaTFG
   ```

2. **Configurar el entorno:**
   Copia el archivo de ejemplo y edita las variables de producción:
   ```bash
   cp .env.example .env
   ```
   *Edita el `.env` para establecer `APP_ENV=production`, `APP_DEBUG=false`, y las credenciales de la base de datos.*

---

## 3. Método 1: Despliegue con Docker (Más rápido)

El proyecto ya incluye un `docker-compose.yml` y un `Dockerfile`.

1. **Levantar los contenedores:**
   ```bash
   docker-compose up -d --build
   ```

2. **Instalar dependencias dentro del contenedor:**
   ```bash
   docker-compose exec app composer install --no-dev --optimize-autoloader
   ```

3. **Generar la clave de la aplicación:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

4. **Ejecutar migraciones:**
   ```bash
   docker-compose exec app php artisan migrate --force
   ```

---

## 4. Método 2: Despliegue Tradicional (Manual)

Si prefieres no usar Docker:

1. **Instalar dependencias de PHP:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. **Instalar y compilar dependencias de Frontend:**
   ```bash
   npm install
   npm run prod
   ```

3. **Generar clave y configurar permisos:**
   ```bash
   php artisan key:generate
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data .
   ```

4. **Migraciones y Enlace de Storage:**
   ```bash
   php artisan migrate --force
   php artisan storage:link
   ```

---

## 5. Optimización para Producción

Laravel ofrece comandos para acelerar la aplicación en producción. Ejecuta estos comandos cada vez que actualices el código:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 6. Configuración del Servidor Web (Nginx)

Asegúrate de apuntar el `root` del servidor a la carpeta `/public` del proyecto. Ejemplo de configuración base:

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/joyeriaTFG/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 7. Verificación Final

- Accede a la URL configurada.
- Verifica que el archivo `.env` tenga `APP_DEBUG=false`.
- Asegúrate de que las tareas programadas (si las hay) estén configuradas en el Crontab:
  `* * * * * cd /ruta-al-proyecto && php artisan schedule:run >> /dev/null 2>&1`
