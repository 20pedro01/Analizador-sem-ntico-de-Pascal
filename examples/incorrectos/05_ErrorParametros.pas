program ErrorMisMatchParams;
{ ❌ Error: Argumentos ingresados en el orden incorrecto al subprograma }
var
  resultado: string;

procedure Registrar(id: integer; estatus: boolean);
begin
  writeln(id)
end;

begin
  { El primer parámetro debería ser INTEGER, no STRING }
  Registrar('Usuario_12', true)
end.
