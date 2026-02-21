program ErrorNarrowing;
{ ❌ Error: Fallo al asignar número REAL a variable genérica INTEGER }
var
  edad: integer;
  peso: real;
begin
  peso := 65.5;
  { Provoca error de Narrowing: Imposible asignar real a integer sin especificar truncamiento }
  edad := peso
end.
