program Redeclaraciones;
{ ❌ Error: Las redeclaraciones son tratadas como un asalto a la tabla de símbolos }
var
  clave_secreta: string;
  activado: boolean;
  clave_secreta: integer;
begin
  clave_secreta := 'ABCD';
  writeln(clave_secreta)
end.
