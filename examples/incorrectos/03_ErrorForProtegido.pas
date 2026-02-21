program ForProtegido;
{ ❌ Error: Intentar modificar el iterador protegido de un bucle FOR }
var
  i: integer;
  total: integer;
begin
  total := 0;
  for i := 1 to 10 do
  begin
    total := total + 5;
    { El analizador bloqueará la siguiente línea por intentar modificar su control interno }
    i := i + 1
  end;
  writeln(total)
end.
