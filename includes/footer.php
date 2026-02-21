<?php if (basename($_SERVER['PHP_SELF']) !== 'index.php'): ?>
    <div style="text-align: center; margin-top: 50px; margin-bottom: 20px;">
        <a href="index.php" class="nav-tab" style="color: var(--success-green); border: 1px solid rgba(74, 222, 128, 0.4); background: rgba(74, 222, 128, 0.1); font-size: 1.1rem; padding: 12px 35px; border-radius: 40px;">
            ← Volver al inicio (simulador)
        </a>
    </div>
<?php endif; ?>

<footer class="footer">
    Desarrollado por el equipo Penguin <span class="emoji">🐧</span><br>
    &copy; Copyright <?= date('Y') ?>
</footer>
