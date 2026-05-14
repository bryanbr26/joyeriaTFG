Crear un overlay de carga elegante que sea lo PRIMERO que vea el usuario al entrar a cualquier página, mostrando el logo de Joyas Pérez con una animación de pulso, y que SOLO desaparezca cuando absolutamente TODO el contenido de la página esté completamente cargado, renderizado y listo para interactuar. No debe desaparecer antes aunque parte del contenido ya sea visible.

📐 REQUISITOS DE IMPLEMENTACIÓN
1. HTML DEL LOADER
Ubicación: En el archivo resources/views/layouts/layout.blade.php, inmediatamente después de la etiqueta de apertura <body> y ANTES de cualquier include de header o contenido.

Estructura requerida:

Un div contenedor con ID page-loader que sea el primer elemento del body

Dentro, un contenedor centrado con el logo de Joyas Pérez

Debajo del logo, opcionalmente un spinner circular dorado

El logo debe ser el archivo SVG ubicado en public/images/logo.svg

Características visuales:

Fondo blanco que cubra TODA la pantalla

Logo centrado horizontal y verticalmente

El loader debe estar por encima de absolutamente todo (z-index máximo: 99999)

No debe tener bordes ni márgenes que dejen ver el contenido detrás

Debe cubrir el 100% del viewport (100vw × 100vh)

Usar position: fixed para que permanezca inmóvil aunque el usuario haga scroll

2. CSS DEL LOADER
Dividido en dos partes:

Parte A - Estilos críticos inline:

Colocar en el <head> del layout, dentro de una etiqueta <style>, ANTES de cualquier enlace a archivos CSS externos

Motivo: Debe renderizarse instantáneamente sin esperar a que se descargue el CSS externo

Debe incluir los estilos mínimos necesarios para que el loader se vea correctamente desde el primer milisegundo

Parte B - Estilos adicionales en SASS:

Crear o actualizar el partial resources/sass/components/_loader.scss

Importarlo en resources/sass/app.scss

Contener estilos adicionales no críticos y las animaciones de salida

Animaciones requeridas:

Animación de pulso en el logo: escala que va de 1.0 a 1.05 y vuelve a 1.0, con opacidad que varía de 1 a 0.8, duración 2 segundos, repetición infinita

Animación de giro en el spinner: rotación completa de 360 grados, duración 1 segundo, lineal, repetición infinita color gris

Transición de salida:

Crear una clase llamada loader-hidden

Debe tener opacidad cero y visibilidad hidden

La transición debe durar entre 600 y 800 milisegundos

Usar ease-out para que sea suave al final

Agregar pointer-events: none para que no bloquee la interacción con el contenido ya visible

3. JAVASCRIPT DEL LOADER - COMPORTAMIENTO CRÍTICO
Ubicación: En el archivo resources/js/app.js

REQUISITO FUNDAMENTAL:
El loader NO DEBE desaparecer hasta que la página esté COMPLETAMENTE cargada. Esto significa que debe esperar a:

Que todo el HTML esté parseado

Que todas las hojas de estilo (CSS) estén cargadas y aplicadas

Que todos los scripts (JavaScript) estén descargados y ejecutados

Que todas las imágenes estén completamente descargadas y renderizadas

Que todas las fuentes estén descargadas

Que todos los videos e iframes estén listos

Que todos los componentes Vue.js estén montados

Que todas las llamadas API iniciales hayan terminado

Estrategia de espera múltiple:

Paso 1 - Esperar al DOM:

Escuchar el evento DOMContentLoaded como primer checkpoint

En este punto el HTML está parseado pero pueden faltar recursos

Paso 2 - Esperar a la carga completa:

Escuchar el evento window.onload como checkpoint principal

Este evento garantiza que todas las imágenes, CSS, scripts y recursos estáticos están descargados

Pero NO garantiza que Vue.js haya terminado de renderizar componentes asíncronos

Paso 3 - Esperar a Vue.js (si aplica):

Si hay componentes Vue en la página, esperar a que estén completamente montados

Usar Vue.nextTick() o el evento mounted de los componentes principales

Esperar a que cualquier llamada API en created o mounted termine

Paso 4 - Esperar a recursos asíncronos adicionales:

Si hay imágenes con lazy loading que están en el viewport inicial, esperar a que carguen

Si hay fuentes web, esperar a document.fonts.ready

Si hay videos en el hero, esperar a que tengan suficientes datos para reproducirse

Paso 5 - Tiempo extra de seguridad:

Después de que TODOS los checkpoints anteriores se cumplan, agregar un retraso adicional de 300-500ms

Esto permite que el navegador termine cualquier renderizado pendiente

Garantiza que no haya parpadeos ni saltos visuales

Paso 6 - Animación de salida:

Solo después de completar TODOS los pasos anteriores, agregar la clase loader-hidden

Esperar a que termine la animación de salida (800ms)

Luego ocultar con display: none o eliminar el elemento del DOM

Mecanismo de seguridad (fallback):

Implementar un timeout máximo de 8 segundos (aumentado de 6 a 8 por la espera adicional)

Si después de 8 segundos el loader sigue visible por algún recurso bloqueado, ocultarlo forzosamente

Esto evita que el usuario quede atrapado eternamente si un recurso externo falla

Mostrar una advertencia en consola si se activa el fallback por timeout

Prevención de doble ejecución:

Usar una variable booleana loaderHidden para asegurar que la función de ocultación solo se ejecute una vez

Si ya se ocultó (por carga completa o por timeout), no volver a ejecutar

Verificación de recursos visibles:

Antes de ocultar el loader, verificar que las imágenes críticas (hero, logo, primeras imágenes del catálogo) estén completamente cargadas

Si alguna imagen crítica no cargó, esperar un poco más o proceder con el timeout

4. COMPORTAMIENTO EN DIFERENTES ESCENARIOS
Primera visita (sin caché):

El loader aparece instantáneamente al entrar

Permanece visible mientras se descargan y renderizan todos los recursos

Puede durar 2-5 segundos dependiendo de la conexión

NO desaparece antes aunque parte del contenido ya esté listo

Solo desaparece cuando TODO está completamente cargado y renderizado

Segunda visita (con caché):

El loader aparece instantáneamente

Como los recursos están en caché, todo carga en menos de 1 segundo

El loader desaparece rápidamente pero SIGUE esperando a que todo esté listo

La transición debe ser suave, no un parpadeo instantáneo

Conexión lenta (3G):

El loader permanece visible más tiempo

No desaparece aunque el header o parte del contenido ya sea visible detrás

Solo se oculta cuando las imágenes grandes y recursos pesados terminan de cargar

Si tarda más de 8 segundos, el fallback lo oculta

Error en algún recurso:

Si una imagen o recurso falla y nunca termina de cargar

El fallback de 8 segundos oculta el loader

La página se muestra aunque falte algún elemento

Se registra en consola qué recurso falló

Sin JavaScript:

Agregar un <noscript> justo después del loader

Que oculte el loader inmediatamente con CSS

Evita que usuarios sin JS vean el loader permanentemente

5. CONSIDERACIONES TÉCNICAS
Rendimiento:

El CSS inline debe ser mínimo (solo lo esencial) para no aumentar el tamaño del HTML

Las animaciones deben usar transform y opacity (propiedades GPU-accelerated)

No usar JavaScript para las animaciones de pulso y giro (solo CSS)

El logo SVG debe ser pequeño (menos de 10KB idealmente)

El loader no debe bloquear el parser de HTML (se renderiza primero, pero el contenido sigue cargando detrás)

Compatibilidad:

Debe funcionar en Chrome, Firefox, Safari, Edge (últimas 2 versiones)

En móviles (iOS Safari, Android Chrome) el loader debe verse correctamente

El logo debe ser responsive (100-120px en móvil, 150-180px en desktop)

La transición de salida debe ser fluida incluso en dispositivos de gama baja

Accesibilidad:

Agregar aria-hidden="true" al loader cuando esté visible

Agregar role="alert" y aria-live="polite" para anunciar cuando desaparece

El contenido real de la página debe ser accesible aunque el loader esté visible encima

No interferir con:

La funcionalidad existente de mega-menú, buscador y navbar

Los scripts de páginas específicas que se cargan con @push

El funcionamiento de Vue.js y Bootstrap

El BrowserSync en desarrollo

Los tokens CSRF de Laravel

Precarga del logo:

Agregar en el <head> del layout un link de precarga para el logo SVG

<link rel="preload" href="/images/logo.svg" as="image">

Esto asegura que el logo se descargue con prioridad máxima

6. ARCHIVOS QUE DEBES MODIFICAR O CREAR
Modificar:

resources/views/layouts/layout.blade.php - Agregar HTML del loader, CSS inline en head, precarga del logo, noscript fallback

resources/js/app.js - Agregar lógica completa de espera y ocultación del loader con todos los checkpoints

resources/sass/app.scss - Importar el partial del loader si se crea

Crear (opcional):

resources/sass/components/_loader.scss - Estilos SASS adicionales del loader

Verificar:

public/images/logo.svg - Confirmar que el logo existe y es accesible

7. RESULTADO FINAL ESPERADO
Cuando el usuario entre a cualquier página del sitio:

Verá inmediatamente una pantalla blanca con el logo de Joyas Pérez en el centro

El logo tendrá un sutil efecto de pulso (respiración)

Debajo del logo habrá un anillo dorado giratorio

La pantalla de carga PERMANECERÁ VISIBLE bloqueando la vista hasta que absolutamente TODO esté cargado

Aunque algo de contenido ya esté listo detrás, el loader no se quitará antes de tiempo

Cuando TODO esté completamente cargado y renderizado, la pantalla blanca se desvanecerá revelando la página completa y lista para usar

La transición será suave y elegante (600-800ms)

Si algo falla, después de 8 segundos el loader desaparece igualmente

En visitas posteriores, el loader desaparece muy rápido pero sin ser un parpadeo molesto

El usuario NUNCA verá la página a medio cargar o con elementos apareciendo desordenadamente

✅ CHECKLIST DE VERIFICACIÓN
Después de implementar, confirma que:

El loader es lo primero que aparece al cargar cualquier página

El logo se ve centrado y con la animación de pulso

El loader NO desaparece antes de tiempo aunque parte del contenido ya esté listo

El loader SOLO desaparece cuando TODO está completamente cargado

Al completar la carga total, el loader se desvanece en 600-800ms

Si se simula una conexión lenta (Slow 3G en DevTools), el loader permanece visible hasta que todo carga completamente

Las imágenes del hero y primeras imágenes del catálogo se muestran sin parpadeos

Si se bloquea un recurso, el loader desaparece a los 8 segundos

No hay errores en consola relacionados con el loader

El loader no interfiere con los otros scripts de la página

BrowserSync sigue funcionando en desarrollo

La página se ve completamente terminada cuando el loader desaparece (no siguen apareciendo elementos)

El usuario puede interactuar inmediatamente después de que el loader desaparezca

