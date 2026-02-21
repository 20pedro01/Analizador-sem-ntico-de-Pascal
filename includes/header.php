<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="nebula-overlay"></div>
<header class="header">
    <h1> Analizador semántico Pascal</h1>
    <p class="subtitle">Lenguajes y Autómatas II</p>
    <nav class="nav-tabs">
        <a href="index.php" class="nav-tab <?= $current_page == 'index.php' ? 'active' : '' ?>">🚀 Simulador</a>
        <a href="manual.php" class="nav-tab <?= $current_page == 'manual.php' ? 'active' : '' ?>">📖 Manual de usuario</a>
        <a href="exposicion.php" class="nav-tab <?= $current_page == 'exposicion.php' ? 'active' : '' ?>">🖥️ Presentación</a>
        <a href="about.php" class="nav-tab <?= $current_page == 'about.php' ? 'active' : '' ?>">🐧 Sobre nosotros</a>
    </nav>
</header>
