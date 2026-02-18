PROGRAM ErrorFor;
VAR i: INTEGER;
BEGIN
 FOR i := 1 TO 10 DO
 BEGIN
  i := 5; /* Error semántico: modificar variable de control */
 END;
END.
