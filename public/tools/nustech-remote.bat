@echo off
setlocal EnableDelayedExpansion
chcp 65001 >nul
title NUSTECH Remote Mikrotik
color 0B

:: ============================================
:: STEP 0: Request Administrator Privileges
:: ============================================
net session >nul 2>&1
if !errorlevel! neq 0 (
    echo  [!] Meminta Hak Akses Administrator...
    powershell -Command "Start-Process -FilePath '%0' -ArgumentList '%~1' -Verb RunAs"
    exit /b
)

:: ============================================
:: NUSTECH Remote Mikrotik - Protocol Handler
:: Format URL: nustech-remote://TUNNEL,IP,USER,PASS
:: ============================================

set "RAW_URL=%~1"
set "RAW_URL=!RAW_URL:nustech-remote://=!"
set "RAW_URL=!RAW_URL:nustech-remote:=!"
if "!RAW_URL:~-1!"=="/" set "RAW_URL=!RAW_URL:~0,-1!"

:: Simple URL Decoding for common characters
set "RAW_URL=!RAW_URL:%%2C=,!"
set "RAW_URL=!RAW_URL:%%20= !"

:: Parse parameter (delimiter changed to comma)
for /f "tokens=1,2,3,4 delims=," %%A in ("!RAW_URL!") do (
    set "TUNNEL=%%A"
    set "IP=%%B"
    set "USER=%%C"
    set "PASS=%%D"
)

:: Validasi parameter
if "!TUNNEL!"=="" (
    echo  [ERROR] Parameter tidak valid.
    echo  Format: nustech-remote://TUNNEL^|IP^|USER^|PASS
    pause
    exit /b 1
)

echo.
echo  ╔══════════════════════════════════════════════════════╗
echo  ║        NUSTECH - Remote Mikrotik Otomatis           ║
echo  ╚══════════════════════════════════════════════════════╝
echo.
echo  IP     : !IP!
echo  User   : !USER!
echo  Tunnel : !TUNNEL!
echo.
echo ─────────────────────────────────────────────────────────
echo.

:: ============================================
:: STEP 1: Aktifkan WireGuard VPN
:: ============================================
echo  [1/3] Mengaktifkan VPN WireGuard tunnel "!TUNNEL!"...
echo.

set "WG_PATH="
if exist "C:\Program Files\WireGuard\wireguard.exe" (
    set "WG_PATH=C:\Program Files\WireGuard\wireguard.exe"
) else if exist "C:\Program Files (x86)\WireGuard\wireguard.exe" (
    set "WG_PATH=C:\Program Files (x86)\WireGuard\wireguard.exe"
)

if "!WG_PATH!"=="" (
    echo  [!] WireGuard tidak ditemukan.
    echo  [!] Silakan aktifkan VPN secara manual.
    echo  Tekan tombol apapun setelah VPN aktif...
    pause >nul
) else (
    echo  [OK] WireGuard ditemukan: !WG_PATH!
    
    :: Coba aktifkan via WireGuard service
    net start "WireGuardTunnel$!TUNNEL!" >nul 2>&1
    if !errorlevel! equ 0 (
        echo  [OK] Tunnel "!TUNNEL!" berhasil diaktifkan!
    ) else (
        :: Cek apakah sudah aktif
        sc query "WireGuardTunnel$!TUNNEL!" 2>nul | find "RUNNING" >nul 2>&1
        if !errorlevel! equ 0 (
            echo  [OK] Tunnel "!TUNNEL!" sudah aktif!
        ) else (
            echo  [..] Mencoba metode alternatif...
            
            :: Coba via installtunnelservice
            if exist "C:\Program Files\WireGuard\Data\Configurations\!TUNNEL!.conf.dpapi" (
                "!WG_PATH!" /installtunnelservice "C:\Program Files\WireGuard\Data\Configurations\!TUNNEL!.conf.dpapi"
                timeout /t 3 /nobreak >nul
                echo  [OK] Tunnel sedang diaktifkan...
            ) else (
                echo  [!] Config "!TUNNEL!" tidak ditemukan.
                echo  [!] Membuka WireGuard GUI...
                start "" "!WG_PATH!"
                echo  Aktifkan tunnel "!TUNNEL!" secara manual.
                echo  Tekan tombol apapun setelah VPN aktif...
                pause >nul
            )
        )
    )
)

echo.

:: ============================================
:: STEP 2: Tunggu Koneksi VPN
:: ============================================
echo  [2/3] Memeriksa koneksi ke !IP!...
echo.

set /a attempts=0
set /a max_attempts=30

:PING_LOOP
set /a attempts+=1
if !attempts! gtr !max_attempts! (
    echo.
    echo  [!] Timeout - tidak dapat terhubung ke !IP!
    echo  [!] Pastikan VPN aktif dan tunnel benar.
    echo.
    set /p "CONTINUE=  Tetap lanjut buka WinBox? (Y/N): "
    if /i not "!CONTINUE!"=="Y" (
        echo  Dibatalkan.
        timeout /t 3 /nobreak >nul
        exit /b
    )
    goto FIND_WINBOX
)

ping -n 1 -w 2000 !IP! >nul 2>&1
if errorlevel 1 (
    echo     [!attempts!/!max_attempts!] Menunggu koneksi ke !IP!...
    timeout /t 2 /nobreak >nul
    goto PING_LOOP
)

echo  [OK] Koneksi ke !IP! berhasil!
echo.

:: ============================================
:: STEP 3: Cari dan Jalankan WinBox
:: ============================================
:FIND_WINBOX
echo  [3/3] Mencari WinBox...
echo.

set "WINBOX_PATH="

for %%P in (
    "%USERPROFILE%\Downloads\winbox64.exe"
    "%USERPROFILE%\Downloads\winbox.exe"
    "%USERPROFILE%\Desktop\winbox64.exe"
    "%USERPROFILE%\Desktop\winbox.exe"
    "C:\Program Files\WinBox\winbox64.exe"
    "C:\Program Files\WinBox\winbox.exe"
    "C:\Program Files (x86)\WinBox\winbox64.exe"
    "C:\WinBox\winbox64.exe"
    "C:\WinBox\winbox.exe"
    "%USERPROFILE%\Documents\winbox64.exe"
    "%USERPROFILE%\Documents\winbox.exe"
) do (
    if exist %%P (
        set "WINBOX_PATH=%%~P"
        goto FOUND_WINBOX
    )
)

echo  [!] WinBox tidak ditemukan.
echo.
set /p "WINBOX_PATH=  Masukkan path winbox.exe: "

if not exist "!WINBOX_PATH!" (
    echo  [!] File tidak ditemukan. Membuka WebFig...
    start "" "http://!IP!"
    goto DONE
)

:FOUND_WINBOX
echo  [OK] WinBox: !WINBOX_PATH!
echo  Membuka WinBox ke !IP!...
start "" "!WINBOX_PATH!" "!IP!" "!USER!" "!PASS!"

:DONE
echo.
echo  ╔══════════════════════════════════════════════════════╗
echo  ║           Remote Mikrotik Berhasil!                 ║
echo  ╚══════════════════════════════════════════════════════╝
echo.
echo  Window akan tertutup dalam 5 detik...
timeout /t 5 /nobreak >nul
exit /b
