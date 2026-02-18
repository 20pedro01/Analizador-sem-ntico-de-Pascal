program CircleArea;
const
  PI = 3.14159;
var
  radio, area: real;
begin
  write('Radio: ');
  readln(radio);
  area := PI * radio * radio;
  writeln('Area: ', area);
end.
