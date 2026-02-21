program ArrayInvalido;
{ ❌ Error: Usar expresiones no enteras como clave de búsqueda en matrices }
var
  datos: array[1..10] of integer;
  clave: string;
begin
  clave := 'Cinco';
  
  { Error de tipo: el index siempre debe ser numérico ordinal }
  datos[clave] := 100
end.
