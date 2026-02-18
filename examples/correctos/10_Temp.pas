program Temperature;
var
  celsius, fahrenheit: real;
begin
  write('Celsius: ');
  readln(celsius);
  fahrenheit := (celsius * 9 / 5) + 32;
  writeln('Fahrenheit: ', fahrenheit);
end.
