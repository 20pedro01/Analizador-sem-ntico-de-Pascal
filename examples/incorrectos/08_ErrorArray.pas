PROGRAM ErrorArray;
VAR 
 Arr: ARRAY[1..10] OF INTEGER;
 B: BOOLEAN;
BEGIN
 B := TRUE;
 Arr[B] := 5; /* Error semántico: índice inválido type boolean? (Pascal estricto requiere ordinal) */
 /* Nota: Si el analizador es permisivo con índices, esto puede pasar, pero lógicamente es incorrecto */
END.
