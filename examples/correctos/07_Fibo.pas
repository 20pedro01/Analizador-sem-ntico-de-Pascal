program Fibonacci;
var
  n, first, second, next, c: integer;
begin
  n := 10;
  first := 0;
  second := 1;
  writeln('Fibonacci series:');
  for c := 0 to n do
  begin
    if c <= 1 then
      next := c
    else
    begin
      next := first + second;
      first := second;
      second := next;
    end;
    writeln(next);
  end;
end.
