@echo off
setlocal DisableDelayedExpansion
chcp 65001 >nul
title NUSTECH - Remote Bridge Pro (v8.5 - DPAPI Shield)
color 0B

echo.
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo  ???     NUSTECH Remote Mikrotik - Installer (v8.5)     ???
echo  ???     -----------------------------------------      ???
echo  ???     MODE: AUTO SWITCH = Putus VPN lain, konek baru ???
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo.

:: Check Admin
net session >nul 2>&1
if errorlevel 1 (
    echo  [!] PERINGATAN: TIDAK BERJALAN SEBAGAI ADMINISTRATOR.
    echo.
    pause
    exit /b
)

set "WG_EXE=C:\Program Files\WireGuard\wireguard.exe"
if not exist "%WG_EXE%" set "WG_EXE=C:\Program Files (x86)\WireGuard\wireguard.exe"

:: 0. BERSIHKAN SERVICE LAMA
echo  [0/4] Membersihkan service lama...
"%WG_EXE%" /uninstalltunnelservice nustech_80 >nul 2>&1
"%WG_EXE%" /uninstalltunnelservice nustech_121 >nul 2>&1
"%WG_EXE%" /uninstalltunnelservice Client_80 >nul 2>&1
"%WG_EXE%" /uninstalltunnelservice client_00121 >nul 2>&1
"%WG_EXE%" /uninstalltunnelservice pasifiktel1-h47 >nul 2>&1
"%WG_EXE%" /uninstalltunnelservice pasifiktel2-h47 >nul 2>&1
timeout /t 2 >nul

:: 1. LOKASI INSTALASI + KONFIGURASI
if not exist "C:\NUSTECH" mkdir "C:\NUSTECH"

echo  [1/4] Membuat file konfigurasi VPN...

(
echo [Interface]
echo PrivateKey = qHaUbLxeJ75EXH8QrmBuoJalGo0Q1HW64/1osFR/7U8=
echo Address = 172.16.101.80/32
echo DNS = 8.8.8.8
echo.
echo [Peer]
echo PublicKey = a+0GwAQeIojgEiUrh4yFXvnjC65bxyPo1DXVu5XAY2M=
echo PresharedKey = 6+YFQGv9nkwI6Qe8DKgZhzRMRAiG0AZoQn58AXZkkcs=
echo AllowedIPs = 172.16.101.1/32, 10.0.0.0/8, 172.16.0.0/16
echo Endpoint = 203.83.27.12:13231
echo PersistentKeepalive = 10
) > "C:\NUSTECH\Client_80.conf"

(
echo [Interface]
echo PrivateKey = oDXwkxH1WH3JV4NbdAFccVI4lA2XdJviv8Z2LLk3uWs=
echo ListenPort = 13333
echo Address = 172.28.1.122/24
echo DNS = 202.95.128.180, 202.182.182.182
echo.
echo [Peer]
echo PublicKey = UbosTbRyZN6O/9b+dl86nma2wrKO6vBvi6AnEV73IRU=
echo AllowedIPs = 10.0.0.0/12, 10.16.0.0/12, 10.32.0.0/12, 10.48.0.0/12, 10.64.0.0/12, 10.80.0.0/12, 10.96.0.0/12, 10.112.0.0/12, 10.128.0.0/12, 10.144.0.0/12, 10.160.0.0/12, 10.176.0.0/12, 10.192.0.0/12, 10.208.0.0/12, 10.224.0.0/12, 10.240.0.0/12
echo Endpoint = 103.185.254.218:13303
echo PersistentKeepalive = 10
) > "C:\NUSTECH\client_00121.conf"

(
echo [Interface]
echo PrivateKey = gBmQ8W0uhhYiqDeyVYL25pu0sj99HXIxlJZc64xWl1E=
echo Address = 172.16.101.32/32
echo DNS = 8.8.8.8
echo.
echo [Peer]
echo PublicKey = a+0GwAQeIojgEiUrh4yFXvnjC65bxyPo1DXVu5XAY2M=
echo PresharedKey = 2DdTf/8H2EMbEgLCDZrKy48FJIIAQeSM9XGVDc6SJKU=
echo AllowedIPs = 172.16.101.1/32, 10.0.0.0/8, 172.16.0.0/16
echo Endpoint = 203.83.27.12:13231
echo PersistentKeepalive = 10
) > "C:\NUSTECH\pasifiktel1-h47.conf"

(
echo [Interface]
echo PrivateKey = 0BajsJoA66g6ufb0qwJlMpncwUFiBjRpYqoOtybidG8=
echo Address = 172.16.101.33/32
echo DNS = 8.8.8.8
echo.
echo [Peer]
echo PublicKey = a+0GwAQeIojgEiUrh4yFXvnjC65bxyPo1DXVu5XAY2M=
echo PresharedKey = w4z8gqQm5tbEPYTT+OjbhJ4/yft76f23afPUr0nwb7w=
echo AllowedIPs = 172.16.101.1/32, 10.0.0.0/8, 172.16.0.0/16
echo Endpoint = 203.83.27.12:13231
echo PersistentKeepalive = 10
) > "C:\NUSTECH\pasifiktel2-h47.conf"

:: 2. DOWNLOAD / BUAT HANDLER SCRIPT v8.5 Clean Slate
echo  [2/4] Membuat handler script v8.5...

:: Bikin langsung via powershell agar pasti dapat v8.5 Clean Slate terbaru
powershell -NoProfile -ExecutionPolicy Bypass -Command "[IO.File]::WriteAllBytes('C:\NUSTECH\nusa-remote.ps1', [Convert]::FromBase64String('IyBOVVNURUNIIFJlbW90ZSBIYW5kbGVyIHY5IC0gTWFuYWdlciBOYXRpdmUNCiMgRmlsZSBpbmkgVElEQUsgYm9sZWggZGllZGl0IG1hbnVhbC4gRGlnZW5lcmF0ZSBvbGVoIGluc3RhbGxlci4NCiR1cmwgPSAkYXJnc1swXQ0KDQojIEF1dG8tZWxldmF0ZSBrZSBBZG1pbmlzdHJhdG9yDQppZiAoLU5PVCAoW1NlY3VyaXR5LlByaW5jaXBhbC5XaW5kb3dzUHJpbmNpcGFsXVtTZWN1cml0eS5QcmluY2lwYWwuV2luZG93c0lkZW50aXR5XTo6R2V0Q3VycmVudCgpKS5Jc0luUm9sZShbU2VjdXJpdHkuUHJpbmNpcGFsLldpbmRvd3NCdWlsdEluUm9sZV06OkFkbWluaXN0cmF0b3IpKSB7DQogICAgU3RhcnQtUHJvY2VzcyBwb3dlcnNoZWxsLmV4ZSAtQXJndW1lbnRMaXN0ICItTm9FeGl0IC1FeGVjdXRpb25Qb2xpY3kgQnlwYXNzIC1GaWxlIGAiJFBTQ29tbWFuZFBhdGhgIiBgIiR1cmxgIiIgLVZlcmIgUnVuQXMNCiAgICBleGl0DQp9DQoNCiRsb2dGaWxlID0gIkM6XE5VU1RFQ0hccmVtb3RlLmxvZyINCmZ1bmN0aW9uIExvZygkbXNnKSB7IEFkZC1Db250ZW50IC1QYXRoICRsb2dGaWxlIC1WYWx1ZSAiJChHZXQtRGF0ZSAtRm9ybWF0ICdISDptbTpzcycpIC0gJG1zZyIgfQ0KDQp0cnkgew0KICAgIExvZyAiU2NyaXB0IHY5IHN0YXJ0ZWQhIEFyZ3VtZW50czogJHVybCINCiAgICANCiAgICAkY2xlYW4gPSAkdXJsIC1yZXBsYWNlICdudXNhLXJlbW90ZTovLycsICcnIC1yZXBsYWNlICdudXNhLXJlbW90ZTonLCAnJw0KICAgIGlmICgkY2xlYW4uRW5kc1dpdGgoJy8nKSkgeyAkY2xlYW4gPSAkY2xlYW4uU3Vic3RyaW5nKDAsICRjbGVhbi5MZW5ndGggLSAxKSB9DQogICAgJHBhcmFtcyA9ICRjbGVhbiAtc3BsaXQgJ19fXycNCiAgICBMb2cgIlBhcmFtcyB0b3RhbDogJCgkcGFyYW1zLkNvdW50KSINCiAgICBpZiAoJHBhcmFtcy5Db3VudCAtbHQgNCkgeyBMb2cgIkV4aXRpbmc6IExlc3MgdGhhbiA0IHBhcmFtcyEgJGNsZWFuIjsgZXhpdCB9DQogICAgJHR1bm5lbCA9ICRwYXJhbXNbMF0NCiAgICAkaXAgICAgID0gJHBhcmFtc1sxXQ0KICAgICR1c2VyICAgPSAkcGFyYW1zWzJdDQogICAgJHBhc3MgICA9ICRwYXJhbXNbM10NCiAgICANCiAgICBMb2cgIlRhcmdldCBUdW5uZWw6ICR0dW5uZWwiDQoNCiAgICAjIENhcmkgd2lyZWd1YXJkLmV4ZQ0KICAgICR3Z0RpciA9ICdDOlxQcm9ncmFtIEZpbGVzXFdpcmVHdWFyZCcNCiAgICAkd2dFeGUgPSAiJHdnRGlyXHdpcmVndWFyZC5leGUiDQogICAgaWYgKC1OT1QgKFRlc3QtUGF0aCAkd2dFeGUpKSB7IA0KICAgICAgICAkd2dEaXIgPSAnQzpcUHJvZ3JhbSBGaWxlcyAoeDg2KVxXaXJlR3VhcmQnDQogICAgICAgICR3Z0V4ZSA9ICIkd2dEaXJcd2lyZWd1YXJkLmV4ZSINCiAgICB9DQoNCiAgICAkY29uZkZpbGUgPSAiQzpcTlVTVEVDSFwkdHVubmVsLmNvbmYiDQogICAgJGRwYXBpRGlyID0gIiR3Z0RpclxEYXRhXENvbmZpZ3VyYXRpb25zIg0KICAgICRkcGFwaUZpbGUgPSAiJGRwYXBpRGlyXCR0dW5uZWwuY29uZi5kcGFwaSINCiAgICAkdGFyZ2V0Q29uZiA9ICIkZHBhcGlEaXJcJHR1bm5lbC5jb25mIg0KDQogICAgaWYgKChUZXN0LVBhdGggJHdnRXhlKSAtYW5kIChUZXN0LVBhdGggJGNvbmZGaWxlKSkgew0KICAgICAgICBMb2cgIldHIEVYRSBmb3VuZC4gQ29uZjogJGNvbmZGaWxlIg0KICAgICAgICANCiAgICAgICAgIyBTVEVQIDE6IFR1dHVwIFNFTVVBIFdpcmVHdWFyZCBwcm9jZXNzZXMgKFVJICsgdHVubmVsIHNlcnZpY2VzKQ0KICAgICAgICBMb2cgIktpbGxpbmcgQUxMIHdpcmVndWFyZCBwcm9jZXNzZXMuLi4iDQogICAgICAgIEdldC1Qcm9jZXNzIC1OYW1lICJ3aXJlZ3VhcmQiIC1FcnJvckFjdGlvbiBTaWxlbnRseUNvbnRpbnVlIHwgU3RvcC1Qcm9jZXNzIC1Gb3JjZSAtRXJyb3JBY3Rpb24gU2lsZW50bHlDb250aW51ZQ0KICAgICAgICBTdGFydC1TbGVlcCAtU2Vjb25kcyAyDQoNCiAgICAgICAgIyBTVEVQIDI6IE1hdGlrYW4gZGFuIHVuaW5zdGFsbCBzZW11YSB0dW5uZWwgc2VydmljZXMNCiAgICAgICAgJHJ1bm5pbmdUdW5uZWxzID0gR2V0LVNlcnZpY2UgLUVycm9yQWN0aW9uIFNpbGVudGx5Q29udGludWUgfCBXaGVyZS1PYmplY3QgeyAkXy5EaXNwbGF5TmFtZSAtbGlrZSAnKldpcmVHdWFyZCBUdW5uZWw6KicgfQ0KICAgICAgICBMb2cgIkZvdW5kICQoQCgkcnVubmluZ1R1bm5lbHMpLkNvdW50KSBXRyB0dW5uZWwgc2VydmljZXMuIg0KICAgICAgICBpZiAoJHJ1bm5pbmdUdW5uZWxzKSB7DQogICAgICAgICAgICBmb3JlYWNoICgkc3ZjIGluIEAoJHJ1bm5pbmdUdW5uZWxzKSkgew0KICAgICAgICAgICAgICAgIExvZyAiU3RvcHBpbmcgKyB1bmluc3RhbGxpbmcgc2VydmljZTogJCgkc3ZjLk5hbWUpIg0KICAgICAgICAgICAgICAgIFN0b3AtU2VydmljZSAtTmFtZSAkc3ZjLk5hbWUgLUZvcmNlIC1FcnJvckFjdGlvbiBTaWxlbnRseUNvbnRpbnVlDQogICAgICAgICAgICAgICAgU3RhcnQtU2xlZXAgLU1pbGxpc2Vjb25kcyA1MDANCiAgICAgICAgICAgICAgICBpZiAoJHN2Yy5OYW1lIC1tYXRjaCAnXCQnKSB7DQogICAgICAgICAgICAgICAgICAgICR0TmFtZSA9ICgkc3ZjLk5hbWUgLXNwbGl0ICdcJCcpWzFdDQogICAgICAgICAgICAgICAgICAgICYgIiR3Z0V4ZSIgL3VuaW5zdGFsbHR1bm5lbHNlcnZpY2UgJHROYW1lIDI+JG51bGwNCiAgICAgICAgICAgICAgICB9DQogICAgICAgICAgICB9DQogICAgICAgIH0NCiAgICAgICAgU3RhcnQtU2xlZXAgLVNlY29uZHMgMQ0KDQogICAgICAgICMgU1RFUCAzOiBFeHRyYSBjbGVhbnVwIC0gdW5pbnN0YWxsIHRhcmdldCB0dW5uZWwgZXhwbGljaXRseQ0KICAgICAgICBMb2cgIkV4cGxpY2l0IHVuaW5zdGFsbCBvZiAkdHVubmVsLi4uIg0KICAgICAgICAmICIkd2dFeGUiIC91bmluc3RhbGx0dW5uZWxzZXJ2aWNlICR0dW5uZWwgMj4kbnVsbA0KICAgICAgICBTdGFydC1TbGVlcCAtU2Vjb25kcyAxDQoNCiAgICAgICAgIyBTVEVQIDQ6IEhBUFVTIGZpbGUgRFBBUEkgbGFtYQ0KICAgICAgICBpZiAoVGVzdC1QYXRoICRkcGFwaUZpbGUpIHsNCiAgICAgICAgICAgIExvZyAiRGVsZXRpbmcgb2xkIERQQVBJIGZpbGU6ICRkcGFwaUZpbGUiDQogICAgICAgICAgICBSZW1vdmUtSXRlbSAtUGF0aCAkZHBhcGlGaWxlIC1Gb3JjZSAtRXJyb3JBY3Rpb24gU2lsZW50bHlDb250aW51ZQ0KICAgICAgICB9DQogICAgICAgICMgSGFwdXMganVnYSAuY29uZiBkaSBkYXRhIGRpciBrYWxvIGFkYQ0KICAgICAgICBpZiAoVGVzdC1QYXRoICR0YXJnZXRDb25mKSB7DQogICAgICAgICAgICBSZW1vdmUtSXRlbSAtUGF0aCAkdGFyZ2V0Q29uZiAtRm9yY2UgLUVycm9yQWN0aW9uIFNpbGVudGx5Q29udGludWUNCiAgICAgICAgfQ0KICAgICAgICBTdGFydC1TbGVlcCAtTWlsbGlzZWNvbmRzIDUwMA0KDQogICAgICAgICMgU1RFUCA1OiBCZXJzaWhrYW4gZW5jb2RpbmcgZGFuIENPUFkgY29uZiBrZSBXaXJlR3VhcmQgRGF0YSBkaXINCiAgICAgICAgTG9nICJDbGVhbmluZyBjb25mIGZpbGUgZW5jb2RpbmcuLi4iDQogICAgICAgICRyYXdMaW5lcyA9IEdldC1Db250ZW50ICRjb25mRmlsZQ0KICAgICAgICAkY2xlYW5Db250ZW50ID0gKCRyYXdMaW5lcyB8IEZvckVhY2gtT2JqZWN0IHsgJF8uVHJpbUVuZCgpIH0pIC1qb2luICJgcmBuIg0KICAgICAgICAkY2xlYW5Db250ZW50ID0gJGNsZWFuQ29udGVudCArICJgcmBuIg0KICAgICAgICAjIFR1bGlzIHVsYW5nIGZpbGUgc291cmNlDQogICAgICAgIFtJTy5GaWxlXTo6V3JpdGVBbGxCeXRlcygkY29uZkZpbGUsIFtTeXN0ZW0uVGV4dC5FbmNvZGluZ106OkFTQ0lJLkdldEJ5dGVzKCRjbGVhbkNvbnRlbnQpKQ0KICAgICAgICBMb2cgIkNvbmYgY2xlYW5lZC4gU2l6ZTogJCgoR2V0LUl0ZW0gJGNvbmZGaWxlKS5MZW5ndGgpIGJ5dGVzIg0KDQogICAgICAgICMgU1RFUCA2OiBJbnN0YWxsIHZpYSAvaW5zdGFsbHR1bm5lbHNlcnZpY2UgRFVMVQ0KICAgICAgICBMb2cgIkluc3RhbGxpbmcgdHVubmVsIHNlcnZpY2UgZnJvbTogJGNvbmZGaWxlIg0KICAgICAgICAmICIkd2dFeGUiIC9pbnN0YWxsdHVubmVsc2VydmljZSAiJGNvbmZGaWxlIg0KICAgICAgICBTdGFydC1TbGVlcCAtU2Vjb25kcyAzDQoNCiAgICAgICAgIyBTVEVQIDc6IENlayBhcGFrYWggc2VydmljZSBqYWxhbg0KICAgICAgICAkc3ZjTmFtZSA9ICJXaXJlR3VhcmRUdW5uZWxgJCR0dW5uZWwiDQogICAgICAgICRzdmMgPSBHZXQtU2VydmljZSAtTmFtZSAkc3ZjTmFtZSAtRXJyb3JBY3Rpb24gU2lsZW50bHlDb250aW51ZQ0KICAgICAgICBpZiAoJHN2YyAtYW5kICRzdmMuU3RhdHVzIC1lcSAnUnVubmluZycpIHsNCiAgICAgICAgICAgIExvZyAiU2VydmljZSAkc3ZjTmFtZSBpcyBSdW5uaW5nISBPSyEiDQogICAgICAgIH0gZWxzZSB7DQogICAgICAgICAgICBMb2cgIlNlcnZpY2UgTk9UIHJ1bm5pbmcuIFRyeWluZyBNYW5hZ2VyIGFwcHJvYWNoLi4uIg0KICAgICAgICAgICAgIyBVbmluc3RhbGwgc2VydmljZSB5ZyBnYWdhbA0KICAgICAgICAgICAgJiAiJHdnRXhlIiAvdW5pbnN0YWxsdHVubmVsc2VydmljZSAkdHVubmVsIDI+JG51bGwNCiAgICAgICAgICAgIFN0YXJ0LVNsZWVwIC1TZWNvbmRzIDENCg0KICAgICAgICAgICAgIyBIYXB1cyBkcGFwaSBsYWdpDQogICAgICAgICAgICBpZiAoVGVzdC1QYXRoICRkcGFwaUZpbGUpIHsgUmVtb3ZlLUl0ZW0gJGRwYXBpRmlsZSAtRm9yY2UgLUVycm9yQWN0aW9uIFNpbGVudGx5Q29udGludWUgfQ0KICAgICAgICAgICAgU3RhcnQtU2xlZXAgLU1pbGxpc2Vjb25kcyA1MDANCg0KICAgICAgICAgICAgIyBDT1BZIGNvbmYga2UgV2lyZUd1YXJkIERhdGEvQ29uZmlndXJhdGlvbnMgZGlyDQogICAgICAgICAgICAjIFdpcmVHdWFyZCBNYW5hZ2VyIGFrYW4gYXV0by1lbmNyeXB0IGtlIC5kcGFwaSBzYWF0IGRpYnVrYQ0KICAgICAgICAgICAgaWYgKC1OT1QgKFRlc3QtUGF0aCAkZHBhcGlEaXIpKSB7IE5ldy1JdGVtIC1JdGVtVHlwZSBEaXJlY3RvcnkgLVBhdGggJGRwYXBpRGlyIC1Gb3JjZSB8IE91dC1OdWxsIH0NCiAgICAgICAgICAgIENvcHktSXRlbSAtUGF0aCAkY29uZkZpbGUgLURlc3RpbmF0aW9uICR0YXJnZXRDb25mIC1Gb3JjZQ0KICAgICAgICAgICAgTG9nICJDb3BpZWQgY29uZiB0bzogJHRhcmdldENvbmYiDQoNCiAgICAgICAgICAgICMgU3RhcnQgV2lyZUd1YXJkIE1hbmFnZXIgdGVybGViaWggZGFodWx1DQogICAgICAgICAgICBMb2cgIlN0YXJ0aW5nIFdHIE1hbmFnZXIgdG8gYXV0by1pbXBvcnQuLi4iDQogICAgICAgICAgICBTdGFydC1Qcm9jZXNzICIkd2dFeGUiDQogICAgICAgICAgICBTdGFydC1TbGVlcCAtU2Vjb25kcyA0DQoNCiAgICAgICAgICAgICMgQ29iYSBpbnN0YWxsIGxhZ2kgc2V0ZWxhaCBNYW5hZ2VyIGFrdGlmDQogICAgICAgICAgICBMb2cgIlJlLXRyeWluZyAvaW5zdGFsbHR1bm5lbHNlcnZpY2UuLi4iDQogICAgICAgICAgICAmICIkd2dFeGUiIC9pbnN0YWxsdHVubmVsc2VydmljZSAiJGNvbmZGaWxlIg0KICAgICAgICAgICAgU3RhcnQtU2xlZXAgLVNlY29uZHMgMw0KICAgICAgICAgICAgDQogICAgICAgICAgICAkc3ZjID0gR2V0LVNlcnZpY2UgLU5hbWUgJHN2Y05hbWUgLUVycm9yQWN0aW9uIFNpbGVudGx5Q29udGludWUNCiAgICAgICAgICAgIGlmICgkc3ZjKSB7DQogICAgICAgICAgICAgICAgTG9nICJBZnRlciByZXRyeSAtIFNlcnZpY2Ugc3RhdHVzOiAkKCRzdmMuU3RhdHVzKSINCiAgICAgICAgICAgICAgICBpZiAoJHN2Yy5TdGF0dXMgLW5lICdSdW5uaW5nJykgew0KICAgICAgICAgICAgICAgICAgICBMb2cgIkZvcmNlIHN0YXJ0aW5nLi4uIg0KICAgICAgICAgICAgICAgICAgICBTdGFydC1TZXJ2aWNlIC1OYW1lICRzdmNOYW1lIC1FcnJvckFjdGlvbiBTaWxlbnRseUNvbnRpbnVlDQogICAgICAgICAgICAgICAgICAgIFN0YXJ0LVNsZWVwIC1TZWNvbmRzIDINCiAgICAgICAgICAgICAgICAgICAgJHN2YyA9IEdldC1TZXJ2aWNlIC1OYW1lICRzdmNOYW1lIC1FcnJvckFjdGlvbiBTaWxlbnRseUNvbnRpbnVlDQogICAgICAgICAgICAgICAgICAgIExvZyAiRmluYWwgc3RhdHVzOiAkKCRzdmMuU3RhdHVzKSINCiAgICAgICAgICAgICAgICB9DQogICAgICAgICAgICB9IGVsc2Ugew0KICAgICAgICAgICAgICAgIExvZyAiU2VydmljZSBzdGlsbCBub3QgZm91bmQuIE1hbnVhbCBhY3RpdmF0aW9uIHJlcXVpcmVkLiINCiAgICAgICAgICAgIH0NCiAgICAgICAgfQ0KDQogICAgICAgICMgU1RFUCA4OiBCdWthIFdpcmVHdWFyZCBNYW5hZ2VyIFVJIChzZWxhbHUgYnVrYSkNCiAgICAgICAgTG9nICJTdGFydGluZyBXRyBVSS4uLiINCiAgICAgICAgU3RhcnQtUHJvY2VzcyAiJHdnRXhlIg0KICAgIH0gZWxzZSB7DQogICAgICAgIExvZyAiTUlTU0lORyEgd2dFeGU6ICR3Z0V4ZSAoZXhpc3RzOiAkKFRlc3QtUGF0aCAkd2dFeGUpKSwgY29uZjogJGNvbmZGaWxlIChleGlzdHM6ICQoVGVzdC1QYXRoICRjb25mRmlsZSkpIg0KICAgIH0NCg0KICAgICMgUGluZyBtb2RlbSBJUCAtIHRhbXBpbGthbiBoYXNpbG55YSBkaSBsYXlhcg0KICAgIFdyaXRlLUhvc3QgIiINCiAgICBXcml0ZS1Ib3N0ICIgID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PSIgLUZvcmVncm91bmRDb2xvciBDeWFuDQogICAgV3JpdGUtSG9zdCAiICBNZW1lcmlrc2Ega29uZWtzaSBrZSAkaXAgLi4uIiAtRm9yZWdyb3VuZENvbG9yIEN5YW4NCiAgICBXcml0ZS1Ib3N0ICIgID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PSIgLUZvcmVncm91bmRDb2xvciBDeWFuDQogICAgV3JpdGUtSG9zdCAiIg0KICAgIExvZyAiUGluZ2luZyAkaXAgLi4uIg0KDQogICAgIyBKYWxhbmthbiBwaW5nLmV4ZSBsYW5nc3VuZyBhZ2FyIG91dHB1dCB0ZXJsaWhhdCBkaSBsYXlhcg0KICAgICRwaW5nT3V0cHV0ID0gJiBwaW5nLmV4ZSAtbiA0IC13IDEwMDAgJGlwIDI+JjENCiAgICAkcGluZ091dHB1dCB8IEZvckVhY2gtT2JqZWN0IHsgV3JpdGUtSG9zdCAiICAkXyIgfQ0KDQogICAgIyBDZWsgYXBha2FoIGFkYSByZXBseSAoVFRMPSBhcnRpbnlhIGFkYSBiYWxhc2FuKQ0KICAgICRwaW5nT2sgPSAoJHBpbmdPdXRwdXQgfCBTZWxlY3QtU3RyaW5nIC1QYXR0ZXJuICJUVEw9IiAtUXVpZXQpDQoNCiAgICBXcml0ZS1Ib3N0ICIiDQogICAgaWYgKCRwaW5nT2spIHsNCiAgICAgICAgV3JpdGUtSG9zdCAiICBbT0tdIFNpdGUgJGlwIE9OTElORSEiIC1Gb3JlZ3JvdW5kQ29sb3IgR3JlZW4NCiAgICAgICAgTG9nICJQaW5nIE9LIC0gU2l0ZSAkaXAgaXMgb25saW5lLiINCiAgICAgICAgIyBDYXJpIGRhbiBidWthIFdpbkJveA0KICAgICAgICAkd2JQYXRoID0gJycNCiAgICAgICAgJHNlYXJjaFBhdGhzID0gQCgNCiAgICAgICAgICAgICdDOlxXaW5Cb3hcd2luYm94NjQuZXhlJywNCiAgICAgICAgICAgICdDOlxXaW5Cb3hcd2luYm94LmV4ZScsDQogICAgICAgICAgICAiJEhPTUVcRG93bmxvYWRzXHdpbmJveDY0LmV4ZSIsDQogICAgICAgICAgICAiJEhPTUVcRG93bmxvYWRzXHdpbmJveC5leGUiLA0KICAgICAgICAgICAgJ0M6XFByb2dyYW0gRmlsZXNcV2luQm94XHdpbmJveDY0LmV4ZScNCiAgICAgICAgKQ0KICAgICAgICBmb3JlYWNoICgkbG9jIGluICRzZWFyY2hQYXRocykgew0KICAgICAgICAgICAgaWYgKFRlc3QtUGF0aCAkbG9jKSB7ICR3YlBhdGggPSAkbG9jOyBicmVhayB9DQogICAgICAgIH0NCiAgICAgICAgaWYgKCR3YlBhdGggLW5lICcnKSB7DQogICAgICAgICAgICBXcml0ZS1Ib3N0ICIgIFtPS10gTWVtYnVrYSBXaW5Cb3gga2UgJGlwIC4uLiIgLUZvcmVncm91bmRDb2xvciBHcmVlbg0KICAgICAgICAgICAgTG9nICJPcGVuaW5nIFdpbmJveCBhdCAkd2JQYXRoIg0KICAgICAgICAgICAgU3RhcnQtU2xlZXAgLVNlY29uZHMgMQ0KICAgICAgICAgICAgU3RhcnQtUHJvY2VzcyAiJHdiUGF0aCIgLUFyZ3VtZW50TGlzdCAkaXAsICR1c2VyLCAkcGFzcw0KICAgICAgICB9IGVsc2Ugew0KICAgICAgICAgICAgV3JpdGUtSG9zdCAiICBbIV0gV2luQm94IHRpZGFrIGRpdGVtdWthbi4iIC1Gb3JlZ3JvdW5kQ29sb3IgWWVsbG93DQogICAgICAgICAgICBMb2cgIldpbkJveCBleGVjdXRhYmxlIG5vdCBmb3VuZC4iDQogICAgICAgIH0NCiAgICB9IGVsc2Ugew0KICAgICAgICBXcml0ZS1Ib3N0ICIgIFtYXSBTaXRlICRpcCBPRkZMSU5FISIgLUZvcmVncm91bmRDb2xvciBSZWQNCiAgICAgICAgTG9nICJQaW5nIGZhaWxlZCEgU2l0ZSAkaXAgaXMgb2ZmbGluZS4iDQogICAgICAgICR3c2hlbGwgPSBOZXctT2JqZWN0IC1Db21PYmplY3QgV3NjcmlwdC5TaGVsbA0KICAgICAgICAkd3NoZWxsLlBvcHVwKCJTaXRlIE9GRkxJTkUhIFRpZGFrIGFkYSBiYWxhc2FuIHBpbmcgZGFyaSBJUCAkaXAuYG5QYXN0aWthbiBwZXJhbmdrYXQgbWVueWFsYSBkYW4gVlBOIHRlcmh1YnVuZy4iLCAxNSwgIk5VU1RFQ0ggUmVtb3RlIC0gU2l0ZSBPZmZsaW5lIiwgNDgpIHwgT3V0LU51bGwNCiAgICB9DQogICAgDQogICAgTG9nICJTY3JpcHQgZmluaXNoZWQgY29ycmVjdGx5LiINCn0gY2F0Y2ggew0KICAgIExvZyAiRVJST1I6ICRfIg0KICAgIGV4aXQNCn0NCg=='))"

:: Buat nusa-handler.bat
(
echo @echo off
echo powershell.exe -NoExit -ExecutionPolicy Bypass -File "C:\NUSTECH\nusa-remote.ps1" "%%1"
) > "C:\NUSTECH\nusa-handler.bat"

:: 3. REGISTRY
echo  [3/4] Mendaftarkan protocol handler...
set "KEY=HKCU\Software\Classes\nusa-remote"
reg add "%KEY%" /ve /d "URL:NUSA Remote" /f >nul
reg add "%KEY%" /v "URL Protocol" /d "" /f >nul
reg add "%KEY%\shell\open\command" /ve /d "\"C:\NUSTECH\nusa-handler.bat\" \"%%1\"" /f >nul

:: 4. IMPORT KE WIREGUARD UI
echo  [4/4] Import tunnel ke WireGuard...
echo.
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo  ???   Klik "Yes/Import" di setiap popup yang muncul!   ???
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo.
start "" "%WG_EXE%" "C:\Client_80.conf"
timeout /t 3 >nul
start "" "%WG_EXE%" "C:\client_00121.conf"
timeout /t 2 >nul

echo.
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo  ???        INSTALASI SELESAI! (v8.5 DPAPI Shield)        ???
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo  ???  Cara kerja:                                       ???
echo  ???    1. Klik Remote di Website                        ???
echo  ???    2. WireGuard tutup sebentar, lalu buka lagi      ???
echo  ???    3. Matikan VPN lain secara otomatis              ???
echo  ???    4. VPN baru aktif = HIJAU di WireGuard app      ???
echo  ???    5. WinBox otomatis terbuka                       ???
echo  ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
echo.
pause
