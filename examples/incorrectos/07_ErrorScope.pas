PROGRAM ErrorScope;
PROCEDURE Test;
VAR Local: INTEGER;
BEGIN
 Local := 10;
END;
BEGIN
 Writeln(Local); /* Error semántico: variable fuera de scope */
END.
