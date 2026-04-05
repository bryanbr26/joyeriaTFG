@extends("layouts.layout")

@section("content")

<div class="container my-5">
    <h2 class="text-center mb-4">Personaliza tus Joyas</h2>

    <!-- Barra de herramientas -->
    <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap align-items-center">
        <!-- Botón lápiz para dibujo libre -->
        <button class="btn btn-outline-dark active" id="btn-lapiz" title="Dibujar con lápiz">
            <i class="bi bi-pencil-fill"></i> Dibujar
        </button>

        <!-- Botón texto: activa el modo texto para escribir en el canvas -->
        <button class="btn btn-outline-dark" id="btn-texto" title="Escribir texto">
            <i class="bi bi-fonts"></i> Escribir texto
        </button>

        <!-- Botón para subir una imagen desde el ordenador -->
        <label class="btn btn-outline-dark mb-0" title="Subir imagen">
            <i class="bi bi-image"></i> Subir imagen
            <input type="file" id="btn-imagen" accept="image/*" class="d-none">
        </label>

        <!-- Selector de color para lápiz y texto -->
        <input type="color" id="selector-color" value="#000000" class="form-control form-control-color" style="width:40px;" title="Color">

        <!-- Selector de tamaño de trazo / texto -->
        <select id="selector-tamano" class="form-select" style="width:auto;" title="Tamaño">
            <option value="2">Fino</option>
            <option value="3" selected>Normal</option>
            <option value="5">Grueso</option>
            <option value="16">Texto pequeño</option>
            <option value="24">Texto mediano</option>
            <option value="36">Texto grande</option>
            <option value="48">Texto muy grande</option>
        </select>

        <!-- Deshacer último trazo o acción -->
        <button class="btn btn-outline-secondary" id="btn-deshacer" title="Deshacer">
            <i class="bi bi-arrow-counterclockwise"></i> Deshacer
        </button>

        <!-- Borrar todo el contenido del canvas -->
        <button class="btn btn-outline-secondary" id="btn-limpiar" title="Limpiar todo">
            <i class="bi bi-trash3"></i> Limpiar
        </button>

        <!-- Descargar el diseño como imagen PNG -->
        <button class="btn btn-dark" id="btn-guardar" title="Descargar diseño">
            <i class="bi bi-download"></i> Guardar
        </button>
    </div>

    <!--
        Zona de dibujo: dos canvas superpuestos.
        - canvas-joya: el canvas principal donde se dibuja todo (dibujos, texto, imágenes)
        - canvas-cursor: canvas transparente encima, SOLO para mostrar el cursor parpadeante del texto.
          Así el cursor nunca se "quema" en el canvas principal.
    -->
    <div class="d-flex justify-content-center">
        <div id="canvas-contenedor" style="position:relative; display:inline-block;">
            <canvas id="canvas-joya" style="border:1px solid #ccc; background:#fff; display:block;"></canvas>
            <canvas id="canvas-cursor" style="position:absolute; top:0; left:0; pointer-events:none;"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    //Recogemos los dos canvas, el color y el texto del DOM
    const canvas = document.getElementById('canvas-joya');           // canvas principal de dibujo
    const ctx = canvas.getContext('2d');
    const canvasCursor = document.getElementById('canvas-cursor');   // canvas overlay solo para cursor "|"
    const ctxCursor = canvasCursor.getContext('2d');
    const selectorColor = document.getElementById('selector-color');
    const selectorTamano = document.getElementById('selector-tamano');

    //Tamaño del canvas en píxeles (área de dibujo)
    canvas.width = 900;
    canvas.height = 450;
    // El canvas del cursor tiene el mismo tamaño
    canvasCursor.width = 900;
    canvasCursor.height = 450;

    //Variables del estado
    let herramientaActual = 'lapiz';  // 'lapiz' o 'texto'
    let estaDibujando = false;        // controla si el ratón está pulsado dibujando
    let ultimoX = 0;                  // última posición X del ratón
    let ultimoY = 0;                  // última posición Y del ratón
    let pilaDeshacer = [];            // pila de estados (ImageData) para deshacer

    //Variables para el modo texto
    let textoActivo = false;          // indica si hay un texto siendo editado
    let textoPosX = 0;               // posición X donde se escribe el texto
    let textoPosY = 0;               // posición Y donde se escribe el texto
    let lineasTexto = [''];           // array de líneas de texto (soporta Enter para salto de línea)
    let estadoAntesDeTexto = null;    // ImageData del canvas ANTES de empezar a escribir (sin cursor ni texto)

    let cursorVisible = true;         // estado del parpadeo del cursor
    let intervaloCursor = null;       // referencia al setInterval del cursor

    //Guardamos el estado inicial (canvas vacío)
    guardarEstado();

    // =============================================
    //  FUNCIONES AUXILIARES
    // =============================================

    //Obtiene la posición del ratón/dedo sobre el canvas, teniendo en cuenta el escalado para que sea responsive
    function obtenerPosicion(e) {
        const rect = canvas.getBoundingClientRect();
        const escalaX = canvas.width / rect.width;
        const escalaY = canvas.height / rect.height;
        const clienteX = e.touches ? e.touches[0].clientX : e.clientX; //Si hay touch, coge el touch, si no, coge el clienteX
        const clienteY = e.touches ? e.touches[0].clientY : e.clientY; //Si hay touch, coge el touch, si no, coge el clienteY
        return {
            x: (clienteX - rect.left) * escalaX,
            y: (clienteY - rect.top) * escalaY
        };
    }

    //Guarda el estado actual del canvas principal en la pila de deshacer usando ImageData. Máximo 30 estados para no consumir demasiada memoria.
    function guardarEstado() {
        pilaDeshacer.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
        if (pilaDeshacer.length > 30) pilaDeshacer.shift();
    }

    //Devuelve el tamaño de fuente actual seleccionado. Si el valor del selector es <=5 (grosor de lápiz), usa 24px por defecto.
    function obtenerTamanoTexto() {
        const val = parseInt(selectorTamano.value);
        return val > 5 ? val : 24;
    }


    // =============================================
    //  SISTEMA DE TEXTO EN VIVO
    // =============================================
    //El texto se dibuja en el canvas PRINCIPAL
    //El cursor "|" se dibuja en el canvas OVERLAY


    //Restaura el estado previo al texto y pinta las líneas encima.
    //NO dibuja el cursor aquí (eso va en el overlay).
    function redibujarTexto() {
        if (!textoActivo || !estadoAntesDeTexto) return;

        // Restaurar el canvas al estado de antes de escribir (SÍNCRONO, sin race conditions)
        ctx.putImageData(estadoAntesDeTexto, 0, 0);

        // Dibujar cada línea de texto
        const tamano = obtenerTamanoTexto();
        ctx.font = tamano + 'px "Italiana", serif'; //Fuente por defecto
        ctx.fillStyle = selectorColor.value;
        ctx.textBaseline = 'top';

        for (let i = 0; i < lineasTexto.length; i++) {
            ctx.fillText(lineasTexto[i], textoPosX, textoPosY + i * (tamano + 4));
        }
    }

    //Dibuja o borra el cursor parpadeante en el canvas overlay para mostrarlo pero no pintarlo en el dibujo
    function dibujarCursor() {
        // Limpiar todo el overlay
        ctxCursor.clearRect(0, 0, canvasCursor.width, canvasCursor.height);

        if (!textoActivo || !cursorVisible) return;

        //Depende del tamaño y fuente seleccionado
        const tamano = obtenerTamanoTexto();
        ctxCursor.font = tamano + 'px "Italiana", serif';

        // Calcular posición del cursor al final de la última línea
        const lineaActual = lineasTexto[lineasTexto.length - 1];
        const anchoTexto = ctxCursor.measureText(lineaActual).width;
        const cursorX = textoPosX + anchoTexto + 2;
        const cursorY = textoPosY + (lineasTexto.length - 1) * (tamano + 4);

        // Dibujar la línea vertical "|"
        ctxCursor.beginPath();
        ctxCursor.moveTo(cursorX, cursorY);
        ctxCursor.lineTo(cursorX, cursorY + tamano);
        ctxCursor.strokeStyle = selectorColor.value;
        ctxCursor.lineWidth = 1.5;
        ctxCursor.stroke();
    }

    //Set interval de medio segundo para simular el parpadeo de |
    function iniciarParpadeo() {
        detenerParpadeo();
        cursorVisible = true;
        dibujarCursor();
        intervaloCursor = setInterval(() => {
            cursorVisible = !cursorVisible;
            dibujarCursor();
        }, 500);
    }

    //Detiene el set interval y limpia el canvas overlay
    function detenerParpadeo() {
        if (intervaloCursor) {
            clearInterval(intervaloCursor);
            intervaloCursor = null;
        }
        cursorVisible = false;
        ctxCursor.clearRect(0, 0, canvasCursor.width, canvasCursor.height);
    }

    //Confirma el texto escrito, lo guarda en el canvas principal y para el overlay
    function confirmarTexto() {
        if (!textoActivo) return;

        // 1. Parar el cursor inmediatamente (limpia el overlay)
        detenerParpadeo();

        // 2. Marcar como inactivo
        textoActivo = false;

        // 3. El texto ya está dibujado en el canvas principal por redibujarTexto(), así que solo necesitamos guardar el estado
        guardarEstado();

        // 4. Limpiar variables de texto
        lineasTexto = [''];
        estadoAntesDeTexto = null;
    }

    // =============================================
    //  EVENTOS DE DIBUJO CON LÁPIZ (RATÓN)
    // =============================================

    //Al pulsar, dependiendo la herramienta dibuja o coloca el cursor del texto
    canvas.addEventListener('mousedown', (e) => {
        // Si hay texto activo, confirmarlo primero
        if (textoActivo) {
            confirmarTexto();
        }

        if (herramientaActual === 'texto') {
            // En modo texto: fijar la posición donde se va a escribir
            const pos = obtenerPosicion(e);
            textoPosX = pos.x;
            textoPosY = pos.y;
            lineasTexto = [''];
            textoActivo = true;
            // Guardar el estado actual del canvas ANTES de escribir (síncrono)
            estadoAntesDeTexto = ctx.getImageData(0, 0, canvas.width, canvas.height);
            canvas.style.cursor = 'text';
            iniciarParpadeo();
            return;
        }

        if (herramientaActual !== 'lapiz') return;
        estaDibujando = true;
        const pos = obtenerPosicion(e);
        ultimoX = pos.x;
        ultimoY = pos.y;
    });

    //Evento para que dibuje en caso de estar en ese modo
    canvas.addEventListener('mousemove', (e) => {
        if (!estaDibujando) return;
        const pos = obtenerPosicion(e);
        ctx.beginPath();
        ctx.moveTo(ultimoX, ultimoY);
        ctx.lineTo(pos.x, pos.y);
        ctx.strokeStyle = selectorColor.value;
        ctx.lineWidth = parseInt(selectorTamano.value) <= 5 ? parseInt(selectorTamano.value) : 3;
        ctx.lineCap = 'round';
        ctx.stroke();
        ultimoX = pos.x;
        ultimoY = pos.y;
    });

    //Al soltar el ratón, deja de dibujar y guarda el estado
    canvas.addEventListener('mouseup', () => {
        if (estaDibujando) {
            estaDibujando = false;
            guardarEstado();
        }
    });

    //Al salir del canvas con el ratón pulsado, pausa el dibujo pero no guarda estado
    canvas.addEventListener('mouseleave', () => {
        if (estaDibujando) {
            estaDibujando = false;
        }
    });

    //Al volver a entrar en el canvas con el ratón pulsado, retoma el dibujo desde la nueva posición
    canvas.addEventListener('mouseenter', (e) => {
        if (e.buttons === 1 && herramientaActual === 'lapiz') {
            estaDibujando = true;
            const pos = obtenerPosicion(e);
            ultimoX = pos.x;
            ultimoY = pos.y;
        }
    });

    // =============================================
    //  EVENTOS DE DIBUJO CON LÁPIZ (TÁCTIL)
    // =============================================

    //Inicio del toque: igual que mousedown para lápiz
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        if (herramientaActual !== 'lapiz') return;
        estaDibujando = true;
        const pos = obtenerPosicion(e);
        ultimoX = pos.x;
        ultimoY = pos.y;
    }, { passive: false });

    //Movimiento del dedo: igual que mousemove
    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        if (!estaDibujando) return;
        const pos = obtenerPosicion(e);
        ctx.beginPath();
        ctx.moveTo(ultimoX, ultimoY);
        ctx.lineTo(pos.x, pos.y);
        ctx.strokeStyle = selectorColor.value;
        ctx.lineWidth = parseInt(selectorTamano.value) <= 5 ? parseInt(selectorTamano.value) : 3;
        ctx.lineCap = 'round';
        ctx.stroke();
        ultimoX = pos.x;
        ultimoY = pos.y;
    }, { passive: false });

    //Fin del toque: dejar de dibujar
    canvas.addEventListener('touchend', () => {
        if (estaDibujando) {
            estaDibujando = false;
            guardarEstado();
        }
    });

    // =============================================
    //  EVENTOS DEL TECLADO (MODO TEXTO)
    // =============================================

    //Usamoe eventos del teclado para ver que pulsa y ejecutar la accion correspondiente
    document.addEventListener('keydown', (e) => {
        if (!textoActivo) return;

        if (e.key === 'Backspace') {
            e.preventDefault();
            const lineaActual = lineasTexto[lineasTexto.length - 1];
            if (lineaActual.length > 0) {
                // Borrar último carácter de la línea actual
                lineasTexto[lineasTexto.length - 1] = lineaActual.slice(0, -1);
            } else if (lineasTexto.length > 1) {
                // Si la línea está vacía y hay más líneas, subir a la anterior
                lineasTexto.pop();
            }
            redibujarTexto();
            iniciarParpadeo();
        } else if (e.key === 'Enter') {
            // Salto de línea: añadir nueva línea vacía
            e.preventDefault();
            lineasTexto.push('');
            redibujarTexto();
            iniciarParpadeo();
        } else if (e.key === 'Escape') {
            // Escape: confirmar y salir del modo texto
            e.preventDefault();
            confirmarTexto();
        } else if (e.key.length === 1) {
            // Añadir carácter a la línea actual
            e.preventDefault();
            lineasTexto[lineasTexto.length - 1] += e.key;
            redibujarTexto();
            iniciarParpadeo();
        }
    });

    // =============================================
    //  BOTONES DE LA BARRA DE HERRAMIENTAS
    // =============================================

    //Botón Dibujar: activa el modo lápiz
    document.getElementById('btn-lapiz').addEventListener('click', () => {
        if (textoActivo) confirmarTexto();
        herramientaActual = 'lapiz';
        canvas.style.cursor = 'crosshair';
        document.getElementById('btn-lapiz').classList.add('active');
        document.getElementById('btn-texto').classList.remove('active');
    });

    //Botón Escribir texto: activa el modo texto
    document.getElementById('btn-texto').addEventListener('click', () => {
        if (textoActivo) confirmarTexto();
        herramientaActual = 'texto';
        canvas.style.cursor = 'text';
        document.getElementById('btn-texto').classList.add('active');
        document.getElementById('btn-lapiz').classList.remove('active');
    });

    //Botón Subir imagen: carga una imagen y la dibuja centrada en el canvas respetando las proporciones originales.
    document.getElementById('btn-imagen').addEventListener('change', (e) => {
        const archivo = e.target.files[0];
        if (!archivo) return;
        if (textoActivo) confirmarTexto();

        const img = new Image();
        img.onload = () => {
            const escala = Math.min(canvas.width / img.width, canvas.height / img.height, 1);
            const ancho = img.width * escala;
            const alto = img.height * escala;
            const x = (canvas.width - ancho) / 2;
            const y = (canvas.height - alto) / 2;
            ctx.drawImage(img, x, y, ancho, alto);
            guardarEstado();
        };
        img.src = URL.createObjectURL(archivo);
        e.target.value = '';
    });

    //Botón Deshacer: vuelve al estado anterior del canvas
    document.getElementById('btn-deshacer').addEventListener('click', () => {
        if (textoActivo) confirmarTexto();
        if (pilaDeshacer.length <= 1) return;
        pilaDeshacer.pop();
        ctx.putImageData(pilaDeshacer[pilaDeshacer.length - 1], 0, 0);
    });

    //Botón Limpiar: borra todo el contenido del canvas
    document.getElementById('btn-limpiar').addEventListener('click', () => {
        if (textoActivo) confirmarTexto();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        guardarEstado();
    });

    //Botón Guardar: descarga el diseño como imagen PNG
    document.getElementById('btn-guardar').addEventListener('click', () => {
        if (textoActivo) confirmarTexto();
        const enlace = document.createElement('a');
        enlace.download = 'mi-joya-personalizada.png';
        enlace.href = canvas.toDataURL('image/png');
        enlace.click();
    });
});
</script>

@endsection