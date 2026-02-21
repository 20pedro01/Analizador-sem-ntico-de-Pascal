program OperacionesLimpia;
{ Multiplicaciones mixtas evaluadas en el tipo promociable correcto }
var
  precio: real;
  cantidad: integer;
  total: real;
begin
  precio := 15.50;
  cantidad := 3;
  total := precio * cantidad;
  writeln(total)
end.
