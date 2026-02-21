program AlcanceVariables;
{ Uso correcto de contextos globales y locales }
var
  global_var: string;

procedure LocalArea;
var
  local_var: integer;
begin
  local_var := 10;
  global_var := 'Accesible desde local';
  writeln(local_var)
end;

begin
  global_var := 'Iniciado';
  LocalArea;
  writeln(global_var)
end.
