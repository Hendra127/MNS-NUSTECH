# Fix encoding: re-read with proper encoding and re-write with UTF-8 BOM
$viewDir = 'd:\NEWNUSTECH\resources\views'
$files = Get-ChildItem -Path $viewDir -Filter '*.blade.php' -Recurse | Where-Object {
    $_.Name -ne 'pwa-head.blade.php' -and
    $_.Name -ne 'nav-modal-structure.blade.php' -and
    $_.Name -ne 'operasional-menu.blade.php'
}
$utf8BOM = New-Object System.Text.UTF8Encoding $true
$count = 0
foreach ($f in $files) {
    $content = [IO.File]::ReadAllText($f.FullName)
    if ($content -match 'pwa-head') {
        # Already has the include, just re-save with proper encoding
        [IO.File]::WriteAllText($f.FullName, $content, $utf8BOM)
        $count++
        Write-Host "Fixed encoding: $($f.Name)"
    }
}
Write-Host "Total files fixed: $count"
