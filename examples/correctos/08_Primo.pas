program IsPrime;
var
  n, i, flag: integer;
begin
  n := 29;
  flag := 1;
  for i := 2 to n div 2 do
  begin
    if (n mod i) = 0 then
      flag := 0;
  end;
  if flag = 1 then
    writeln(n, ' es primo')
  else
    writeln(n, ' no es primo');
end.
