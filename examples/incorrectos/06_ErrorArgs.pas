PROGRAM ErrorArgCount;
FUNCTION Suma(A, B: INTEGER): INTEGER;
BEGIN
 Suma := A + B;
END;
VAR R: INTEGER;
BEGIN
 R := Suma(10); /* Error semántico: faltan argumentos */
END.
