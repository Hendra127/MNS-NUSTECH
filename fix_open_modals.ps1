$f = 'd:\NEWNUSTECH\resources\views\open.blade.php'
$lines = Get-Content $f -Encoding UTF8
# Keep lines 0-470 (1-471), insert placeholder, then keep lines 862+ (863+)
$new = $lines[0..470] + @('    {{-- FOREACH_MODALS_PLACEHOLDER --}}') + $lines[862..($lines.Length - 1)]
Set-Content $f $new -Encoding UTF8
Write-Host "Done. New line count: $($new.Length)"
