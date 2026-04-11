
import os
import time
from playwright.sync_api import sync_playwright

BASE_URL = "http://127.0.0.1:8000"
OUT_DIR = r"d:\NEWNUSTECH\manual_screenshots"
os.makedirs(OUT_DIR, exist_ok=True)

EMAIL = "user@nustech.co.id"
PASSWORD = "password"

PAGES = [
    ("00_landing",          "/",                     "Landing Page"),
    ("00_login_page",       "/login",                "Halaman Login"),
    ("00_dashboard",        "/dashboard",            "Dashboard Overview"),
    ("01_datasite",         "/sites",                "Data Site"),
    ("02_manajemen_pw",     "/datapass",             "Manajemen Password"),
    ("03_laporan_cm",       "/laporancm",            "Corrective Maintenance"),
    ("04_laporan_pm",       "/PMLiberta",            "Preventive Maintenance"), 
    ("05_summary_pm",       "/summarypm",            "Summary PM"),
    ("06_open_tiket",       "/open-ticket",          "Open Tiket"),
    ("07_close_tiket",      "/close-ticket",         "Close Tiket"),
    ("08_detail_tiket",     "/detailticket",         "Detail Tiket"),
    ("09_summary_tiket",    "/summaryticket",        "Summary Tiket"),
    ("10_pergantian",       "/pergantianperangkat",  "Pergantian Perangkat"),
    ("11_log_perangkat",    "/logpergantian",        "Log Perangkat"),
    ("12_spare_tracker",    "/sparetracker",         "Spare Tracker"),
    ("13_summary_perangkat","/pm-summary",           "Summary Perangkat"),
    ("14_todolist",         "/todolist",             "My Todo List"),
    ("15_profil",           "/profile",              "Pengaturan Profil"),
]

def take_screenshot(page, filename, wait_ms=3000):
    page.wait_for_load_state("networkidle", timeout=15000)
    page.wait_for_timeout(wait_ms)
    path = os.path.join(OUT_DIR, f"{filename}.png")
    page.screenshot(path=path, full_page=True)
    print(f"  ✓ Saved: {filename}.png")
    return path

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    ctx = browser.new_context(viewport={"width": 1280, "height": 800})
    page = ctx.new_page()

    # 1. Landing
    print("[0] Landing page...")
    try:
        page.goto(f"{BASE_URL}/", timeout=15000)
        take_screenshot(page, "00_landing", wait_ms=2000)
    except: pass

    # 2. Login
    print("[0] Login page...")
    page.goto(f"{BASE_URL}/login")
    take_screenshot(page, "00_login_page", wait_ms=1000)

    # 3. Log in
    print(f"[+] Logging in as {EMAIL}...")
    try:
        page.fill('#usernameInput', EMAIL)
        page.fill('#passwordInput', PASSWORD)
        page.click('button.btn-login')
        page.wait_for_timeout(4000)
    except: pass

    for slug, path, label in PAGES[2:]:
        print(f"[{slug}] Visiting {label}...")
        try:
            page.goto(f"{BASE_URL}{path}", timeout=30000)
            take_screenshot(page, slug, wait_ms=3000)
        except: pass

    browser.close()
    print("\nProcess finished.")
