$f = 'd:\NEWNUSTECH\resources\views\close.blade.php'
$lines = Get-Content $f -Encoding UTF8
# Remove lines 390-550 (the modalInfo nested inside td) - 0-indexed: 389-549
# Keep lines 0-389 (before modal), then insert placeholder, then keep 550+ (@endif, </td>, etc.)
$new = $lines[0..388] + @('                                        {{-- CLOSE_MODAL_PLACEHOLDER --}}') + $lines[549..($lines.Length - 1)]
Set-Content $f $new -Encoding UTF8
Write-Host "Done. New line count: $($new.Length)"
