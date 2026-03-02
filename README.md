#  E-commerce de Joyas

E-commerce desarrollado con Laravel, Vue.js, Bootstrap 5 y Docker.

## Tecnologías Utilizadas

### Backend
- **Laravel 10** - Framework PHP
- **PHP 8.2** - Lenguaje de programación  
- **MySQL 8.0** - Base de datos
- **Redis** - Cache y sesiones
- **Laravel Fortify** - Autenticación y seguridad

### Frontend
- **Vue.js 3** - Interfaz dinámica (carrito de compras)
- **Bootstrap 5** - Diseño responsive
- **jQuery** - Utilidades y AJAX
- **Sass** - Estilos avanzados

### Infraestructura
- **Docker** - Contenedores
- **Nginx** - Servidor web
- **Mailhog** - Testing de emails

## Prerrequisitos

- **Docker** y **Docker Compose** instalados
- **Git** para clonar el repositorio

## Instalación y Configuración

### 1. Clonar el repositorio
```bash
git clone [https://github.com/bryanbr26/joyeriaTFG.git]
cd tfg-joyas
```

## Reparto de Tareas 

Para el desarrollo de este proyecto, se ha realizado un reparto de tareas dividido en:

### Diego Cuenca: Backend y Lógica de Negocio
- **Desarrollo Core**: Creación de controladores de Laravel para la gestión de productos, pedidos y usuarios.
- **Seguridad**: Implementación y configuración de **Laravel Fortify** para la autenticación segura.
- **Modelado**: Definición de la lógica de los modelos y sus métodos personalizados.

### Juan Adiego : Frontend y Experiencia de Usuario (UI/UX)
- **Interfaz Dinámica**: Desarrollo de componentes reactivos para el carrito de compras y gestión de favoritos.
- **Maquetación**: Diseño visual y responsive utilizando **Bootstrap 5** .
- **UX**: Implementación de validaciones en cliente y flujos de navegación intuitivos.

### Bryan Pérez: Infraestructura, Base de Datos y DevOps
- **Persistencia**: Diseño del esquema de base de datos, ejecución de migraciones y gestión de relaciones foráneas.
- **Entorno**: Configuración de los servicios cloud y entorno de desarrollo con **Docker** y Nginx.
- **Documentación**: Elaboración de la documentación técnica, diagramas de clase y manuales de entrega.


