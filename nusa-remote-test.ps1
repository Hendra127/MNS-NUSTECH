# NUSTECH Remote Handler v8.1 - True Sync
# File ini TIDAK boleh diedit manual. Digenerate oleh installer.
$url = $args[0]

# Auto-elevate ke Administrator
if (-NOT ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)) {
    Start-Process powershell.exe -ArgumentList "-WindowStyle Hidden -ExecutionPolicy Bypass -NonInteractive -File `"$PSCommandPath`" `"$url`"" -Verb RunAs -WindowStyle Hidden
    exit
}

# Sembunyikan jendela PowerShell saat ini agar tidak terlihat oleh user
Add-Type -Name 'Win' -Namespace 'NativeMethods' -MemberDefinition @'
    [DllImport("user32.dll")]
    public static extern bool ShowWindow(IntPtr hWnd, int nCmdShow);
'@ -ErrorAction SilentlyContinue
try { [NativeMethods.Win]::ShowWindow((Get-Process -Id $PID).MainWindowHandle, 0) } catch {}

try {
    $clean = $url -replace 'nusa-remote://', '' -replace 'nusa-remote:', ''
    if ($clean.EndsWith('/')) { $clean = $clean.Substring(0, $clean.Length - 1) }
    $params = $clean -split '___'
    if ($params.Count -lt 4) { exit }
    $tunnel = $params[0]
    $ip     = $params[1]
    $user   = $params[2]
    $pass   = $params[3]

    # Cari wireguard.exe
    $wgExe = 'C:\Program Files\WireGuard\wireguard.exe'
    if (-NOT (Test-Path $wgExe)) { $wgExe = 'C:\Program Files (x86)\WireGuard\wireguard.exe' }
    $confFile = "C:\$tunnel.conf"

    if ((Test-Path $wgExe) -and (Test-Path $confFile)) {

        # STEP 1: Tutup WireGuard Manager UI saja (tunnel service TETAP jalan)
        # Tunnel service punya argument /tunnelservice, Manager UI tidak
        Get-CimInstance Win32_Process -Filter "Name = 'wireguard.exe'" -ErrorAction SilentlyContinue | ForEach-Object {
            if ($_.CommandLine -notmatch '/tunnelservice') {
                Stop-Process -Id $_.ProcessId -Force -ErrorAction SilentlyContinue
            }
        }
        Start-Sleep -Seconds 2

        # STEP 2: Matikan semua VPN WireGuard aktif lainnya agar UI tersinkronisasi (Inactive)
        $runningTunnels = Get-Service -Name 'WireGuardTunnel$*' -ErrorAction SilentlyContinue | Where-Object { $_.Status -eq 'Running' }
        foreach ($svc in $runningTunnels) {
            Stop-Service -Name $svc.Name -Force -ErrorAction SilentlyContinue
            Start-Sleep -Seconds 1
            $tName = $svc.Name.Substring(16)
            & "$wgExe" /uninstalltunnelservice $tName 2>$null
        }
        Start-Sleep -Seconds 1

        # STEP 3: Pastikan VPN target bersih lalu jalankan kembali
        & "$wgExe" /uninstalltunnelservice $tunnel 2>$null
        Start-Sleep -Seconds 1
        & "$wgExe" /installtunnelservice "$confFile"
        Start-Sleep -Seconds 3

        # STEP 4: Buka WireGuard Manager UI
        # Manager akan scan service yang aktif dan tampilkan HIJAU!
        Start-Process "$wgExe"
    }

    # Cari dan buka WinBox
    $wbPath = ''
    $searchPaths = @(
        'C:\WinBox\winbox64.exe',
        'C:\WinBox\winbox.exe',
        "$HOME\Downloads\winbox64.exe",
        "$HOME\Downloads\winbox.exe",
        'C:\Program Files\WinBox\winbox64.exe'
    )
    foreach ($loc in $searchPaths) {
        if (Test-Path $loc) { $wbPath = $loc; break }
    }
    if ($wbPath -ne '') {
        Start-Sleep -Seconds 2
        Start-Process "$wbPath" -ArgumentList $ip, $user, $pass
    }
} catch {
    # Silent exit on error
} finally {
    # Otomatis tutup jendela PowerShell ini setelah selesai (berhasil maupun gagal)
    exit
}
