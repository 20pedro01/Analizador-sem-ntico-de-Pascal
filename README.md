# 🔮 Analizador Semántico para Pascal

## Lenguajes y Autómatas II

### Objetivo General

Desarrollar un software capaz de verificar que un código fuente escrito en Pascal cumple reglas semánticas, específicamente: **tipado de datos** y **detección de errores de ambigüedad**.

---

## 📋 Tabla de Contenidos

1. [Tecnologías utilizadas](#tecnologías-utilizadas)
2. [Arquitectura del sistema](#arquitectura-del-sistema)
3. [Instalación y ejecución](#instalación-y-ejecución)
4. [Estructura de archivos](#estructura-de-archivos)
5. [Componentes del sistema](#componentes-del-sistema)
6. [Validaciones semánticas](#validaciones-semánticas)
7. [Tabla de símbolos](#tabla-de-símbolos)
8. [Tabla de compatibilidad de tipos](#tabla-de-compatibilidad-de-tipos)
9. [Gramática soportada](#gramática-soportada)
10. [Evaluación y análisis crítico](#evaluación-y-análisis-crítico)
11. [Ejemplos de entrada y salida](#ejemplos-de-entrada-y-salida)

---

## 🛠 Tecnologías utilizadas

| Tecnología          | Uso                                           |
| -------------------- | --------------------------------------------- |
| **PHP 8.x**    | Lenguaje fuente del programa                  |
| **Pascal**     | Lenguaje analizado semánticamente            |
| **HTML5**      | Estructura de la interfaz web                 |
| **CSS3**       | Estilos visuales (tema morado, glassmorphism) |
| **JavaScript** | Interactividad del lado cliente               |

> **Nota**: No se utilizan frameworks ni librerías externas. Todo es PHP puro.

---

## 🏗 Arquitectura del sistema

El sistema sigue una arquitectura de pipeline (tubería) de compilación:

```
Código Pascal ──→ LEXER ──→ PARSER ──→ SEMANTIC ANALYZER ──→ Resultados
    (texto)       (tokens)   (AST)      (validaciones)     (tabla + errores)
```

### Principios de diseño

- **Separación de responsabilidades**: Cada fase está en un archivo independiente
- **Desacoplamiento**: Los módulos se comunican a través de interfaces claras (tokens, AST, tabla de símbolos)
- **ErrorHandler centralizado**: Todos los módulos reportan errores al mismo gestor

---

## 🚀 Instalación y Ejecución

### Opción A: Servidor integrado de PHP (recomendada)

```bash
cd "Analizador semántico Pascal"
php -S localhost:XXXX (sustituya las XXXX por la dirección real de su servidor)
```

Abra su navegador en: `http://localhost:XXXX` (sustituya las XXXX por la dirección real de su servidor)

### Opción B: WAMP/XAMPP

1. Copie la carpeta a `www/` (WAMP) o `htdocs/` (XAMPP)
2. Inicie Apache
3. Navegue a `http://localhost/Analizador semántico Pascal/`

### Pruebas por consola

```bash
php test.php
```

---

## 📁 Estructura de archivos

```
Analizador semántico Pascal/
│
├── index.php .................. Simulador (punto de entrada)
├── manual.php ................. Manual de usuario web
├── exposicion.php ............. Presentación interactiva
├── about.php .................. Sobre el equipo Penguin
├── README.md .................. Este archivo (documentación técnica)
│
├── assets/ .................... Recursos estáticos y multimedia
│   ├── css/styles.css ......... Estilos visuales (Glassmorphism)
│   ├── img/logo.png ........... Logo de la institución (ITSVA)
│   └── presentation/ .......... Archivos HTML de la presentación
│
├── core/ ...................... Núcleo del compilador (Backend PHP)
│   ├── lexer.php .............. Analizador léxico
│   ├── parser.php ............. Analizador sintáctico (AST)
│   ├── semanticAnalyzer.php ... Analizador semántico (Reglas R/A)
│   ├── symbolTable.php ........ Tabla de símbolos con scopes
│   └── errorHandler.php ....... Gestor centralizado de errores
│
├── includes/ .................. Componentes PHP modulares
│   ├── head.php ............... Metadatos y enlaces CSS
│   ├── header.php ............. Navegación superior común
│   └── footer.php ............. Pie de página y links rápidos
│
├── examples/ .................. Bancos de pruebas (20 casos)
│   ├── correctos/ ............. 10 ejemplos de compilación exitosa
│   └── incorrectos/ ........... 10 ejemplos con errores semánticos
│
└── docs/ ...................... Documentación de soporte
    ├── manual_usuario.html .... Manual web embebido
```

---

## 🧩 Componentes del sistema

### 1. Lexer (`core/lexer.php`)

**Responsabilidad**: Tokenización del código fuente.

Convierte el texto plano en una secuencia de tokens con tipo, valor y número de línea. Reconoce:

- Palabras reservadas de Pascal (program, var, begin, end, if, then, else, while, for, etc.)
- Identificadores y números (enteros y reales)
- Cadenas de texto (con comillas simples)
- Operadores y delimitadores
- Comentarios Pascal `{ }` y `(* *)`

### 2. Parser (`core/parser.php`)

**Responsabilidad**: Construcción del Árbol de Sintaxis Abstracta (AST).

Implementa un **parser descendente recursivo** que transforma la secuencia de tokens en un árbol jerárquico. Cada nodo del AST tiene un tipo (Program, Assignment, IfStatement, etc.) y contiene la información necesaria para el análisis semántico.

### 3. Analizador semántico (`core/semanticAnalyzer.php`) ★

**Responsabilidad**: Validación de TODAS las reglas semánticas.

Este es el **componente principal** del proyecto. Recorre el AST y ejecuta 19 validaciones diferentes organizadas en tres categorías: tipado, ambigüedad y tabla de símbolos.

### 4. Tabla de símbolos (`core/symbolTable.php`)

**Responsabilidad**: Almacenamiento y gestión de identificadores.

Implementa una estructura de tabla con scopes apilables (stack). Cada entrada contiene:

- Nombre del identificador
- Tipo de dato (integer, real, boolean, char, string)
- Scope (global, bloque_linea_N)
- Línea de declaración
- Estado de inicialización
- Categoría (variable, control_for)
- Conteo de usos (referencias)

### 5. Gestor de errores (`core/errorHandler.php`)

**Responsabilidad**: Centralizar errores de todas las fases.

Clasifica los errores por fase (léxico, sintáctico, semántico) y por severidad (error, warning). Proporciona formato unificado para la interfaz.

---

## ✅ Validaciones semánticas

### Tipado de datos (R1-R11)

| Código | Validación                            | Ejemplo                             |
| ------- | -------------------------------------- | ----------------------------------- |
| R1      | Compatibilidad en asignaciones         | `edad := 'texto'` → ❌           |
| R2      | Compatibilidad en ops aritméticas     | `3 + true` → ❌                  |
| R3      | Compatibilidad en ops relacionales     | `'abc' > 5` → ❌                 |
| R4      | Compatibilidad en ops lógicas         | `5 and true` → ❌                |
| R5      | Promoción integer → real             | `var r: real; r := 5` → ✅       |
| R6      | Prohibición real → integer           | `var i: integer; i := 3.14` → ❌ |
| R7      | Condiciones boolean en IF/WHILE/REPEAT | `if 42 then...` → ❌             |
| R8      | FOR control debe ser integer           | `var r: real; for r := ...` → ❌ |
| R9      | NOT solo con boolean                   | `not 5` → ❌                     |
| R10     | Negación solo con numéricos          | `-'texto'` → ❌                  |
| R11     | Tipo no reconocido en VAR              | `var x: entero;` → ❌            |

### Detección de ambigüedad (A1-A8)

| Código | Validación                   | Ejemplo                                                 |
| ------- | ----------------------------- | ------------------------------------------------------- |
| A1      | Redeclaración en mismo scope | `var x: integer; x: real;` → ❌                      |
| A2      | Shadowing entre scopes        | `x` declarada en global y en bloque → ⚠️           |
| A3      | Mismo nombre, diferente tipo  | `x: integer` (global) vs `x: real` (bloque) → ⚠️ |
| A4      | Variable no declarada         | `y := 10` (sin var y) → ❌                           |
| A5      | Variable no inicializada      | `writeln(x)` (x sin valor previo) → ⚠️             |
| A6      | Variable nunca utilizada      | `var x: integer;` (nunca se usa) → ⚠️              |
| A7      | Modificar variable FOR        | `for i := 1 to 10 do i := 5` → ❌                    |
| A8      | Contexto ambiguo              | Múltiples declaraciones del mismo nombre → ⚠️       |

---

## 📊 Tabla de símbolos

La tabla de símbolos contiene los siguientes campos para cada identificador:

| Campo         | Descripción                | Ejemplo       |
| ------------- | --------------------------- | ------------- |
| Identificador | Nombre de la variable       | `resultado` |
| Tipo          | Tipo de dato declarado      | `real`      |
| Scope         | Alcance donde fue declarada | `global`    |
| Línea        | Línea de declaración      | `4`         |
| Inicializada  | ¿Se le asignó un valor?   | `Sí`       |
| Categoría    | Tipo de símbolo            | `variable`  |
| Usos          | Veces que fue referenciada  | `3`         |

---

## 🔄 Tabla de compatibilidad de tipos

### Operaciones aritméticas

| Operación          | int ↔ int | int ↔ real | real ↔ real |
| ------------------- | ---------- | ----------- | ------------ |
| `+`, `-`, `*` | → integer | → real     | → real      |
| `/`               | → real    | → real     | → real      |
| `div`, `mod`    | → integer | ❌          | ❌           |

### Operaciones relacionales

| Operación                                  | int ↔ int | int ↔ real | real ↔ real | bool ↔ bool |
| ------------------------------------------- | ---------- | ----------- | ------------ | ------------ |
| `=`, `<>`, `<`, `>`, `<=`, `>=` | → boolean | → boolean  | → boolean   | → boolean   |

### Asignaciones permitidas

| De \ A            | integer | real       | boolean | char | string |
| ----------------- | ------- | ---------- | ------- | ---- | ------ |
| **integer** | ✅      | ✅ (promo) | ❌      | ❌   | ❌     |
| **real**    | ❌      | ✅         | ❌      | ❌   | ❌     |
| **boolean** | ❌      | ❌         | ✅      | ❌   | ❌     |
| **char**    | ❌      | ❌         | ❌      | ✅   | ✅     |
| **string**  | ❌      | ❌         | ❌      | ❌   | ✅     |

---

## 📝 Gramática soportada

El parser reconoce las siguientes construcciones de Pascal:

```
<programa>      ::= PROGRAM <id> [ ( <id_list> ) ] ; <uses>? <block> .
<uses>          ::= USES <id_list> ;
<block>         ::= <decl_part> <statement_part>
<decl_part>     ::= (<label_decl> | <const_decl> | <type_decl> | <var_decl> | <proc_decl> | <func_decl>)*
<const_decl>    ::= CONST (<id> = <expr> ;)+
<type_decl>     ::= TYPE (<id> = <type> ;)+
<var_decl>      ::= VAR (<id_list> : <type> ;)+
<proc_decl>     ::= PROCEDURE <id> [ ( <param_list> ) ] ; <block> ;
<func_decl>     ::= FUNCTION <id> [ ( <param_list> ) ] : <type_id> ; <block> ;
<param_list>    ::= [VAR|CONST] <id_list> : <type_id> (; [VAR|CONST] <id_list> : <type_id>)*
<type>          ::= <simple_type> | <array_type> | <string_type>
<simple_type>   ::= INTEGER | REAL | BOOLEAN | CHAR | STRING
<array_type>    ::= ARRAY [ <range> ] OF <type>
<string_type>   ::= STRING [ [ <int> ] ]
<statement_part>::= BEGIN <stmt_list> END
<stmt_list>     ::= <stmt> (; <stmt>)*
<stmt>          ::= <assign> | <proc_call> | <if> | <while> | <for> | <repeat> | <write> | <read> | <block>
<assign>        ::= <variable> := <expr>
<proc_call>     ::= <id> [ ( <expr_list> ) ]
<variable>      ::= <id> [ [ <expr> ] ]
<if>            ::= IF <expr> THEN <stmt> [ ELSE <stmt> ]
<while>         ::= WHILE <expr> DO <stmt>
<for>           ::= FOR <id> := <expr> (TO|DOWNTO) <expr> DO <stmt>
<repeat>        ::= REPEAT <stmt_list> UNTIL <expr>
<write>         ::= (WRITE|WRITELN) [ ( <write_args> ) ]
<read>          ::= (READ|READLN) [ ( <variable_list> ) ]
```

---

## 🔬 Evaluación y análisis crítico

### ¿El software resuelve el problema planteado?

**Sí.** El software cumple con los dos objetivos principales de la rúbrica:

1. **Tipado de datos**: Implementa 11 validaciones de tipos (R1-R11) cubriendo asignaciones, operaciones aritméticas, relacionales y lógicas. La tabla de compatibilidad está diseñada según las reglas de Pascal estándar (ISO 7185), incluyendo promoción automática integer→real y prohibición de narrowing real→integer.
2. **Detección de errores de ambigüedad**: Implementa 8 validaciones (A1-A8) que cubren desde la redeclaración básica hasta el shadowing entre scopes y la detección de variables con mismo nombre pero diferente tipo en distintos scopes.

### Fortalezas del sistema

- **Modularidad estricta**: Cada componente es independiente y testeable por separado. El lexer no conoce al parser, el parser no conoce al analizador semántico.
- **Mensajes de error descriptivos**: Cada error incluye la línea exacta, el tipo de problema, y una sugerencia de corrección cuando es posible.
- **Tabla de símbolos completa**: Incluye todos los campos solicitados (identificador, tipo, scope) más campos adicionales útiles (inicialización, categoría, conteo de usos).
- **Interfaz visual profesional**: No es una simple salida de texto, sino una interfaz web con diseño moderno que facilita la comprensión de los resultados.

### Limitaciones reconocidas

- **No genera código**: El pipeline se detiene en el análisis semántico, no incluye generación de código intermedio ni final, ya que esto está fuera del alcance del proyecto.
- **Tipos compuestos complejos**: Aunque soporta Arrays unidimensionales, no soporta Records ni Sets complejos.

### Análisis de resultados

El sistema fue probado con 20+ casos de prueba (`examples/test_cases.txt` y `test.php`) que cubren:

- Programas completamente válidos con múltiples estructuras
- Cada tipo de error semántico de forma aislada
- Combinaciones de múltiples errores en un mismo programa
- Casos límite como narrowing y variables de control FOR

En todos los casos, el analizador detectó correctamente los errores esperados y no produjo falsos positivos en programas válidos.

---

## 💡 Ejemplos de entrada y salida

### Escenario 1: Compilación exitosa

**Entrada:**

```pascal
program Calculadora;
var
  x, y: integer;
  resultado: real;
begin
  x := 10;
  y := 20;
  resultado := x + y;
  writeln(resultado)
end.
```

**Salida:**

- Tabla de Símbolos: 3 variables (x, y, resultado) correctamente tipadas
- Mensaje: ✅ "Compilación exitosa. Sin errores semánticos."

### Escenario 2: Lista de errores

**Entrada:**

```pascal
program Errores;
var
  x: integer;
  x: real;
begin
  nombre := 42;
  if x then writeln(z)
end.
```

**Salida:**

- ❌ Línea 4: Redeclaración de 'x' (ya declarada como 'integer' en línea 3)
- ❌ Línea 6: Variable 'nombre' no declarada
- ❌ Línea 7: Condición IF debe ser boolean, se obtuvo integer
- ❌ Línea 7: Variable 'z' no declarada

---

## 📖 Manual de usuario

Ver el archivo `docs/manual_usuario.txt` para instrucciones detalladas paso a paso con capturas de ejemplo.

---

*Proyecto desarrollado para Lenguajes y Autómatas II — 2026*
