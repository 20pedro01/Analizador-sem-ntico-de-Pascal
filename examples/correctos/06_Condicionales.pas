program Condicionales;
{ Evaluación perfecta de Boolean en estructura IF }
var
  edad: integer;
  esMayor: boolean;
begin
  edad := 20;
  esMayor := edad >= 18;
  if esMayor then
    writeln('Es mayor de edad')
  else
    writeln('Es menor')
end.
