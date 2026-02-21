program BucleFor;
{ El iterador no se módifica manualmente dentro del bucle }
var
  i: integer;
  suma: integer;
begin
  suma := 0;
  for i := 1 to 10 do
  begin
    suma := suma + i
  end;
  writeln(suma)
end.
