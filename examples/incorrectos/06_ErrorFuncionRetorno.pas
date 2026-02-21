program ErrorReturn;
{ ❌ Error: Salir de la función sin asignar resultado al identificador original }
var
  calculo: integer;

function ObtenerValor(limite: integer): integer;
var
  local_val: integer;
begin
  local_val := limite * 2
  { Falta asignar valor de retorno: ObtenerValor := local_val }
end;

begin
  calculo := ObtenerValor(10);
  writeln(calculo)
end.
