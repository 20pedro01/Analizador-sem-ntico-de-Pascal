PROGRAM ErrorIfCond;
VAR 
  X: INTEGER;
BEGIN
  X := 10;
  /* Error semántico: La condición del IF debe ser BOOLEAN, no INTEGER */
  IF X THEN 
    Writeln('Esto no debe compilar');
END.
