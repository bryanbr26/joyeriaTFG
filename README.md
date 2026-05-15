# Joyas Pérez | E-commerce de joyería

Proyecto TFG de comercio electrónico para una maison de joyería. La web combina catálogo, carrito, favoritos, personalización de piezas, citas de orfebrería, contacto por correo, pagos y panel de administración en una experiencia visual cuidada y responsive.

## Identidad de la web

La interfaz está planteada con una estética de joyería boutique: fondos oscuros, tipografía editorial, detalles dorados, composiciones limpias y formularios sobrios. La experiencia busca que el usuario pueda explorar colecciones, personalizar joyas y contactar con el atelier sin fricción.

## Tecnologías utilizadas

### Backend

- **Laravel 10** como framework principal.
- **PHP 8.2** para la lógica de servidor.
- **MySQL 8.0** como base de datos relacional.
- **Laravel Fortify** para autenticación y recuperación de contraseña.
- **Redsys** para el flujo de pago seguro.
- **Mail** de Laravel para contacto y solicitudes de cita.
- **Storage public** para conservar grabados personalizados.

### Frontend

- **Blade** para las vistas.
- **Bootstrap 5** para estructura responsive.
- **Sass** para la capa visual por páginas y componentes.
- **JavaScript** para interacciones de catálogo, carrito, buscador, personalización y detalle de producto.
- **Vue.js 3** disponible en el stack para componentes dinámicos.
- **GSAP** para animaciones en vistas de producto.

### Infraestructura

- **Docker** y **Docker Compose** para entorno local.
- **Nginx** como servidor web.
- **Mailhog** para pruebas de correo.
- **Laravel Mix / Webpack** para compilar assets.

## Módulos principales

### Catálogo y detalle de producto

- Listado de joyas por categorías: collares, anillos, pulseras y pendientes.
- Vista general de joyería.
- Buscador de productos con recomendaciones.
- Detalle de producto con imagen principal y miniaturas.
- Precios visibles en tarjetas, recomendaciones y resultados para evitar scroll innecesario.
- Imágenes ajustadas para conservar proporción y nitidez.

### Carrito, favoritos y pedidos

- Carrito autenticado con control de cantidad, stock y subtotal.
- Panel lateral de carrito.
- Favoritos para guardar piezas.
- Checkout con Redsys.
- Historial de pedidos con detalle de productos y grabados personalizados.
- Imágenes del carrito y panel corregidas para evitar el efecto borroso permanente.

### Personalización de joyas y regalos

- Herramienta de personalización con grabado.
- Guardado de grabados como imagen en `storage/app/public/grabados`.
- Cada joya personalizada entra en el carrito como línea única.
- Selección adaptada a pantallas pequeñas con comportamiento equivalente al de joyería.
- Acceso protegido a grabados mediante rutas Laravel, evitando errores `404` por depender del enlace `public/storage`.

### Orfebrería

- Página de orfebrería con motivos visuales mejorados para mayor contraste.
- Formulario de solicitud de cita.
- Envío de correo real al destinatario configurado, siguiendo el flujo del formulario de contacto.
- Validación de nombre, email, teléfono, fecha, hora y motivo.

### Contacto

- Formulario de contacto conectado al envío de correo.
- Estilos ajustados para eliminar huecos visuales en escritorio y móvil.
- Ubicación actualizada a **Joyas Pérez - Soria, Castilla y León** con enlace a Google Maps.

### Autenticación

- Login con campo de contraseña correctamente en modo `password`.
- Registro con scroll vertical para pantallas de menor altura.
- Recuperación y reseteo de contraseña rediseñados para mantener la estética de la web.

### Administración

- Panel de administración para usuarios, productos, stock y pedidos.
- Vista de pedidos con acceso a grabados personalizados cuando existen.
- Gestión diferenciada por rol `admin`.

## Últimas mejoras incorporadas

- Actualización visual del favicon.
- Año actualizado a **2026**.
- Corrección del tamaño de imágenes secundarias en detalle de producto.
- Corrección de imágenes borrosas en carrito, favoritos, panel de carrito y pedidos.
- Rutas seguras para visualizar grabados guardados:
  - `grabados.carrito`
  - `grabados.pedido`
- Mejora de formularios de contacto, orfebrería y recuperación de contraseña.
- Ubicación de Joyas Pérez en Soria añadida a la página de contacto.
- Assets recompilados con Laravel Mix.

## Prerrequisitos

- **Docker** y **Docker Compose**.
- **Git**.
- **Node.js** y **npm** para compilar estilos y scripts.
- Dependencias PHP instaladas con Composer.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/bryanbr26/joyeriaTFG.git
cd joyeriaTFG
```

### 2. Configurar entorno

```bash
cp .env.example .env
```

Configurar en `.env` la base de datos, correo, Redsys y la URL de la aplicación. Para que los formularios envíen correctamente, revisar especialmente:

```env
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_TO_ADDRESS=
APP_URL=
```

### 3. Levantar servicios

```bash
docker compose up -d
```

### 4. Instalar dependencias

```bash
composer install
npm install
```

### 5. Preparar Laravel

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

> Los grabados personalizados ya se sirven también mediante rutas protegidas de Laravel, por lo que el enlace simbólico no es el único punto de acceso. Aun así, `storage:link` sigue siendo recomendable para assets públicos del proyecto.

### 6. Compilar assets

```bash
npm run dev
```

Para producción:

```bash
npm run prod
```

## Correos

El proyecto envía correo desde:

- Formulario de contacto.
- Formulario de cita de orfebrería.
- Recuperación y reseteo de contraseña.

En desarrollo puede usarse Mailhog. En producción debe configurarse un proveedor SMTP real.

## Grabados personalizados

Los grabados se guardan en el disco `public`, dentro de:

```text
storage/app/public/grabados
```

Para evitar errores `404` en entornos donde `public/storage` no esté disponible, las imágenes se muestran mediante rutas autenticadas. Solo puede ver un grabado:

- El usuario propietario del carrito o pedido.
- Un administrador.

## Reparto de tareas

### Diego Cuenca: Backend y lógica de negocio

- Desarrollo de controladores Laravel para productos, pedidos, carrito, personalización y usuarios.
- Implementación de autenticación con Laravel Fortify.
- Validaciones de formularios, stock, pedidos y grabados personalizados.
- Integración de correos y flujo de pago.

### Juan Adiego: Frontend y experiencia de usuario

- Maquetación responsive con Bootstrap 5 y Sass.
- Diseño visual de catálogo, detalle de producto, contacto, orfebrería y autenticación.
- Interacciones de carrito, favoritos, buscador y selección responsive.
- Ajustes de accesibilidad visual, contraste, scroll y presentación de precios.

### Bryan Pérez: Infraestructura, base de datos y DevOps

- Diseño del esquema de base de datos y relaciones.
- Configuración Docker, Nginx y servicios de desarrollo.
- Gestión de migraciones, seeders y documentación técnica.
- Preparación de entornos y guías de despliegue.

## Estado del proyecto

La web se encuentra en fase final de pulido: experiencia responsive, formularios conectados, carrito funcional, personalización de joyas, contacto con ubicación actualizada y mejoras visuales aplicadas para la entrega de 2026.
