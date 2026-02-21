program PromocionSegura;
{ Ejemplo válido: Asignar INTEGER a REAL es Widening, lo cual está permitido. }
var
  entero: integer;
  decimal: real;
begin
  entero := 50;
  { Promoción segura: 50 -> 50.0 }
  decimal := entero; 
  writeln(decimal)
end.
