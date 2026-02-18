<?php
/**
 * MANUAL.PHP - Visor del Manual de Usuario
 * Muestra el contenido de docs/manual_usuario.html embebido en la interfaz.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual de usuario - Analizador Pascal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .manual-content {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 40px;
            border-radius: var(--radius);
            font-family: 'Calibri', 'Arial', sans-serif; /* Fuente documento */
            line-height: 1.6;
        }
        
        /* Ajustes para el contenido del manual dentro del tema oscuro */
        .manual-content h1 { color: #2c3e50; border-bottom: 2px solid #3498db; }
        .manual-content h2 { color: #2980b9; margin-top: 30px; border-bottom: 1px solid #eee; }
        .manual-content h3 { color: #16a085; margin-top: 20px; }
        .manual-content code { background-color: #f8f9fa; color: #c7254e; padding: 2px 4px; }
        .manual-content pre { background-color: #f4f4f4; padding: 15px; border-left: 5px solid #3498db; }
        .manual-content table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .manual-content th, .manual-content td { border: 1px solid #ddd; padding: 10px; color: #333; }
        .manual-content th { background-color: #3498db; color: white; }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(123, 47, 247, 0.2);
            border: 1px solid rgba(176, 124, 255, 0.3);
            border-radius: 30px;
            color: var(--purple-pale);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .back-button:hover {
            background: rgba(123, 47, 247, 0.4);
            transform: translateX(-5px);
        }
    </style>
</head>
<body>

<div class="nebula-overlay"></div>

<div class="main-container">

    <header class="header">
        <h1>📖 Manual de usuario</h1>
        <p class="subtitle">Analizador semántico Pascal</p>
    </header>

    <a href="index.php" class="back-button">
        ← Volver al analizador
    </a>

    <section class="panel">
        <div class="manual-content">
            <?php 
            // Cargar contenido del body del HTML generado anteriormente
            $content = file_get_contents(__DIR__ . '/docs/manual_usuario.html');
            
            // Extraer solo lo que está dentro de <body>...</body> para inyectarlo aquí
            if (preg_match('/<body>(.*?)<\/body>/s', $content, $matches)) {
                echo $matches[1];
            } else {
                echo "<p>Error cargando el manual. Verifique que exista docs/manual_usuario.html</p>";
            }
            ?>
        </div>
    </section>

    <footer class="footer">
        Equipo Penguin · © · <?= date('Y') ?>
    </footer>

</div>

</body>
</html>
