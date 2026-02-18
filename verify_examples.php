<?php
require_once __DIR__ . '/core/lexer.php';
require_once __DIR__ . '/core/parser.php';
require_once __DIR__ . '/core/semanticAnalyzer.php';
require_once __DIR__ . '/core/symbolTable.php';
require_once __DIR__ . '/core/errorHandler.php';

function checkFile($filepath, $shouldHaveErrors) {
    if (!file_exists($filepath)) {
        return ["status" => "MISSING", "message" => "File not found"];
    }
    
    $source = file_get_contents($filepath);
    
    $errorHandler = new ErrorHandler();
    
    try {
        $lexer = new Lexer($errorHandler);
        $tokens = $lexer->tokenize($source);

        $parser = new Parser($errorHandler);
        $ast = $parser->parse($tokens);

        if (!$errorHandler->hasErrors()) { // Only proceed to semantic analysis if parsing succeeded without critical errors?
             // Actually, the parser might have accumulated errors but continued?
             // The previous test.php continued regardless. Let's do the same.
            $symbolTable = new SymbolTable();
            $analyzer = new SemanticAnalyzer($symbolTable, $errorHandler);
            $analyzer->analyze($ast);
        }
    } catch (Exception $e) {
        // Capture crashes as errors
        return ["status" => "CRASH", "message" => $e->getMessage()];
    }

    $hasErrors = $errorHandler->hasErrors();
    $errorCount = count($errorHandler->getErrors());
    
    $result = [
        "file" => basename($filepath),
        "expected_errors" => $shouldHaveErrors,
        "actual_errors" => $errorCount,
        "details" => []
    ];

    if ($shouldHaveErrors && $hasErrors) {
        $result["status"] = "PASS";
    } elseif (!$shouldHaveErrors && !$hasErrors) {
        $result["status"] = "PASS";
    } else {
        $result["status"] = "FAIL";
        foreach ($errorHandler->getFormattedErrors() as $e) {
            $result["details"][] = "[Line " . $e['line'] . "] " . $e['message'];
        }
    }
    
    return $result;
}

$correctDir = __DIR__ . '/examples/correctos';
$incorrectDir = __DIR__ . '/examples/incorrectos';

$correctFiles = glob($correctDir . '/*.pas');
$incorrectFiles = glob($incorrectDir . '/*.pas');

echo "VERIFICACION DE EJEMPLOS PASCAL" . PHP_EOL;
echo "===============================" . PHP_EOL;

$passes = 0;
$fails = 0;

echo PHP_EOL . "--- Revisando CORRECTOS (Esperado: 0 errores) ---" . PHP_EOL;
foreach ($correctFiles as $file) {
    $res = checkFile($file, false);
    if ($res['status'] === 'PASS') {
        echo "[OK] " . $res['file'] . PHP_EOL;
        $passes++;
    } else {
        echo "[FALLO] " . $res['file'] . " - Encontró " . $res['actual_errors'] . " errores inesperados:" . PHP_EOL;
        foreach ($res['details'] as $msg) {
            echo "    " . $msg . PHP_EOL;
        }
        $fails++;
    }
}

echo PHP_EOL . "--- Revisando INCORRECTOS (Esperado: >0 errores) ---" . PHP_EOL;
foreach ($incorrectFiles as $file) {
    $res = checkFile($file, true);
    if ($res['status'] === 'PASS') {
        echo "[OK] " . $res['file'] . " (Errores encontrados: " . $res['actual_errors'] . ")" . PHP_EOL;
        $passes++;
    } else {
        echo "[FALLO] " . $res['file'] . " - NO encontró errores (Se esperaban errores)" . PHP_EOL;
        $fails++;
    }
}

echo PHP_EOL . "===============================" . PHP_EOL;
echo "Resumen: $passes PASARON, $fails FALLARON" . PHP_EOL;
