# NUSTECH Remote Handler v9 - Manager Native
# File ini TIDAK boleh diedit manual. Digenerate oleh installer.
$url = $args[0]

# Auto-elevate ke Administrator
if (-NOT ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)) {
    Start-Process powershell.exe -ArgumentList "-WindowStyle Hidden -ExecutionPolicy Bypass -NonInteractive -File `"$PSCommandPath`" `"$url`"" -Verb RunAs -WindowStyle Hidden
    exit
}

# Sembunyikan jendela PowerShell ini secepatnya
Add-Type -Name 'WinHide' -Namespace 'NM' -MemberDefinition '[DllImport("user32.dll")] public static extern bool ShowWindow(IntPtr hWnd, int nCmdShow);' -ErrorAction SilentlyContinue
try { [NM.WinHide]::ShowWindow((Get-Process -Id $PID).MainWindowHandle, 0) | Out-Null } catch {}

$logFile = "C:\NUSTECH\remote.log"
function Log($msg) { Add-Content -Path $logFile -Value "$(Get-Date -Format 'HH:mm:ss') - $msg" }

try {
    Log "Script v9 started! Arguments: $url"
    
    $clean = $url -replace 'nusa-remote://', '' -replace 'nusa-remote:', ''
    if ($clean.EndsWith('/')) { $clean = $clean.Substring(0, $clean.Length - 1) }
    $params = $clean -split '___'
    Log "Params total: $($params.Count)"
    if ($params.Count -lt 4) { Log "Exiting: Less than 4 params! $clean"; exit }
    $tunnel = $params[0]
    $ip     = $params[1]
    $user   = $params[2]
    $pass   = $params[3]
    
    Log "Target Tunnel: $tunnel"

    # Cari wireguard.exe
    $wgDir = 'C:\Program Files\WireGuard'
    $wgExe = "$wgDir\wireguard.exe"
    if (-NOT (Test-Path $wgExe)) { 
        $wgDir = 'C:\Program Files (x86)\WireGuard'
        $wgExe = "$wgDir\wireguard.exe"
    }

    $confFile = "C:\NUSTECH\$tunnel.conf"
    $dpapiDir = "$wgDir\Data\Configurations"
    $dpapiFile = "$dpapiDir\$tunnel.conf.dpapi"
    $targetConf = "$dpapiDir\$tunnel.conf"

    if ((Test-Path $wgExe) -and (Test-Path $confFile)) {
        Log "WG EXE found. Conf: $confFile"
        
        # STEP 1: Tutup SEMUA WireGuard processes (UI + tunnel services)
        Log "Killing ALL wireguard processes..."
        Get-Process -Name "wireguard" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
        Start-Sleep -Seconds 2

        # STEP 2: Matikan dan uninstall semua tunnel services
        $runningTunnels = Get-Service -ErrorAction SilentlyContinue | Where-Object { $_.DisplayName -like '*WireGuard Tunnel:*' }
        Log "Found $(@($runningTunnels).Count) WG tunnel services."
        if ($runningTunnels) {
            foreach ($svc in @($runningTunnels)) {
                Log "Stopping + uninstalling service: $($svc.Name)"
                Stop-Service -Name $svc.Name -Force -ErrorAction SilentlyContinue
                Start-Sleep -Milliseconds 500
                if ($svc.Name -match '\$') {
                    $tName = ($svc.Name -split '\$')[1]
                    & "$wgExe" /uninstalltunnelservice $tName 2>$null
                }
            }
        }
        Start-Sleep -Seconds 1

        # STEP 3: Extra cleanup - uninstall target tunnel explicitly
        Log "Explicit uninstall of $tunnel..."
        & "$wgExe" /uninstalltunnelservice $tunnel 2>$null
        Start-Sleep -Seconds 1

        # STEP 4: HAPUS file DPAPI lama
        if (Test-Path $dpapiFile) {
            Log "Deleting old DPAPI file: $dpapiFile"
            Remove-Item -Path $dpapiFile -Force -ErrorAction SilentlyContinue
        }
        # Hapus juga .conf di data dir kalo ada
        if (Test-Path $targetConf) {
            Remove-Item -Path $targetConf -Force -ErrorAction SilentlyContinue
        }
        Start-Sleep -Milliseconds 500

        # STEP 5: Bersihkan encoding dan COPY conf ke WireGuard Data dir
        Log "Cleaning conf file encoding..."
        $rawLines = Get-Content $confFile
        $cleanContent = ($rawLines | ForEach-Object { $_.TrimEnd() }) -join "`r`n"
        $cleanContent = $cleanContent + "`r`n"
        # Tulis ulang file source
        [IO.File]::WriteAllBytes($confFile, [System.Text.Encoding]::ASCII.GetBytes($cleanContent))
        Log "Conf cleaned. Size: $((Get-Item $confFile).Length) bytes"

        # STEP 6: Install via /installtunnelservice DULU
        Log "Installing tunnel service from: $confFile"
        & "$wgExe" /installtunnelservice "$confFile"
        Start-Sleep -Seconds 3

        # STEP 7: Cek apakah service jalan
        $svcName = "WireGuardTunnel`$$tunnel"
        $svc = Get-Service -Name $svcName -ErrorAction SilentlyContinue
        if ($svc -and $svc.Status -eq 'Running') {
            Log "Service $svcName is Running! OK!"
        } else {
            Log "Service NOT running. Trying Manager approach..."
            # Uninstall service yg gagal
            & "$wgExe" /uninstalltunnelservice $tunnel 2>$null
            Start-Sleep -Seconds 1

            # Hapus dpapi lagi
            if (Test-Path $dpapiFile) { Remove-Item $dpapiFile -Force -ErrorAction SilentlyContinue }
            Start-Sleep -Milliseconds 500

            # COPY conf ke WireGuard Data/Configurations dir
            # WireGuard Manager akan auto-encrypt ke .dpapi saat dibuka
            if (-NOT (Test-Path $dpapiDir)) { New-Item -ItemType Directory -Path $dpapiDir -Force | Out-Null }
            Copy-Item -Path $confFile -Destination $targetConf -Force
            Log "Copied conf to: $targetConf"

            # Start WireGuard Manager terlebih dahulu
            Log "Starting WG Manager to auto-import..."
            Start-Process "$wgExe"
            Start-Sleep -Seconds 4

            # Coba install lagi setelah Manager aktif
            Log "Re-trying /installtunnelservice..."
            & "$wgExe" /installtunnelservice "$confFile"
            Start-Sleep -Seconds 3
            
            $svc = Get-Service -Name $svcName -ErrorAction SilentlyContinue
            if ($svc) {
                Log "After retry - Service status: $($svc.Status)"
                if ($svc.Status -ne 'Running') {
                    Log "Force starting..."
                    Start-Service -Name $svcName -ErrorAction SilentlyContinue
                    Start-Sleep -Seconds 2
                    $svc = Get-Service -Name $svcName -ErrorAction SilentlyContinue
                    Log "Final status: $($svc.Status)"
                }
            } else {
                Log "Service still not found. Manual activation required."
            }
        }

        # STEP 8: Buka WireGuard Manager UI (selalu buka)
        Log "Starting WG UI..."
        Start-Process "$wgExe"
    } else {
        Log "MISSING! wgExe: $wgExe (exists: $(Test-Path $wgExe)), conf: $confFile (exists: $(Test-Path $confFile))"
    }

    # Ping modem IP - tampilkan hasilnya di layar
    Write-Host ""
    Write-Host "  ======================================================" -ForegroundColor Cyan
    Write-Host "  Memeriksa koneksi ke $ip ..." -ForegroundColor Cyan
    Write-Host "  ======================================================" -ForegroundColor Cyan
    Write-Host ""
    Log "Pinging $ip ..."

    # Jalankan ping.exe langsung agar output terlihat di layar
    $pingOutput = & ping.exe -n 4 -w 1000 $ip 2>&1
    $pingOutput | ForEach-Object { Write-Host "  $_" }

    # Cek apakah ada reply (TTL= artinya ada balasan)
    $pingOk = ($pingOutput | Select-String -Pattern "TTL=" -Quiet)

    Write-Host ""
    if ($pingOk) {
        Write-Host "  [OK] Site $ip ONLINE!" -ForegroundColor Green
        Log "Ping OK - Site $ip is online."
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
            Write-Host "  [OK] Membuka WinBox ke $ip ..." -ForegroundColor Green
            Log "Opening Winbox at $wbPath"
            Start-Sleep -Seconds 1
            Start-Process "$wbPath" -ArgumentList $ip, $user, $pass
        } else {
            Write-Host "  [!] WinBox tidak ditemukan." -ForegroundColor Yellow
            Log "WinBox executable not found."
        }
    } else {
        Write-Host "  [X] Site $ip OFFLINE!" -ForegroundColor Red
        Log "Ping failed! Site $ip is offline."
        $wshell = New-Object -ComObject Wscript.Shell
        $wshell.Popup("Site OFFLINE! Tidak ada balasan ping dari IP $ip.`nPastikan perangkat menyala dan VPN terhubung.", 15, "NUSTECH Remote - Site Offline", 48) | Out-Null
    }
    
    Log "Script finished correctly."
} catch {
    Log "ERROR: $_"
} finally {
    # Selalu tutup jendela PowerShell setelah selesai (berhasil maupun gagal)
    exit
}
