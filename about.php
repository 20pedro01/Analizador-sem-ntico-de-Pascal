<?php
/**
 * ABOUT.PHP - Información del equipo desarrollador
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Sobre nosotros - Analizador Pascal</title>
    <?php include 'includes/head.php'; ?>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <section class="panel" style="animation: fadeIn 0.4s ease-out; text-align: center;">
        <h2 style="color: var(--purple-pale); margin-bottom: 20px;">Equipo Penguin 🐧</h2>
        <p style="font-size: 1.1rem; max-width: 800px; margin: 0 auto; line-height: 1.8;">
            Somos estudiantes del <strong>Instituto Tecnológico Superior de Valladolid</strong>.<br>
            Este proyecto fue desarrollado para la asignatura de <em>Lenguajes y Autómatas II</em>.
        </p>
        
        <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-top: 40px;">
            <div style="background: rgba(0,0,0,0.3); padding: 25px; border-radius: 12px; width: 330px; border: 1px solid var(--purple-main); transition: transform 0.3s; cursor: default;">
                <h3 style="color: white; margin-bottom: 10px; font-size: 1.2rem;">Pedro Cauich Pat</h3>
                <p style="color: var(--purple-light); font-size: 1rem; margin: 0;">Arquitectura Back-End</p>
            </div>
            <div style="background: rgba(0,0,0,0.3); padding: 25px; border-radius: 12px; width: 330px; border: 1px solid var(--purple-main); transition: transform 0.3s; cursor: default;">
                <h3 style="color: white; margin-bottom: 10px; font-size: 1.2rem;">Brenda Chan Xooc</h3>
                <p style="color: var(--purple-light); font-size: 1rem; margin: 0;">Arquitectura Front-End</p>
            </div>
            <div style="background: rgba(0,0,0,0.3); padding: 25px; border-radius: 12px; width: 330px; border: 1px solid var(--purple-main); transition: transform 0.3s; cursor: default;">
                <h3 style="color: white; margin-bottom: 10px; font-size: 1.2rem;">Danneshe Corona Noh</h3>
                <p style="color: var(--purple-light); font-size: 1rem; margin: 0;">Calidad y pruebas</p>
            </div>
            <div style="background: rgba(0,0,0,0.3); padding: 25px; border-radius: 12px; width: 330px; border: 1px solid var(--purple-main); transition: transform 0.3s; cursor: default;">
                <h3 style="color: white; margin-bottom: 10px; font-size: 1.2rem;">Reyna Estrella Dzul</h3>
                <p style="color: var(--purple-light); font-size: 1rem; margin: 0;">Documentación y presentación</p>
            </div>
        </div>
        
        <div style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <p style="color: var(--success-green); font-size: 1rem;">Docente: Maestro José Leonel Pech May</p>
            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Ingeniería en Sistemas Computacionales · 6° "C"</p>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

</div>

<style>
/* Efecto hover a las tarjetitas */
.panel > div > div:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(123, 47, 247, 0.4);
}
</style>

</body>
</html>
