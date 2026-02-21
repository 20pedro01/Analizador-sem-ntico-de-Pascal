program FalloCondicionIF;
{ ❌ Error: if requiere condicional logica o booleana, no int }
var
  nivel: integer;
begin
  nivel := 5;
  
  { En Pascal no es legal usar un entero en IF como condición verdadera }
  if nivel then
    writeln('Adentro')
end.
