program DeclaracionesMixtas;
{ Todas las variables son asignadas en su tipo correspondiente }
var
  texto: string;
  bandera: boolean;
  numero: integer;
  decimal: real;
begin
  texto := 'Hola mundo';
  bandera := true;
  numero := 42;
  decimal := 3.14159;
  
  if bandera then
    writeln(texto);
  
  writeln(numero);
  writeln(decimal)
end.
