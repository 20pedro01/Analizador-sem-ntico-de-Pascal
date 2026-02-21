program Completo;
{ Programa complejo validado donde hay scope, divisiones, for loops }
var
  i, acumulador: integer;
  promedio: real;
begin
  acumulador := 0;
  for i := 1 to 5 do
    acumulador := acumulador + i;
  
  promedio := acumulador / 5;
  writeln(promedio)
end.
