<?php
/**
 * Script de prueba para verificar el pipeline completo.
 * Prueba las validaciones clave de la rúbrica.
 */

require_once __DIR__ . '/core/lexer.php';
require_once __DIR__ . '/core/parser.php';
require_once __DIR__ . '/core/semanticAnalyzer.php';
require_once __DIR__ . '/core/symbolTable.php';
require_once __DIR__ . '/core/errorHandler.php';

// ═══════════════════════════════════════════════════
echo "========================================" . PHP_EOL;
echo " PRUEBA 1: Programa valido completo" . PHP_EOL;
echo "========================================" . PHP_EOL;

$code1 = 'program Test;
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
  writeln(x, y)
end.';

runTest($code1);

// ═══════════════════════════════════════════════════
echo PHP_EOL . "========================================" . PHP_EOL;
echo " PRUEBA 2: Errores semanticos multiples" . PHP_EOL;
echo "========================================" . PHP_EOL;

$code2 = 'program ErrorTest;
var
  x: integer;
  nombre: string;
  x: real;
begin
  x := 10;
  nombre := 42;
  resultado := x + nombre;
  if x then
    writeln(z)
end.';

runTest($code2);

// ═══════════════════════════════════════════════════
echo PHP_EOL . "========================================" . PHP_EOL;
echo " PRUEBA 3: FOR con variable protegida" . PHP_EOL;
echo "========================================" . PHP_EOL;

$code3 = 'program ForTest;
var
  i, suma: integer;
begin
  suma := 0;
  for i := 1 to 10 do
  begin
    suma := suma + i;
    i := i + 2
  end;
  writeln(suma)
end.';

runTest($code3);

// ═══════════════════════════════════════════════════
echo PHP_EOL . "========================================" . PHP_EOL;
echo " PRUEBA 4: Tipado (real a integer)" . PHP_EOL;
echo "========================================" . PHP_EOL;

$code4 = 'program NarrowingTest;
var
  x: integer;
  y: real;
begin
  y := 3.14;
  x := y
end.';

runTest($code4);

// ═══════════════════════════════════════════════════
function runTest(string $source): void {
    $errorHandler = new ErrorHandler();
    $lexer = new Lexer($errorHandler);
    $tokens = $lexer->tokenize($source);

    $parser = new Parser($errorHandler);
    $ast = $parser->parse($tokens);

    $symbolTable = new SymbolTable();
    $analyzer = new SemanticAnalyzer($symbolTable, $errorHandler);
    $analyzer->analyze($ast);

    echo PHP_EOL . "--- TABLA DE SIMBOLOS ---" . PHP_EOL;
    echo sprintf("  %-12s | %-8s | %-10s | %-5s | %-4s | %-12s | %s",
        "Nombre", "Tipo", "Scope", "Linea", "Init", "Categoria", "Usos") . PHP_EOL;
    echo str_repeat("-", 78) . PHP_EOL;
    foreach ($symbolTable->getFormattedSymbols() as $s) {
        echo sprintf("  %-12s | %-8s | %-10s | %-5d | %-4s | %-12s | %d",
            $s['name'], $s['type'], $s['scope'], $s['line'],
            $s['initialized'], $s['category'], $s['useCount']) . PHP_EOL;
    }

    echo PHP_EOL . "--- RESULTADO ---" . PHP_EOL;
    if (!$errorHandler->hasErrors()) {
        echo "  COMPILACION EXITOSA - Sin errores semanticos" . PHP_EOL;
    } else {
        foreach ($errorHandler->getFormattedErrors() as $e) {
            echo "  " . $e['icon'] . " [Linea " . $e['line'] . " | " . $e['type'] . "] " . $e['message'] . PHP_EOL;
        }
    }
}
