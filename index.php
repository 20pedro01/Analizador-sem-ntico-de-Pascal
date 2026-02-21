<?php
/**
 * INDEX.PHP - Interfaz Web Principal
 * 
 * Solo consume resultados del analizador. NO mezcla lógica del compilador.
 * Recibe el código Pascal, lo envía al pipeline de análisis y muestra resultados.
 */

// Incluir módulos del núcleo
require_once __DIR__ . '/core/lexer.php';
require_once __DIR__ . '/core/parser.php';
require_once __DIR__ . '/core/semanticAnalyzer.php';
require_once __DIR__ . '/core/symbolTable.php';
require_once __DIR__ . '/core/errorHandler.php';

$results = null;
$sourceCode = '';

// Procesar análisis cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Manejo de archivo subido
    if (isset($_FILES['pascal_file']) && $_FILES['pascal_file']['error'] === UPLOAD_ERR_OK) {
        $sourceCode = file_get_contents($_FILES['pascal_file']['tmp_name']);
    } else {
        $sourceCode = $_POST['source_code'] ?? '';
    }

    if (!empty(trim($sourceCode))) {
        $results = runAnalysis($sourceCode);
    }
}

/**
 * Ejecuta el pipeline completo: Lexer → Parser → Análisis Semántico
 */
function runAnalysis(string $source): array {
    $errorHandler = new ErrorHandler();
    
    // ═══ FASE 1: ANÁLISIS LÉXICO ═══
    $lexer = new Lexer($errorHandler);
    $tokens = $lexer->tokenize($source);
    
    // ═══ FASE 2: ANÁLISIS SINTÁCTICO ═══
    $parser = new Parser($errorHandler);
    $ast = $parser->parse($tokens);
    
    // ═══ FASE 3: ANÁLISIS SEMÁNTICO ═══
    $symbolTable = new SymbolTable();
    $semanticAnalyzer = new SemanticAnalyzer($symbolTable, $errorHandler);
    $semanticAnalyzer->analyze($ast);
    
    return [
        'symbols' => $symbolTable->getFormattedSymbols(),
        'errors' => $errorHandler->getFormattedErrors(),
        'hasErrors' => $errorHandler->hasCriticalErrors(),
        'errorCount' => $errorHandler->getErrorCount(),
        'tokenCount' => count($tokens) - 1, // -1 por EOF
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="description" content="Analizador Semántico para Pascal - Proyecto Académico de Lenguajes y Autómatas II">
    <title>Analizador semántico Pascal</title>
    <?php include 'includes/head.php'; ?>
</head>
<body>

<!-- Overlay de nebulosa -->
<div class="nebula-overlay"></div>

<div class="main-container">

    <!-- ═══ HEADER ═══ -->
    <?php include 'includes/header.php'; ?>

    <!-- ═══ PANEL DE ENTRADA DE CÓDIGO ═══ -->
    <section class="panel" id="input-panel">
        <div class="panel-title">
            <span class="icon">💻</span>
            Código fuente Pascal
        </div>

        <form method="POST" enctype="multipart/form-data" id="analysis-form">
            <div class="code-area-wrapper">
                <!-- Barra de terminal -->
                <div class="code-area-header">
                    <div class="terminal-dots">
                        <span class="dot-red"></span>
                        <span class="dot-yellow"></span>
                        <span class="dot-green"></span>
                    </div>
                    <span class="filename">programa.pas</span>
                </div>
                
                <!-- Área de código estilo terminal -->
                <textarea 
                    class="code-input" 
                    name="source_code" 
                    id="source-code"
                    placeholder="Escribe o pega tu código Pascal aquí...&#10;&#10;program MiPrograma;&#10;var&#10;  x: integer;&#10;begin&#10;  x := 10;&#10;  writeln(x);&#10;end."
                    spellcheck="false"
                ><?= htmlspecialchars($sourceCode) ?></textarea>
            </div>

            <!-- Botones de acción -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary" id="btn-analyze">
                    <span class="spinner"></span>
                    <span class="btn-text">🚀 Analizar</span>
                </button>

                <label class="btn btn-file" for="file-upload">
                    📂 Abrir archivo .pas
                </label>
                <input type="file" 
                       name="pascal_file" 
                       id="file-upload" 
                       class="file-input-hidden" 
                       accept=".pas,.txt,.p">

                <button type="button" class="btn btn-secondary" id="btn-clear">
                    🗑️ Limpiar
                </button>
            </div>

            <!-- Ejemplos rápidos -->
            <div style="margin-top: 16px;">
                <span style="font-size: 0.85rem; color: rgba(176,124,255,0.6);">Ejemplos rápidos:</span>
                <div class="example-buttons">
                    <button type="button" class="btn-example" onclick="loadExample('valid')">✅ Programa válido</button>
                    <button type="button" class="btn-example" onclick="loadExample('undeclared')">❌ Variable no declarada</button>
                    <button type="button" class="btn-example" onclick="loadExample('type_error')">❌ Error de tipos</button>
                    <button type="button" class="btn-example" onclick="loadExample('redeclare')">❌ Redeclaración</button>
                    <button type="button" class="btn-example" onclick="loadExample('ambiguity')">❌ Ambigüedad</button>
                    <button type="button" class="btn-example" onclick="loadExample('for_error')">❌ FOR protegido</button>
                    <button type="button" class="btn-example" onclick="loadExample('complex')">✅ Programa complejo</button>
                </div>
            </div>
        </form>
    </section>

    <?php if ($results !== null): ?>
    <!-- ═══ INFORMACIÓN DEL ANÁLISIS ═══ -->
    <section class="panel" id="info-panel">
        <div class="panel-title">
            <span class="icon">📊</span>
            Resumen del análisis
        </div>
        <div style="display: flex; gap: 24px; flex-wrap: wrap;">
            <div style="padding: 10px 20px; background: rgba(123,47,247,0.15); border-radius: 10px; text-align: center;">
                <div style="font-size: 1.6rem; font-weight: 700; color: var(--purple-light);"><?= $results['tokenCount'] ?></div>
                <div style="font-size: 0.78rem; color: rgba(176,124,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Tokens</div>
            </div>
            <div style="padding: 10px 20px; background: rgba(123,47,247,0.15); border-radius: 10px; text-align: center;">
                <div style="font-size: 1.6rem; font-weight: 700; color: var(--purple-light);"><?= count($results['symbols']) ?></div>
                <div style="font-size: 0.78rem; color: rgba(176,124,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Símbolos</div>
            </div>
            <div style="padding: 10px 20px; background: rgba(<?= $results['hasErrors'] ? '248,113,113' : '74,222,128' ?>,0.15); border-radius: 10px; text-align: center;">
                <div style="font-size: 1.6rem; font-weight: 700; color: <?= $results['hasErrors'] ? 'var(--error-red)' : 'var(--success-green)' ?>;"><?= $results['errorCount'] ?></div>
                <div style="font-size: 0.78rem; color: rgba(176,124,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Errores</div>
            </div>
        </div>
    </section>

    <!-- ═══ RESULTADOS EN GRID ═══ -->
    <div class="results-grid">

        <!-- Panel: Tabla de Símbolos -->
        <section class="panel" id="symbols-panel">
            <div class="panel-title">
                <span class="icon">📋</span>
                Tabla de símbolos
            </div>

            <?php if (!empty($results['symbols'])): ?>
            <div class="symbol-table-container">
                <table class="symbol-table" id="symbol-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Identificador</th>
                            <th>Tipo</th>
                            <th>Scope</th>
                            <th>Línea</th>
                            <th>Init</th>
                            <th>Categoría</th>
                            <th>Usos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results['symbols'] as $i => $sym): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><strong><?= htmlspecialchars($sym['name']) ?></strong></td>
                            <td>
                                <span class="type-badge type-<?= $sym['type'] ?>">
                                    <?= $sym['type'] ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($sym['scope']) ?></td>
                            <td><?= $sym['line'] ?></td>
                            <td><?= $sym['initialized'] ?></td>
                            <td><?= htmlspecialchars($sym['category']) ?></td>
                            <td><?= $sym['useCount'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>No se encontraron símbolos declarados.</p>
            </div>
            <?php endif; ?>
        </section>

        <!-- Panel: Errores Semánticos -->
        <section class="panel" id="errors-panel">
            <div class="panel-title">
                <span class="icon"><?= $results['hasErrors'] ? '🚨' : ($results['errorCount'] > 0 ? '⚠️' : '✅') ?></span>
                <?= $results['hasErrors'] ? 'Errores detectados' : ($results['errorCount'] > 0 ? 'Advertencias detectadas' : 'Resultado del análisis') ?>
            </div>

            <?php if ($results['errorCount'] === 0): ?>
                <!-- Compilación exitosa -->
                <div class="success-message">
                    <span class="success-icon">✅</span>
                    <div>
                        <strong>Compilación exitosa</strong><br>
                        <span style="font-size: 0.9rem; opacity: 0.8;">
                            El código Pascal no contiene errores semánticos.
                            Todos los tipos son compatibles y las variables están correctamente declaradas.
                        </span>
                    </div>
                </div>
            <?php elseif (!empty($results['errors'])): ?>
                <ul class="error-list" id="error-list">
                    <?php foreach ($results['errors'] as $error): ?>
                    <li class="error-item <?= $error['severity'] ?>">
                        <span class="error-icon"><?= $error['icon'] ?></span>
                        <div class="error-details">
                            <div class="error-msg"><?= htmlspecialchars($error['message']) ?></div>
                            <div class="error-meta">Línea <?= $error['line'] ?> · <?= $error['type'] ?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="success-message">
                    <span class="success-icon">✅</span>
                    <div><strong>Sin errores semánticos</strong></div>
                </div>
            <?php endif; ?>
        </section>

    </div>
    <?php endif; ?>
    <!-- ═══ FOOTER ═══ -->
    <?php include 'includes/footer.php'; ?>

</div>

<script>
// ─── Ejemplos de código Pascal ───
const examples = {
    valid: `program Ejemplo1;
var
  x, y: integer;
  resultado: real;
  activo: boolean;
begin
  x := 10;
  y := 20;
  resultado := x + y;
  activo := true;
  if activo then
    writeln(resultado);
  writeln('Programa ejecutado correctamente')
end.`,

    undeclared: `program ErrorNoDeclarada;
var
  x: integer;
begin
  x := 10;
  y := 20;
  z := x + y;
  writeln(z)
end.`,

    type_error: `program ErrorTipos;
var
  nombre: string;
  edad: integer;
  activo: boolean;
begin
  nombre := 'Juan';
  edad := 'veinte';
  activo := 42;
  nombre := edad + activo
end.`,

    redeclare: `program ErrorRedeclaracion;
var
  x: integer;
  y: real;
  x: string;
  y: boolean;
begin
  x := 10;
  y := 3.14
end.`,

    ambiguity: `program TestAmbiguedad;
var
  x: integer;
  y: real;
  x: string;
begin
  x := 10;
  y := 3.14;
  writeln(x);
  writeln(y)
end.`,

    for_error: `program TestForProtegido;
var
  i: integer;
  suma: integer;
begin
  suma := 0;
  for i := 1 to 10 do
  begin
    suma := suma + i;
    i := i + 2
  end;
  writeln(suma)
end.`,

    complex: `program Complejo;
var
  i, n, suma: integer;
  promedio: real;
  aprobado: boolean;
begin
  n := 10;
  suma := 0;

  for i := 1 to n do
    suma := suma + i;

  promedio := suma / n;
  aprobado := promedio >= 6;

  if aprobado then
    writeln('Aprobado con promedio: ', promedio)
  else
    writeln('Reprobado');

  i := 0;
  while i < 5 do
  begin
    writeln(i);
    i := i + 1
  end;

  repeat
    n := n - 1
  until n = 0;

  writeln('Fin del programa')
end.`
};

// Cargar ejemplo en el textarea
function loadExample(key) {
    const textarea = document.getElementById('source-code');
    textarea.value = examples[key];
    textarea.focus();
    textarea.scrollTop = 0;
}

// Limpiar textarea
document.getElementById('btn-clear').addEventListener('click', function() {
    document.getElementById('source-code').value = '';
    document.getElementById('source-code').focus();
});

// Al seleccionar archivo, mostrar nombre y auto-submit
document.getElementById('file-upload').addEventListener('change', function(e) {
    if (this.files.length > 0) {
        const fileName = this.files[0].name;
        document.querySelector('.filename').textContent = fileName;
        // Auto-enviar el formulario al cargar archivo
        document.getElementById('analysis-form').submit();
    }
});

// Spinner de carga
document.getElementById('analysis-form').addEventListener('submit', function() {
    document.getElementById('btn-analyze').classList.add('loading');
});

// Soporte para Tab dentro del textarea
document.getElementById('source-code').addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        e.preventDefault();
        const start = this.selectionStart;
        const end = this.selectionEnd;
        this.value = this.value.substring(0, start) + '  ' + this.value.substring(end);
        this.selectionStart = this.selectionEnd = start + 2;
    }
});
</script>

</body>
</html>
