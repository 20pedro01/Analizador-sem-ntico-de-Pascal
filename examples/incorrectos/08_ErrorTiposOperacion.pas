program ErroresOperacionales;
{ ❌ Error: Choque fatal tratando de resolver operaciones incompatibles algebraicamente }
var
  x: integer;
  y: string;
  z: integer;
begin
  x := 10;
  y := 'Mundo';
  
  { Falla de tipo de datos al sumar string con int }
  z := x + y
end.
