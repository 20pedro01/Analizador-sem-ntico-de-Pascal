Program Tabla;
Uses Crt;
Var
 N, X, R : integer;
Begin
 ClrScr;
 Write(' Que tabla desea: '); readln(N);
 For X:= 1 to 10 do
  Begin
   R:= N * X;
   Writeln(N, ' * ', X, ' = ', R);
  End;
 ReadKey;
End.
