program BubbleSort;
var
  arr: array[1..10] of integer;
  i, j, temp: integer;
begin
  for i := 1 to 10 do arr[i] := 10 - i;
  
  for i := 1 to 9 do
    for j := 1 to 10 - i do
      if arr[j] > arr[j + 1] then
      begin
        temp := arr[j];
        arr[j] := arr[j + 1];
        arr[j + 1] := temp;
      end;
      
  writeln('Ordenado.');
end.
