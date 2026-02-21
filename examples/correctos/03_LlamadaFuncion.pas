program LlamadaFuncion;
{ Uso correcto de parámetros y valores de retorno }
var
  resultado: integer;

function Suma(a: integer; b: integer): integer;
begin
  Suma := a + b
end;

begin
  resultado := Suma(5, 10);
  writeln(resultado)
end.
