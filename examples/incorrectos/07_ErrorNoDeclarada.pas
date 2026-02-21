program VariablesSueltas;
{ ❌ Error: Tratar de invocar variables que nunca fueron declaradas en el bloque root }
var
  oficial: integer;
begin
  oficial := 15;
  
  { Error: ilegal }
  extra := 20;

  writeln(extra)
end.
