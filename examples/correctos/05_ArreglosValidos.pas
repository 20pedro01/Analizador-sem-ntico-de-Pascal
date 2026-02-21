program ArreglosValidos;
{ Uso de expresiones dinámicas tipo INTEGER en índices de arreglo }
var
  calificaciones: array[1..10] of integer;
  indice: integer;
begin
  indice := 5;
  calificaciones[indice] := 100;
  calificaciones[indice + 1] := 95;
  writeln(calificaciones[indice])
end.
