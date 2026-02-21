program ErrorAmbiguedad;
{ ❌ Error: Shadowing, las variables se llaman igual pero difieren en su tipo base }
var
  token: integer;

procedure SubRuta;
var
  token: string;
begin
  token := 'Clave secreta';
  writeln(token)
end;

begin
  token := 10;
  SubRuta;
end.
