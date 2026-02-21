<?php
/**
 * EXPOSICION.PHP - Visor de la Presentación
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Presentación - Analizador Pascal</title>
    <?php include 'includes/head.php'; ?>
    <style>
        .presentation-container {
            width: 100%;
            height: 85vh; /* Regresado a un tamaño manejable para la página web */
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--glass-border);
            background: var(--purple-dark);
            margin-bottom: 24px;
            position: relative; /* Indispensable para botón superpuesto */
        }
        
        .presentation-frame {
            /* Truco CSS: Hacer que el canvas sea 25% más grande y luego escalarlo hacia abajo con zoom out (0.8) */
            width: 125%;
            height: 125%;
            transform: scale(0.8);
            transform-origin: 0 0;
            border: none;
            transition: all 0.3s ease;
        }

        /* Estilos aplicados cuando el contenedor entre en Modo Pantalla Completa nativo */
        .presentation-container:fullscreen {
            height: 100vh !important;
            border-radius: 0;
            border: none;
        }
        .presentation-container:fullscreen .presentation-frame {
            width: 100%;
            height: 100%;
            transform: scale(1); /* Volver al tamaño original al tener máximo espacio */
        }
        
        /* Compatibilidad extra navegadores */
        .presentation-container:-webkit-full-screen { height: 100vh; border-radius: 0; }
        .presentation-container:-webkit-full-screen .presentation-frame { width: 100%; height: 100%; transform: scale(1); }
        .presentation-container:-moz-full-screen { height: 100vh; border-radius: 0; }
        .presentation-container:-moz-full-screen .presentation-frame { width: 100%; height: 100%; transform: scale(1); }

        .btn-fullscreen {
            position: absolute;
            bottom: 25px;
            right: 25px;
            background: rgba(123, 47, 247, 0.85);
            color: white;
            border: 1px solid rgba(176, 124, 255, 0.5);
            padding: 12px 20px;
            border-radius: 30px;
            cursor: pointer;
            z-index: 100;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }

        .btn-fullscreen:hover {
            background: rgba(123, 47, 247, 1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="presentation-container" id="pres-container">
         <iframe src="assets/presentation/presentacion.html" class="presentation-frame"></iframe>
         
         <!-- Botón flotante para interactuar con Pantalla Completa -->
         <button class="btn-fullscreen" onclick="toggleFullScreen()">
            <span id="fs-icon">⛶</span> <span id="fs-text">Pantalla Completa</span>
         </button>
    </div>

    <?php include 'includes/footer.php'; ?>

</div>

<script>
// --- CONTROL DE PANTALLA COMPLETA ---
function toggleFullScreen() {
    var container = document.getElementById("pres-container");
    var btnText = document.getElementById("fs-text");
    var btnIcon = document.getElementById("fs-icon");

    if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
        // Ejecutar entrada a Fullscreen en el div contenedor
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.msRequestFullscreen) {
            container.msRequestFullscreen();
        } else if (container.mozRequestFullScreen) {
            container.mozRequestFullScreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        }
        btnText.innerText = "Salir del modo pantalla completa";
        btnIcon.innerText = "✖";
    } else {
        // Ejecutar salida de Fullscreen local
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
        btnText.innerText = "Pantalla Completa";
        btnIcon.innerText = "⛶";
    }
}

// Escuchamos el evento nativo por si el usuario presiona la tecla ESC
const events = ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'];
events.forEach(event => document.addEventListener(event, function() {
    var btnText = document.getElementById("fs-text");
    var btnIcon = document.getElementById("fs-icon");
    if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        btnText.innerText = "Pantalla Completa";
        btnIcon.innerText = "⛶";
    }
}));
</script>

</body>
</html>
