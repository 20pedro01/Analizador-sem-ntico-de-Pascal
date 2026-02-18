PROGRAM NotasDeAlumnos;
uses crt;
Type
  alumnos = array [1..40] of string;
var
  Nombre, Apellido: alumnos;
  Nota: array [1..40] of real;
  i: integer;
Begin
  clrscr;
  For i:= 1 to 3 do
    begin
     write('Ingrese Nombre: '); readln(Nombre[i]);
     write('Ingrese Apellido: '); readln(Apellido[i]);
     write('Ingrese Nota: '); readln(Nota[i]);
    end;
  writeln('Proceso terminado.');
  readkey;
End.
