program CicloWhile;
{ El ciclo cuenta y aumenta sin alterar otros tipos }
var
  contador: integer;
begin
  contador := 0;
  while contador < 5 do
  begin
    writeln(contador);
    contador := contador + 1
  end
end.
