program Factorial;
var
  num, res: integer;

function fact(n: integer): integer;
begin
  if n <= 1 then
    fact := 1
  else
    fact := n * fact(n - 1);
end;

begin
  write('Ingrese un numero: ');
  readln(num);
  res := fact(num);
  writeln('El factorial es: ', res);
end.
