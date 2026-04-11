<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MikroTik Manager — NUSTECH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #0a0e1a;
            --bg-secondary: #0f1629;
            --bg-card: #131c32;
            --bg-card-hover: #1a2540;
            --bg-input: #0d1422;
            --accent: #00d4ff;
            --accent-2: #7c3aed;
            --accent-3: #10b981;
            --accent-warn: #f59e0b;
            --accent-danger: #ef4444;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #4a5568;
            --border: #1e2d4a;
            --border-light: #243355;
            --shadow: 0 4px 24px rgba(0,0,0,0.5);
            --glow: 0 0 20px rgba(0,212,255,0.15);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* === HEADER === */
        .mk-header {
            background: linear-gradient(135deg, #0f1629 0%, #131c32 100%);
            border-bottom: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }
        .mk-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .mk-logo {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 16px rgba(0,212,255,0.3);
        }
        .mk-title { font-size: 20px; font-weight: 700; letter-spacing: -0.3px; }
        .mk-title span { color: var(--accent); }
        .mk-subtitle { font-size: 12px; color: var(--text-secondary); }
        .mk-actions { display: flex; align-items: center; gap: 10px; }
        .btn-back {
            display: flex; align-items: center; gap: 6px;
            padding: 8px 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.1); color: var(--text-primary); }

        /* === MAIN LAYOUT === */
        .mk-layout { display: flex; height: calc(100vh - 73px); }

        /* === SIDEBAR === */
        .mk-sidebar {
            width: 280px;
            min-width: 280px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .site-selector-wrap {
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }
        .site-selector-label { font-size: 11px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .site-selector {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            padding: 9px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: border-color 0.2s;
            outline: none;
        }
        .site-selector:focus { border-color: var(--accent); }

        /* Router Info Card */
        .router-info-card {
            margin: 14px;
            padding: 14px;
            background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(124,58,237,0.05));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: all 0.3s;
        }
        .router-info-card.connected { border-color: rgba(16,185,129,0.3); background: linear-gradient(135deg, rgba(16,185,129,0.05), rgba(0,212,255,0.05)); }
        .router-status-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .router-name { font-size: 14px; font-weight: 600; }
        .status-badge {
            display: flex; align-items: center; gap: 5px;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-badge.online { background: rgba(16,185,129,0.15); color: var(--accent-3); border: 1px solid rgba(16,185,129,0.3); }
        .status-badge.offline { background: rgba(239,68,68,0.1); color: var(--accent-danger); border: 1px solid rgba(239,68,68,0.2); }
        .status-badge.connecting { background: rgba(245,158,11,0.1); color: var(--accent-warn); border: 1px solid rgba(245,158,11,0.2); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: pulse 2s infinite; }

        .router-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .router-stat { text-align: center; }
        .router-stat-value { font-size: 16px; font-weight: 700; color: var(--accent); font-family: 'JetBrains Mono', monospace; }
        .router-stat-label { font-size: 9px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 2px; }

        .btn-connect {
            width: 100%; margin-top: 10px;
            padding: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border: none; border-radius: var(--radius-sm);
            color: #fff; font-size: 12px; font-weight: 600;
            cursor: pointer; transition: opacity 0.2s;
        }
        .btn-connect:hover { opacity: 0.85; }
        .btn-connect:disabled { opacity: 0.4; cursor: not-allowed; }

        /* Sidebar Nav */
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 8px; }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

        .nav-group { margin-bottom: 4px; }
        .nav-group-title {
            font-size: 10px; font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 10px 4px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.15s;
            font-size: 13px;
            color: var(--text-secondary);
            user-select: none;
            border: 1px solid transparent;
        }
        .nav-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(0,212,255,0.1), rgba(124,58,237,0.08));
            color: var(--accent);
            border-color: rgba(0,212,255,0.2);
        }
        .nav-item i { width: 16px; text-align: center; font-size: 12px; }
        .nav-badge {
            margin-left: auto;
            padding: 2px 7px;
            font-size: 9px;
            font-weight: 700;
            border-radius: 999px;
            background: rgba(0,212,255,0.15);
            color: var(--accent);
        }

        /* Sidebar bottom */
        .sidebar-bottom {
            padding: 12px;
            border-top: 1px solid var(--border);
        }
        .btn-setup-cred {
            width: 100%;
            padding: 9px;
            background: rgba(124,58,237,0.15);
            border: 1px solid rgba(124,58,237,0.3);
            border-radius: var(--radius-sm);
            color: #a78bfa;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-setup-cred:hover { background: rgba(124,58,237,0.25); }

        /* === MAIN CONTENT === */
        .mk-main { flex: 1; overflow-y: auto; padding: 0; }
        .mk-main::-webkit-scrollbar { width: 6px; }
        .mk-main::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* Content Sections */
        .content-section { display: none; padding: 24px; }
        .content-section.active { display: block; }

        /* Section Header */
        .section-header { margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        .section-title { font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .section-title i { color: var(--accent); }
        .section-desc { font-size: 13px; color: var(--text-secondary); margin-top: 3px; }

        /* Stat Cards Row */
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 20px; }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            transition: all 0.2s;
        }
        .stat-card:hover { border-color: var(--border-light); transform: translateY(-1px); }
        .stat-card-icon { font-size: 22px; margin-bottom: 10px; }
        .stat-card-value { font-size: 22px; font-weight: 700; font-family: 'JetBrains Mono', monospace; color: var(--accent); }
        .stat-card-label { font-size: 11px; color: var(--text-secondary); margin-top: 3px; }

        /* Progress Bar */
        .progress-bar-wrap { margin-top: 8px; }
        .progress-bar-label { display: flex; justify-content: space-between; font-size: 11px; color: var(--text-secondary); margin-bottom: 4px; }
        .progress-bar { height: 4px; background: var(--border); border-radius: 2px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 2px; transition: width 0.8s ease; }
        .fill-cpu { background: linear-gradient(90deg, var(--accent), var(--accent-2)); }
        .fill-ram { background: linear-gradient(90deg, var(--accent-3), var(--accent)); }
        .fill-disk { background: linear-gradient(90deg, var(--accent-warn), #f97316); }

        /* Data Table */
        .data-table-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .data-table-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: rgba(255,255,255,0.02);
        }
        .data-table-title { font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .data-table-actions { display: flex; gap: 8px; }

        table { width: 100%; border-collapse: collapse; }
        th {
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid var(--border);
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }
        td {
            padding: 10px 14px;
            font-size: 13px;
            border-bottom: 1px solid rgba(30,45,74,0.5);
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; }
        .badge-green  { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.2); }
        .badge-red    { background: rgba(239,68,68,0.1); color: #fca5a5; border: 1px solid rgba(239,68,68,0.2); }
        .badge-blue   { background: rgba(0,212,255,0.1); color: var(--accent); border: 1px solid rgba(0,212,255,0.2); }
        .badge-purple { background: rgba(124,58,237,0.1); color: #a78bfa; border: 1px solid rgba(124,58,237,0.2); }
        .badge-yellow { background: rgba(245,158,11,0.1); color: #fcd34d; border: 1px solid rgba(245,158,11,0.2); }

        /* Monospace */
        .mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .btn-primary { background: linear-gradient(135deg, var(--accent), #0099cc); color: #000; }
        .btn-primary:hover:not(:disabled) { opacity: 0.85; transform: translateY(-1px); }
        .btn-secondary { background: rgba(255,255,255,0.06); border: 1px solid var(--border); color: var(--text-primary); }
        .btn-secondary:hover:not(:disabled) { background: rgba(255,255,255,0.1); }
        .btn-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }
        .btn-danger:hover:not(:disabled) { background: rgba(239,68,68,0.25); }
        .btn-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.2); color: #34d399; }
        .btn-success:hover:not(:disabled) { background: rgba(16,185,129,0.25); }
        .btn-warning { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.2); color: #fcd34d; }
        .btn-warning:hover:not(:disabled) { background: rgba(245,158,11,0.25); }
        .btn-purple { background: rgba(124,58,237,0.15); border: 1px solid rgba(124,58,237,0.2); color: #a78bfa; }
        .btn-sm { padding: 4px 10px; font-size: 11px; }
        .btn-icon { padding: 5px 8px; }

        /* Form Elements */
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            padding: 9px 12px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,212,255,0.08); }
        .form-control::placeholder { color: var(--text-muted); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 80px; font-family: 'JetBrains Mono', monospace; }

        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            width: 90%;
            max-width: 560px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: var(--shadow), var(--glow);
            animation: slideUp 0.2s ease;
        }
        .modal-lg { max-width: 720px; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .modal-title { font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .modal-title i { color: var(--accent); }
        .modal-close { background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: 18px; transition: color 0.2s; }
        .modal-close:hover { color: var(--text-primary); }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }

        /* Toast */
        #toast-container { position: fixed; top: 80px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
        .toast {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            min-width: 260px;
            animation: toastIn 0.3s ease;
            box-shadow: var(--shadow);
        }
        .toast-success { background: #065f46; border: 1px solid rgba(16,185,129,0.3); color: #a7f3d0; }
        .toast-error   { background: #7f1d1d; border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .toast-info    { background: #1e3a5f; border: 1px solid rgba(0,212,255,0.2); color: var(--accent); }
        .toast-warn    { background: #78350f; border: 1px solid rgba(245,158,11,0.3); color: #fcd34d; }

        /* Log Terminal */
        .log-terminal {
            background: #000;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            height: 400px;
            overflow-y: auto;
            line-height: 1.7;
        }
        .log-terminal::-webkit-scrollbar { width: 4px; }
        .log-terminal::-webkit-scrollbar-thumb { background: #333; }
        .log-line { display: flex; gap: 10px; }
        .log-time { color: #555; flex-shrink: 0; }
        .log-topic { color: #7c3aed; min-width: 80px; }
        .log-msg { color: #a3e635; }
        .log-msg.error { color: #fca5a5; }
        .log-msg.warning { color: #fcd34d; }
        .log-msg.info { color: #93c5fd; }

        /* Empty State */
        .empty-state {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.3; }
        .empty-state p { font-size: 14px; }

        /* Loading Skeleton */
        .skeleton { background: linear-gradient(90deg, var(--bg-card) 25%, var(--bg-card-hover) 50%, var(--bg-card) 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px; }
        .skeleton-row { height: 40px; margin-bottom: 8px; }

        /* Ping Result */
        .ping-result { font-family: 'JetBrains Mono', monospace; font-size: 12px; background: #000; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px; min-height: 120px; white-space: pre-wrap; color: #a3e635; }

        /* Responsive */
        @media (max-width: 768px) {
            .mk-sidebar { width: 240px; min-width: 240px; }
            .stats-row { grid-template-columns: 1fr 1fr; }
        }

        /* Animations */
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes toastIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; }

        /* Tabs */
        .sub-tabs { display: flex; gap: 4px; margin-bottom: 16px; flex-wrap: wrap; }
        .sub-tab {
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s;
        }
        .sub-tab:hover { color: var(--text-primary); border-color: var(--border-light); }
        .sub-tab.active { background: rgba(0,212,255,0.1); border-color: rgba(0,212,255,0.3); color: var(--accent); }

        /* Sub Tab Content */
        .sub-content { display: none; }
        .sub-content.active { display: block; }

        /* Credential not set warning */
        .cred-warning {
            background: linear-gradient(135deg, rgba(245,158,11,0.08), rgba(245,158,11,0.03));
            border: 1px solid rgba(245,158,11,0.25);
            border-radius: var(--radius);
            padding: 20px;
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 20px;
        }
        .cred-warning i { font-size: 24px; color: var(--accent-warn); flex-shrink: 0; }
        .cred-warning-text strong { display: block; font-size: 14px; color: #fcd34d; margin-bottom: 3px; }
        .cred-warning-text span { font-size: 12px; color: var(--text-secondary); }

        /* Toggles */
        .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; }
        .toggle-switch input { display: none; }
        .toggle-slider {
            position: absolute; cursor: pointer; inset: 0;
            background: var(--border); border-radius: 11px;
            transition: .3s;
        }
        .toggle-slider:before {
            position: absolute; content: "";
            height: 16px; width: 16px;
            left: 3px; bottom: 3px;
            background: white; border-radius: 50%;
            transition: .3s;
        }
        input:checked + .toggle-slider { background: var(--accent-3); }
        input:checked + .toggle-slider:before { transform: translateX(18px); }

        /* Alert box */
        .alert { padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
        .alert-info { background: rgba(0,212,255,0.08); border: 1px solid rgba(0,212,255,0.2); color: #93c5fd; }
        .alert-warn { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2); color: #fcd34d; }
        .alert-danger { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }

        /* Script editor */
        .script-editor {
            width: 100%;
            background: #000;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: #a3e635;
            padding: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            min-height: 200px;
            resize: vertical;
            outline: none;
        }
        .script-editor:focus { border-color: var(--accent); }

        /* Chip list */
        .chip-list { display: flex; flex-wrap: wrap; gap: 6px; }
        .chip {
            padding: 3px 10px;
            background: rgba(0,212,255,0.08);
            border: 1px solid rgba(0,212,255,0.15);
            border-radius: 999px;
            font-size: 11px;
            color: var(--accent);
            font-family: 'JetBrains Mono', monospace;
        }

        /* No select site placeholder */
        #placeholder-no-site {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 100%; min-height: 500px;
            color: var(--text-muted);
            text-align: center;
            padding: 40px;
        }
        #placeholder-no-site .big-icon {
            font-size: 80px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 24px;
            opacity: 0.6;
        }
        #placeholder-no-site h2 { font-size: 22px; color: var(--text-secondary); margin-bottom: 8px; }
        #placeholder-no-site p { font-size: 14px; color: var(--text-muted); max-width: 400px; }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="mk-header">
    <div class="mk-header-left">
        <div class="mk-logo"><i class="fas fa-router" style="color:#fff"></i></div>
        <div>
            <div class="mk-title">MikroTik <span>Manager</span></div>
            <div class="mk-subtitle">Kelola perangkat MikroTik secara real-time</div>
        </div>
    </div>
    <div class="mk-actions">
        <div id="conn-status-header" class="status-badge offline" style="padding:5px 12px">
            <span class="status-dot"></span> <span id="conn-status-text">Belum Terhubung</span>
        </div>
        <a href="/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>
</header>

<!-- MAIN LAYOUT -->
<div class="mk-layout">

    <!-- SIDEBAR -->
    <aside class="mk-sidebar">
        <!-- Site Selector -->
        <div class="site-selector-wrap">
            <div class="site-selector-label">🌐 Pilih Site</div>
            <select class="site-selector" id="site-select" onchange="onSiteChange(this.value)">
                <option value="">-- Pilih Site --</option>
                @foreach($sites as $site)
                <option value="{{ $site->site_id }}" data-ip="{{ $site->ip_router }}">
                    {{ $site->sitename }} @if($site->ip_router)({{ $site->ip_router }})@endif
                </option>
                @endforeach
            </select>
        </div>

        <!-- Router Info Card -->
        <div class="router-info-card" id="router-card">
            <div class="router-status-row">
                <span class="router-name" id="router-name">--</span>
                <span class="status-badge offline" id="router-status-badge">
                    <span class="status-dot"></span> Offline
                </span>
            </div>
            <div class="router-stats" id="router-stats" style="display:none">
                <div class="router-stat">
                    <div class="router-stat-value" id="rt-cpu">--</div>
                    <div class="router-stat-label">CPU</div>
                </div>
                <div class="router-stat">
                    <div class="router-stat-value" id="rt-ram">--</div>
                    <div class="router-stat-label">RAM</div>
                </div>
                <div class="router-stat">
                    <div class="router-stat-value" id="rt-uptime" style="font-size:11px">--</div>
                    <div class="router-stat-label">Uptime</div>
                </div>
                <div class="router-stat">
                    <div class="router-stat-value" id="rt-os" style="font-size:11px">--</div>
                    <div class="router-stat-label">RouterOS</div>
                </div>
            </div>
            <button class="btn-connect" id="btn-connect" onclick="connectToSite()" disabled>
                <i class="fas fa-plug"></i> Hubungkan
            </button>
        </div>

        <!-- Nav Menu -->
        <nav class="sidebar-nav" id="sidebar-nav">
            <div class="nav-group">
                <div class="nav-group-title">Monitoring</div>
                <div class="nav-item active" onclick="showSection('section-dashboard')" id="nav-dashboard">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </div>
                <div class="nav-item" onclick="loadAndShow('section-log', loadSystemLog)" id="nav-log">
                    <i class="fas fa-scroll"></i> System Log
                </div>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Jaringan</div>
                <div class="nav-item" onclick="loadAndShow('section-interface', loadInterfaces)" id="nav-interface">
                    <i class="fas fa-network-wired"></i> Interface
                </div>
                <div class="nav-item" onclick="loadAndShow('section-ip', loadIpAddresses)" id="nav-ip">
                    <i class="fas fa-map-marker-alt"></i> IP Address
                </div>
                <div class="nav-item" onclick="loadAndShow('section-route', loadRoutes)" id="nav-route">
                    <i class="fas fa-route"></i> Routes
                </div>
                <div class="nav-item" onclick="loadAndShow('section-arp', loadArp)" id="nav-arp">
                    <i class="fas fa-project-diagram"></i> ARP Table
                </div>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Layanan</div>
                <div class="nav-item" onclick="loadAndShow('section-dhcp', loadDhcp)" id="nav-dhcp">
                    <i class="fas fa-server"></i> DHCP
                </div>
                <div class="nav-item" onclick="loadAndShow('section-dns', loadDns)" id="nav-dns">
                    <i class="fas fa-globe"></i> DNS
                </div>
                <div class="nav-item" onclick="loadAndShow('section-wireless', loadWireless)" id="nav-wireless">
                    <i class="fas fa-wifi"></i> Wireless
                </div>
                <div class="nav-item" onclick="loadAndShow('section-hotspot', loadHotspot)" id="nav-hotspot">
                    <i class="fas fa-signal"></i> Hotspot
                </div>
                <div class="nav-item" onclick="loadAndShow('section-ppp', loadPpp)" id="nav-ppp">
                    <i class="fas fa-link"></i> PPP / VPN
                </div>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Keamanan</div>
                <div class="nav-item" onclick="loadAndShow('section-firewall', loadFirewall)" id="nav-firewall">
                    <i class="fas fa-shield-alt"></i> Firewall
                </div>
                <div class="nav-item" onclick="loadAndShow('section-users', loadUsers)" id="nav-users">
                    <i class="fas fa-users"></i> Users
                </div>
                <div class="nav-item" onclick="loadAndShow('section-services', loadServices)" id="nav-services">
                    <i class="fas fa-cogs"></i> IP Services
                </div>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Kontrol</div>
                <div class="nav-item" onclick="loadAndShow('section-queue', loadQueues)" id="nav-queue">
                    <i class="fas fa-sort-amount-down"></i> Queue
                </div>
                <div class="nav-item" onclick="loadAndShow('section-scripts', loadScripts)" id="nav-scripts">
                    <i class="fas fa-code"></i> Scripts
                </div>
                <div class="nav-item" onclick="loadAndShow('section-backup', loadFiles)" id="nav-backup">
                    <i class="fas fa-download"></i> Backup & Files
                </div>
                <div class="nav-item" onclick="showSection('section-tools')" id="nav-tools">
                    <i class="fas fa-tools"></i> Tools
                </div>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Audit</div>
                <div class="nav-item" onclick="loadAndShow('section-auditlog', loadAuditLog)" id="nav-auditlog">
                    <i class="fas fa-history"></i> Audit Log
                </div>
            </div>
        </nav>

        <!-- Bottom -->
        <div class="sidebar-bottom">
            <button class="btn-setup-cred" onclick="openCredModal()">
                <i class="fas fa-key"></i> Konfigurasi Kredensial
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="mk-main" id="mk-main">

        <!-- PLACEHOLDER NO SITE -->
        <div id="placeholder-no-site">
            <div class="big-icon"><i class="fas fa-router"></i></div>
            <h2>Pilih Site MikroTik</h2>
            <p>Pilih site dari dropdown di sebelah kiri, lalu klik <strong style="color:var(--accent)">Hubungkan</strong> untuk mulai mengelola MikroTik.</p>
        </div>

        <!-- SECTION: DASHBOARD -->
        <div class="content-section" id="section-dashboard">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-tachometer-alt"></i> System Dashboard</div>
                    <div class="section-desc" id="dash-hostname">Informasi sistem router</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="refreshDashboard()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmReboot()" id="btn-reboot"><i class="fas fa-power-off"></i> Reboot</button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row" id="dash-stats-row">
                <div class="stat-card">
                    <div class="stat-card-icon">⚙️</div>
                    <div class="stat-card-value" id="d-cpu">--</div>
                    <div class="stat-card-label">CPU Load</div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar"><div class="progress-bar-fill fill-cpu" id="d-cpu-bar" style="width:0%"></div></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">🧠</div>
                    <div class="stat-card-value" id="d-ram">--</div>
                    <div class="stat-card-label">RAM Used</div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar"><div class="progress-bar-fill fill-ram" id="d-ram-bar" style="width:0%"></div></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">💾</div>
                    <div class="stat-card-value" id="d-hdd">--</div>
                    <div class="stat-card-label">Disk Used</div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar"><div class="progress-bar-fill fill-disk" id="d-hdd-bar" style="width:0%"></div></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">⏱️</div>
                    <div class="stat-card-value" id="d-uptime" style="font-size:14px">--</div>
                    <div class="stat-card-label">Uptime</div>
                </div>
            </div>

            <!-- System Details -->
            <div class="data-table-wrap">
                <div class="data-table-header">
                    <div class="data-table-title"><i class="fas fa-info-circle" style="color:var(--accent)"></i> Informasi Sistem</div>
                    <button class="btn btn-secondary btn-sm" onclick="openIdentityModal()"><i class="fas fa-edit"></i> Edit Identity</button>
                </div>
                <table>
                    <tbody id="system-info-table">
                        <tr><td colspan="2" style="text-align:center;color:var(--text-muted);padding:24px">Belum terhubung</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECTION: INTERFACE -->
        <div class="content-section" id="section-interface">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-network-wired"></i> Interface & VLAN</div>
                    <div class="section-desc">Kelola interface fisik, bridge, dan VLAN</div>
                </div>
                <button class="btn btn-secondary" onclick="loadInterfaces()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('iface', 'interfaces')">Interface</div>
                <div class="sub-tab" onclick="switchSubTab('iface', 'vlans')">VLAN</div>
                <div class="sub-tab" onclick="switchSubTab('iface', 'bridges')">Bridge</div>
            </div>
            <div class="sub-content active" id="iface-interfaces">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-ethernet" style="color:var(--accent)"></i> Daftar Interface</div>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead>
                            <tr><th>Nama</th><th>Tipe</th><th>MAC Address</th><th>MTU</th><th>Status</th><th>TX/RX</th><th>Aksi</th></tr>
                        </thead>
                        <tbody id="interface-table-body">
                            <tr><td colspan="7" class="text-center" style="padding:24px;color:var(--text-muted)">Loading...</td></tr>
                        </tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="iface-vlans">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-layer-group" style="color:var(--accent)"></i> VLAN</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddVlanModal()"><i class="fas fa-plus"></i> Tambah VLAN</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead>
                            <tr><th>Nama</th><th>VLAN ID</th><th>Interface</th><th>Status</th><th>Aksi</th></tr>
                        </thead>
                        <tbody id="vlan-table-body">
                            <tr><td colspan="5" style="padding:24px;color:var(--text-muted);text-align:center">Loading...</td></tr>
                        </tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="iface-bridges">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-sitemap" style="color:var(--accent)"></i> Bridge & Bridge Ports</div>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead>
                            <tr><th>Nama</th><th>Protocol</th><th>Status</th><th>Ports</th></tr>
                        </thead>
                        <tbody id="bridge-table-body">
                            <tr><td colspan="4" style="padding:24px;color:var(--text-muted);text-align:center">Loading...</td></tr>
                        </tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: IP ADDRESS -->
        <div class="content-section" id="section-ip">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-map-marker-alt"></i> IP Address</div>
                    <div class="section-desc">Tambah, ubah, hapus IP address pada interface</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="loadIpAddresses()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary" onclick="openAddIpModal()"><i class="fas fa-plus"></i> Tambah IP</button>
                </div>
            </div>
            <div class="data-table-wrap">
                <div style="overflow-x:auto"><table>
                    <thead>
                        <tr><th>Address/Prefix</th><th>Network</th><th>Interface</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody id="ip-table-body">
                        <tr><td colspan="5" style="padding:24px;color:var(--text-muted);text-align:center">Loading...</td></tr>
                    </tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: ROUTE -->
        <div class="content-section" id="section-route">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-route"></i> Routing Table</div>
                    <div class="section-desc">Kelola static route dan lihat routing table aktif</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="loadRoutes()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary" onclick="openAddRouteModal()"><i class="fas fa-plus"></i> Tambah Route</button>
                </div>
            </div>
            <div class="data-table-wrap">
                <div style="overflow-x:auto"><table>
                    <thead>
                        <tr><th>Dst. Address</th><th>Gateway</th><th>Distance</th><th>Routing Mark</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody id="route-table-body">
                        <tr><td colspan="6" style="padding:24px;color:var(--text-muted);text-align:center">Loading...</td></tr>
                    </tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: DHCP -->
        <div class="content-section" id="section-dhcp">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-server"></i> DHCP Management</div>
                    <div class="section-desc">Server, leases, dan networks DHCP</div>
                </div>
                <button class="btn btn-secondary" onclick="loadDhcp()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('dhcp', 'servers')">Servers</div>
                <div class="sub-tab" onclick="switchSubTab('dhcp', 'leases')">Leases</div>
                <div class="sub-tab" onclick="switchSubTab('dhcp', 'networks')">Networks</div>
            </div>
            <div class="sub-content active" id="dhcp-servers">
                <div class="data-table-wrap">
                    <div class="data-table-header"><div class="data-table-title"><i class="fas fa-hdd" style="color:var(--accent)"></i> DHCP Servers</div></div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Interface</th><th>Address Pool</th><th>Lease Time</th><th>Status</th></tr></thead>
                        <tbody id="dhcp-servers-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="dhcp-leases">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-list" style="color:var(--accent)"></i> Active Leases</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddLeaseModal()"><i class="fas fa-plus"></i> Tambah Static</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>IP Address</th><th>MAC Address</th><th>Hostname</th><th>Server</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody id="dhcp-leases-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="dhcp-networks">
                <div class="data-table-wrap">
                    <div class="data-table-header"><div class="data-table-title"><i class="fas fa-project-diagram" style="color:var(--accent)"></i> DHCP Networks</div></div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Address</th><th>Gateway</th><th>DNS Server</th><th>Domain</th></tr></thead>
                        <tbody id="dhcp-networks-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: DNS -->
        <div class="content-section" id="section-dns">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-globe"></i> DNS Settings</div>
                    <div class="section-desc">Konfigurasi DNS server dan static DNS entries</div>
                </div>
                <button class="btn btn-secondary" onclick="loadDns()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <!-- DNS Config -->
            <div class="data-table-wrap" style="margin-bottom:16px">
                <div class="data-table-header">
                    <div class="data-table-title"><i class="fas fa-sliders-h" style="color:var(--accent)"></i> Konfigurasi DNS</div>
                    <button class="btn btn-primary btn-sm" onclick="saveDnsSettings()"><i class="fas fa-save"></i> Simpan</button>
                </div>
                <div style="padding:16px">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">DNS Servers</label>
                            <input class="form-control mono" id="dns-servers" placeholder="8.8.8.8,8.8.4.4">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Max UDP Packet</label>
                            <input class="form-control" id="dns-max-udp" placeholder="4096">
                        </div>
                        <div class="form-group" style="display:flex;align-items:flex-end;gap:12px">
                            <div>
                                <label class="form-label">Allow Remote Request</label>
                                <label class="toggle-switch"><input type="checkbox" id="dns-allow-remote"><span class="toggle-slider"></span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DNS Static -->
            <div class="data-table-wrap">
                <div class="data-table-header">
                    <div class="data-table-title"><i class="fas fa-list" style="color:var(--accent)"></i> Static DNS Entries</div>
                    <button class="btn btn-primary btn-sm" onclick="openAddDnsStaticModal()"><i class="fas fa-plus"></i> Tambah</button>
                </div>
                <div style="overflow-x:auto"><table>
                    <thead><tr><th>Nama</th><th>Address</th><th>TTL</th><th>Aksi</th></tr></thead>
                    <tbody id="dns-static-body"></tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: FIREWALL -->
        <div class="content-section" id="section-firewall">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-shield-alt"></i> Firewall</div>
                    <div class="section-desc">Filter, NAT, Mangle, dan Address List</div>
                </div>
                <button class="btn btn-secondary" onclick="loadFirewall()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('fw', 'filter')">Filter Rules</div>
                <div class="sub-tab" onclick="switchSubTab('fw', 'nat')">NAT</div>
                <div class="sub-tab" onclick="switchSubTab('fw', 'mangle')">Mangle</div>
                <div class="sub-tab" onclick="switchSubTab('fw', 'addrlist')">Address List</div>
            </div>
            <div class="sub-content active" id="fw-filter">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-filter" style="color:var(--accent)"></i> Filter Rules</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddFirewallModal('filter')"><i class="fas fa-plus"></i> Tambah Rule</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>#</th><th>Chain</th><th>Action</th><th>Protocol</th><th>Src. Address</th><th>Dst. Port</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody id="fw-filter-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="fw-nat">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-exchange-alt" style="color:var(--accent)"></i> NAT Rules</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddFirewallModal('nat')"><i class="fas fa-plus"></i> Tambah Rule</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Chain</th><th>Action</th><th>Protocol</th><th>Dst. Address</th><th>To Address</th><th>Aksi</th></tr></thead>
                        <tbody id="fw-nat-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="fw-mangle">
                <div class="data-table-wrap">
                    <div class="data-table-header"><div class="data-table-title"><i class="fas fa-wrench" style="color:var(--accent)"></i> Mangle Rules</div></div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Chain</th><th>Action</th><th>Protocol</th><th>Mark</th><th>Status</th></tr></thead>
                        <tbody id="fw-mangle-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="fw-addrlist">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-list-ul" style="color:var(--accent)"></i> Address Lists</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddAddressListModal()"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>List</th><th>Address</th><th>Timeout</th><th>Aksi</th></tr></thead>
                        <tbody id="fw-addrlist-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: WIRELESS -->
        <div class="content-section" id="section-wireless">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-wifi"></i> Wireless</div>
                    <div class="section-desc">Konfigurasi WiFi, SSID, keamanan, dan klien terhubung</div>
                </div>
                <button class="btn btn-secondary" onclick="loadWireless()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('wl', 'interfaces')">Interfaces</div>
                <div class="sub-tab" onclick="switchSubTab('wl', 'registrations')">Client Terhubung</div>
                <div class="sub-tab" onclick="switchSubTab('wl', 'security')">Security Profiles</div>
            </div>
            <div class="sub-content active" id="wl-interfaces">
                <div class="data-table-wrap">
                    <div class="data-table-header"><div class="data-table-title"><i class="fas fa-wifi" style="color:var(--accent)"></i> Wireless Interfaces</div></div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>SSID</th><th>Band</th><th>Channel</th><th>Tx Power</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody id="wl-iface-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="wl-registrations">
                <div class="data-table-wrap">
                    <div class="data-table-header"><div class="data-table-title"><i class="fas fa-laptop" style="color:var(--accent)"></i> Klien Terhubung</div></div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>MAC Address</th><th>Interface</th><th>Signal</th><th>TX/RX Rate</th><th>Uptime</th></tr></thead>
                        <tbody id="wl-reg-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="wl-security">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-lock" style="color:var(--accent)"></i> Security Profiles</div>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Mode</th><th>Auth. Type</th><th>Encryption</th></tr></thead>
                        <tbody id="wl-sec-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: USERS -->
        <div class="content-section" id="section-users">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-users"></i> User Management</div>
                    <div class="section-desc">Kelola user login MikroTik dan sesi aktif</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="loadUsers()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary" onclick="openAddUserModal()"><i class="fas fa-user-plus"></i> Tambah User</button>
                </div>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('usr', 'users')">Users</div>
                <div class="sub-tab" onclick="switchSubTab('usr', 'active')">Sesi Aktif</div>
            </div>
            <div class="sub-content active" id="usr-users">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Username</th><th>Group</th><th>Comment</th><th>Allowed Address</th><th>Aksi</th></tr></thead>
                        <tbody id="users-table-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="usr-active">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Username</th><th>Address</th><th>Service</th><th>Uptime</th></tr></thead>
                        <tbody id="users-active-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: QUEUE -->
        <div class="content-section" id="section-queue">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-sort-amount-down"></i> Queue Manager</div>
                    <div class="section-desc">Atur bandwidth limiting untuk IP/subnet tertentu</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="loadQueues()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary" onclick="openAddQueueModal()"><i class="fas fa-plus"></i> Tambah Queue</button>
                </div>
            </div>
            <div class="data-table-wrap">
                <div style="overflow-x:auto"><table>
                    <thead><tr><th>Nama</th><th>Target</th><th>Max Upload</th><th>Max Download</th><th>Priority</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody id="queue-table-body"></tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: PPP -->
        <div class="content-section" id="section-ppp">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-link"></i> PPP / VPN</div>
                    <div class="section-desc">PPPoE secrets, sesi aktif, dan profil PPP</div>
                </div>
                <button class="btn btn-secondary" onclick="loadPpp()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('ppp', 'secrets')">Secrets</div>
                <div class="sub-tab" onclick="switchSubTab('ppp', 'active')">Active Sessions</div>
                <div class="sub-tab" onclick="switchSubTab('ppp', 'profiles')">Profiles</div>
            </div>
            <div class="sub-content active" id="ppp-secrets">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-key" style="color:var(--accent)"></i> PPP Secrets</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddPppModal()"><i class="fas fa-plus"></i> Tambah Secret</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Service</th><th>Profile</th><th>Local IP</th><th>Remote IP</th><th>Aksi</th></tr></thead>
                        <tbody id="ppp-secrets-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="ppp-active">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Address</th><th>Service</th><th>Uptime</th></tr></thead>
                        <tbody id="ppp-active-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="ppp-profiles">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Local Address</th><th>Remote Address</th><th>Rate Limit</th></tr></thead>
                        <tbody id="ppp-profiles-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: HOTSPOT -->
        <div class="content-section" id="section-hotspot">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-signal"></i> Hotspot</div>
                    <div class="section-desc">Kelola user hotspot, profil, dan sesi aktif</div>
                </div>
                <button class="btn btn-secondary" onclick="loadHotspot()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('hs', 'users')">Users</div>
                <div class="sub-tab" onclick="switchSubTab('hs', 'active')">Sesi Aktif</div>
                <div class="sub-tab" onclick="switchSubTab('hs', 'servers')">Servers</div>
            </div>
            <div class="sub-content active" id="hs-users">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-user-circle" style="color:var(--accent)"></i> Hotspot Users</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddHotspotUserModal()"><i class="fas fa-plus"></i> Tambah User</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Profile</th><th>Limit Uptime</th><th>Limit Bytes</th><th>Aksi</th></tr></thead>
                        <tbody id="hs-users-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="hs-active">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Username</th><th>IP</th><th>MAC</th><th>Uptime</th><th>Session Time</th></tr></thead>
                        <tbody id="hs-active-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="hs-servers">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Interface</th><th>Address Pool</th><th>Profile</th><th>Status</th></tr></thead>
                        <tbody id="hs-servers-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: IP SERVICES -->
        <div class="content-section" id="section-services">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-cogs"></i> IP Services</div>
                    <div class="section-desc">Kelola port dan status layanan IP (API, SSH, Telnet, dll)</div>
                </div>
                <button class="btn btn-secondary" onclick="loadServices()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="data-table-wrap">
                <div style="overflow-x:auto"><table>
                    <thead><tr><th>Layanan</th><th>Port</th><th>Allowed From</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody id="services-table-body"></tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: ARP -->
        <div class="content-section" id="section-arp">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-project-diagram"></i> ARP & Neighbors</div>
                    <div class="section-desc">Tabel ARP dan perangkat tetangga</div>
                </div>
                <button class="btn btn-secondary" onclick="loadArp()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('arp', 'arp')">ARP Table</div>
                <div class="sub-tab" onclick="switchSubTab('arp', 'neighbors')">Neighbors</div>
            </div>
            <div class="sub-content active" id="arp-arp">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>IP Address</th><th>MAC Address</th><th>Interface</th><th>Status</th></tr></thead>
                        <tbody id="arp-table-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="arp-neighbors">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Identity</th><th>IP</th><th>MAC</th><th>Interface</th><th>Platform</th><th>Version</th></tr></thead>
                        <tbody id="neighbor-table-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: SCRIPTS -->
        <div class="content-section" id="section-scripts">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-code"></i> Scripts & Scheduler</div>
                    <div class="section-desc">Kelola script RouterOS dan jadwal eksekusi otomatis</div>
                </div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-secondary" onclick="loadScripts()"><i class="fas fa-sync-alt"></i> Refresh</button>
                    <button class="btn btn-primary" onclick="openAddScriptModal()"><i class="fas fa-plus"></i> Tambah Script</button>
                </div>
            </div>
            <div class="sub-tabs">
                <div class="sub-tab active" onclick="switchSubTab('sc', 'scripts')">Scripts</div>
                <div class="sub-tab" onclick="switchSubTab('sc', 'schedulers')">Schedulers</div>
            </div>
            <div class="sub-content active" id="sc-scripts">
                <div class="data-table-wrap">
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Policy</th><th>Last Started</th><th>Aksi</th></tr></thead>
                        <tbody id="scripts-table-body"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="sub-content" id="sc-schedulers">
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-clock" style="color:var(--accent)"></i> Schedulers</div>
                        <button class="btn btn-primary btn-sm" onclick="openAddSchedulerModal()"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                    <div style="overflow-x:auto"><table>
                        <thead><tr><th>Nama</th><th>Start Date</th><th>Interval</th><th>On Event</th><th>Status</th></tr></thead>
                        <tbody id="schedulers-table-body"></tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <!-- SECTION: BACKUP -->
        <div class="content-section" id="section-backup">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-download"></i> Backup & Files</div>
                    <div class="section-desc">Buat backup konfigurasi dan lihat file di MikroTik</div>
                </div>
                <button class="btn btn-secondary" onclick="loadFiles()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <!-- Create Backup -->
            <div class="data-table-wrap" style="margin-bottom:16px">
                <div class="data-table-header">
                    <div class="data-table-title"><i class="fas fa-save" style="color:var(--accent)"></i> Buat Backup</div>
                </div>
                <div style="padding:16px;display:flex;align-items:flex-end;gap:10px">
                    <div class="form-group" style="flex:1;margin:0">
                        <label class="form-label">Nama File Backup</label>
                        <input class="form-control mono" id="backup-filename" placeholder="backup_site_001">
                    </div>
                    <button class="btn btn-primary" onclick="createBackup()"><i class="fas fa-save"></i> Buat Backup</button>
                </div>
            </div>
            <!-- Files list -->
            <div class="data-table-wrap">
                <div class="data-table-header"><div class="data-table-title"><i class="fas fa-folder" style="color:var(--accent)"></i> File Manager</div></div>
                <div style="overflow-x:auto"><table>
                    <thead><tr><th>Nama File</th><th>Tipe</th><th>Ukuran</th><th>Creation Time</th></tr></thead>
                    <tbody id="files-table-body"></tbody>
                </table></div>
            </div>
        </div>

        <!-- SECTION: TOOLS -->
        <div class="content-section" id="section-tools">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-tools"></i> Network Tools</div>
                    <div class="section-desc">Ping, traceroute, dan traffic monitoring</div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <!-- Ping Tool -->
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-satellite-dish" style="color:var(--accent)"></i> Ping</div>
                    </div>
                    <div style="padding:16px">
                        <div class="form-group">
                            <label class="form-label">Alamat Tujuan</label>
                            <div style="display:flex;gap:8px">
                                <input class="form-control mono" id="ping-addr" placeholder="8.8.8.8">
                                <select class="form-control" id="ping-count" style="width:80px">
                                    <option>4</option><option>8</option><option>16</option>
                                </select>
                                <button class="btn btn-primary" onclick="runPing()"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                        <div class="ping-result" id="ping-result">Masukkan alamat IP kemudian klik tombol play...</div>
                    </div>
                </div>

                <!-- Traffic Monitor -->
                <div class="data-table-wrap">
                    <div class="data-table-header">
                        <div class="data-table-title"><i class="fas fa-chart-line" style="color:var(--accent)"></i> Traffic Monitor</div>
                    </div>
                    <div style="padding:16px">
                        <div class="form-group">
                            <label class="form-label">Interface</label>
                            <div style="display:flex;gap:8px">
                                <input class="form-control mono" id="traffic-iface" placeholder="ether1">
                                <button class="btn btn-primary" onclick="checkTraffic()"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                        <div id="traffic-result" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:8px">
                            <div class="stat-card" style="text-align:center">
                                <div class="router-stat-value" id="t-rx" style="color:var(--accent-3)">--</div>
                                <div class="router-stat-label">Download (bps)</div>
                            </div>
                            <div class="stat-card" style="text-align:center">
                                <div class="router-stat-value" id="t-tx" style="color:var(--accent-warn)">--</div>
                                <div class="router-stat-label">Upload (bps)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION: LOG -->
        <div class="content-section" id="section-log">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-scroll"></i> System Log</div>
                    <div class="section-desc">Log sistem MikroTik secara real-time</div>
                </div>
                <button class="btn btn-secondary" onclick="loadSystemLog()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="log-terminal" id="log-terminal">
                <div style="color:#555;font-style:italic">Klik refresh untuk memuat log...</div>
            </div>
        </div>

        <!-- SECTION: AUDIT LOG -->
        <div class="content-section" id="section-auditlog">
            <div class="section-header">
                <div>
                    <div class="section-title"><i class="fas fa-history"></i> Audit Log</div>
                    <div class="section-desc">Semua perintah yang dikirim ke MikroTik</div>
                </div>
                <button class="btn btn-secondary" onclick="loadAuditLog()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <div class="data-table-wrap">
                <div style="overflow-x:auto"><table>
                    <thead><tr><th>Waktu</th><th>User</th><th>Perintah</th><th>Kategori</th><th>Status</th><th>Response</th></tr></thead>
                    <tbody id="audit-log-body"></tbody>
                </table></div>
            </div>
        </div>

    </main>
</div>

<!-- =================== MODALS =================== -->

<!-- Modal: Credentials -->
<div class="modal-overlay" id="modal-credentials">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-key"></i> Konfigurasi Kredensial MikroTik</div>
            <button class="modal-close" onclick="closeModal('modal-credentials')">✕</button>
        </div>
        <div class="alert alert-info"><i class="fas fa-info-circle"></i> Pastikan RouterOS API aktif di MikroTik (IP → Services → api, port 8728)</div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">IP / Host MikroTik</label>
                <input class="form-control mono" id="cred-host" placeholder="192.168.1.1">
            </div>
            <div class="form-group">
                <label class="form-label">Port API</label>
                <input class="form-control mono" id="cred-port" value="8728" type="number">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input class="form-control" id="cred-user" placeholder="admin">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control" id="cred-pass" type="password" placeholder="••••••••">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="testConnectionModal()"><i class="fas fa-plug"></i> Test Koneksi</button>
            <button class="btn btn-primary" onclick="saveCredentials()"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Modal: Edit Identity -->
<div class="modal-overlay" id="modal-identity">
    <div class="modal" style="max-width:400px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-tag"></i> Edit Router Identity</div>
            <button class="modal-close" onclick="closeModal('modal-identity')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Router</label>
            <input class="form-control" id="identity-name" placeholder="Nama router...">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-identity')">Batal</button>
            <button class="btn btn-primary" onclick="saveIdentity()"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Modal: Add IP -->
<div class="modal-overlay" id="modal-add-ip">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-plus-circle"></i> Tambah IP Address</div>
            <button class="modal-close" onclick="closeModal('modal-add-ip')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Address/Prefix (contoh: 192.168.1.1/24)</label>
            <input class="form-control mono" id="add-ip-address" placeholder="192.168.1.1/24">
        </div>
        <div class="form-group">
            <label class="form-label">Interface</label>
            <input class="form-control" id="add-ip-iface" placeholder="ether1">
        </div>
        <div class="form-group">
            <label class="form-label">Comment (opsional)</label>
            <input class="form-control" id="add-ip-comment" placeholder="Komentar...">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-ip')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddIp()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Route -->
<div class="modal-overlay" id="modal-add-route">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-route"></i> Tambah Route</div>
            <button class="modal-close" onclick="closeModal('modal-add-route')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Destination Address</label>
            <input class="form-control mono" id="route-dst" placeholder="0.0.0.0/0">
        </div>
        <div class="form-group">
            <label class="form-label">Gateway</label>
            <input class="form-control mono" id="route-gw" placeholder="192.168.1.1">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Distance</label>
                <input class="form-control" id="route-dist" placeholder="1" value="1">
            </div>
            <div class="form-group">
                <label class="form-label">Comment</label>
                <input class="form-control" id="route-comment" placeholder="default-gateway">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-route')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddRoute()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add DHCP Lease -->
<div class="modal-overlay" id="modal-add-lease">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-plus"></i> Tambah Static Lease</div>
            <button class="modal-close" onclick="closeModal('modal-add-lease')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">IP Address</label>
            <input class="form-control mono" id="lease-ip" placeholder="192.168.1.100">
        </div>
        <div class="form-group">
            <label class="form-label">MAC Address</label>
            <input class="form-control mono" id="lease-mac" placeholder="AA:BB:CC:DD:EE:FF">
        </div>
        <div class="form-group">
            <label class="form-label">Comment</label>
            <input class="form-control" id="lease-comment" placeholder="Perangkat X">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-lease')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddLease()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add DNS Static -->
<div class="modal-overlay" id="modal-add-dns">
    <div class="modal" style="max-width:420px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-globe"></i> Tambah DNS Static</div>
            <button class="modal-close" onclick="closeModal('modal-add-dns')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Domain</label>
            <input class="form-control mono" id="dns-static-name" placeholder="myserver.local">
        </div>
        <div class="form-group">
            <label class="form-label">IP Address</label>
            <input class="form-control mono" id="dns-static-addr" placeholder="192.168.1.10">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-dns')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddDnsStatic()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Firewall Rule -->
<div class="modal-overlay" id="modal-add-fw">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title" id="fw-modal-title"><i class="fas fa-shield-alt"></i> Tambah Firewall Rule</div>
            <button class="modal-close" onclick="closeModal('modal-add-fw')">✕</button>
        </div>
        <input type="hidden" id="fw-type">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Chain</label>
                <select class="form-control" id="fw-chain">
                    <option>forward</option><option>input</option><option>output</option>
                    <option>srcnat</option><option>dstnat</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Action</label>
                <select class="form-control" id="fw-action">
                    <option>accept</option><option>drop</option><option>reject</option>
                    <option>masquerade</option><option>dst-nat</option><option>src-nat</option>
                    <option>mark-packet</option><option>mark-connection</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Protocol</label>
                <select class="form-control" id="fw-protocol">
                    <option value="">any</option><option>tcp</option><option>udp</option><option>icmp</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Src. Address</label>
                <input class="form-control mono" id="fw-src-addr" placeholder="0.0.0.0/0">
            </div>
            <div class="form-group">
                <label class="form-label">Dst. Address</label>
                <input class="form-control mono" id="fw-dst-addr" placeholder="0.0.0.0/0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Dst. Port</label>
                <input class="form-control mono" id="fw-dst-port" placeholder="80,443,8080">
            </div>
            <div class="form-group">
                <label class="form-label">In Interface</label>
                <input class="form-control" id="fw-in-iface" placeholder="ether1">
            </div>
            <div class="form-group">
                <label class="form-label">Comment</label>
                <input class="form-control" id="fw-comment" placeholder="Rule description">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-fw')">Batal</button>
            <button class="btn btn-primary" onclick="saveFirewallRule()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add User -->
<div class="modal-overlay" id="modal-add-user">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-user-plus"></i> Tambah User MikroTik</div>
            <button class="modal-close" onclick="closeModal('modal-add-user')">✕</button>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input class="form-control" id="user-name" placeholder="admin2">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control" id="user-pass" type="password" placeholder="••••••••">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Group</label>
            <select class="form-control" id="user-group">
                <option>full</option><option>read</option><option>write</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Allowed Address (opsional)</label>
            <input class="form-control mono" id="user-addr" placeholder="192.168.1.0/24">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-user')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddUser()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Queue -->
<div class="modal-overlay" id="modal-add-queue">
    <div class="modal" style="max-width:500px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-sort-amount-down"></i> Tambah Simple Queue</div>
            <button class="modal-close" onclick="closeModal('modal-add-queue')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama</label>
            <input class="form-control" id="q-name" placeholder="Client-1">
        </div>
        <div class="form-group">
            <label class="form-label">Target (IP atau subnet)</label>
            <input class="form-control mono" id="q-target" placeholder="192.168.1.100/32">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Max Upload (contoh: 2M)</label>
                <input class="form-control mono" id="q-upload" placeholder="2M">
            </div>
            <div class="form-group">
                <label class="form-label">Max Download (contoh: 5M)</label>
                <input class="form-control mono" id="q-download" placeholder="5M">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-queue')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddQueue()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add PPP Secret -->
<div class="modal-overlay" id="modal-add-ppp">
    <div class="modal" style="max-width:520px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-link"></i> Tambah PPP Secret</div>
            <button class="modal-close" onclick="closeModal('modal-add-ppp')">✕</button>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama User</label>
                <input class="form-control" id="ppp-name" placeholder="user1">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control" id="ppp-pass" type="password" placeholder="••••••••">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Service</label>
                <select class="form-control" id="ppp-service">
                    <option>any</option><option>pppoe</option><option>pptp</option><option>l2tp</option><option>ovpn</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Profile</label>
                <input class="form-control" id="ppp-profile" placeholder="default">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Local Address (opsional)</label>
                <input class="form-control mono" id="ppp-local" placeholder="10.0.0.1">
            </div>
            <div class="form-group">
                <label class="form-label">Remote Address (opsional)</label>
                <input class="form-control mono" id="ppp-remote" placeholder="10.0.0.2">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-ppp')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddPpp()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Hotspot User -->
<div class="modal-overlay" id="modal-add-hs-user">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-signal"></i> Tambah User Hotspot</div>
            <button class="modal-close" onclick="closeModal('modal-add-hs-user')">✕</button>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input class="form-control" id="hs-uname" placeholder="user1">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control" id="hs-upass" type="password" placeholder="••••••••">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Profile</label>
                <input class="form-control" id="hs-uprof" placeholder="default">
            </div>
            <div class="form-group">
                <label class="form-label">Limit Uptime (opsional)</label>
                <input class="form-control mono" id="hs-ulimit" placeholder="1h 30m">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-hs-user')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddHotspotUser()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Script -->
<div class="modal-overlay" id="modal-add-script">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-code"></i> Tambah Script RouterOS</div>
            <button class="modal-close" onclick="closeModal('modal-add-script')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Script</label>
            <input class="form-control" id="sc-name" placeholder="my-script">
        </div>
        <div class="form-group">
            <label class="form-label">Policy</label>
            <input class="form-control" id="sc-policy" value="ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon">
        </div>
        <div class="form-group">
            <label class="form-label">Source (RouterOS Script)</label>
            <textarea class="script-editor" id="sc-source" placeholder=":log info message=&quot;Hello from script&quot;"></textarea>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-script')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddScript()"><i class="fas fa-save"></i> Simpan Script</button>
        </div>
    </div>
</div>

<!-- Modal: Add Scheduler -->
<div class="modal-overlay" id="modal-add-scheduler">
    <div class="modal" style="max-width:500px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-clock"></i> Tambah Scheduler</div>
            <button class="modal-close" onclick="closeModal('modal-add-scheduler')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama</label>
            <input class="form-control" id="sch-name" placeholder="auto-reboot">
        </div>
        <div class="form-group">
            <label class="form-label">On Event (Nama script atau perintah)</label>
            <input class="form-control mono" id="sch-event" placeholder="my-script">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Start Date</label>
                <input class="form-control" id="sch-date" placeholder="jan/01/2025">
            </div>
            <div class="form-group">
                <label class="form-label">Start Time</label>
                <input class="form-control" id="sch-time" placeholder="00:00:00">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Interval (opsional, contoh: 1d atau 1h)</label>
            <input class="form-control mono" id="sch-interval" placeholder="1d">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-scheduler')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddScheduler()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add VLAN -->
<div class="modal-overlay" id="modal-add-vlan">
    <div class="modal" style="max-width:440px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-layer-group"></i> Tambah VLAN</div>
            <button class="modal-close" onclick="closeModal('modal-add-vlan')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama</label>
            <input class="form-control" id="vlan-name" placeholder="vlan100">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">VLAN ID</label>
                <input class="form-control mono" id="vlan-id" placeholder="100" type="number">
            </div>
            <div class="form-group">
                <label class="form-label">Interface</label>
                <input class="form-control" id="vlan-iface" placeholder="ether1">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-vlan')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddVlan()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Modal: Add Address List -->
<div class="modal-overlay" id="modal-add-addrlist">
    <div class="modal" style="max-width:420px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-list-ul"></i> Tambah ke Address List</div>
            <button class="modal-close" onclick="closeModal('modal-add-addrlist')">✕</button>
        </div>
        <div class="form-group">
            <label class="form-label">Nama List</label>
            <input class="form-control" id="al-list" placeholder="blacklist">
        </div>
        <div class="form-group">
            <label class="form-label">Address</label>
            <input class="form-control mono" id="al-addr" placeholder="192.168.1.100">
        </div>
        <div class="form-group">
            <label class="form-label">Comment (opsional)</label>
            <input class="form-control" id="al-comment" placeholder="Blocked IP">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add-addrlist')">Batal</button>
            <button class="btn btn-primary" onclick="saveAddAddressList()"><i class="fas fa-save"></i> Tambahkan</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container"></div>

<script>
// ============================
// GLOBAL STATE
// ============================
let currentSiteId = null;
let isConnected = false;
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ============================
// UTILITIES
// ============================
function toast(msg, type = 'success') {
    const c = document.getElementById('toast-container');
    const t = document.createElement('div');
    const icons = { success: 'check-circle', error: 'times-circle', info: 'info-circle', warn: 'exclamation-triangle' };
    t.className = `toast toast-${type}`;
    t.innerHTML = `<i class="fas fa-${icons[type]||'info-circle'}"></i>${msg}`;
    c.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transition = 'opacity 0.3s'; setTimeout(() => t.remove(), 300); }, 3500);
}

function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function openModal(id) { document.getElementById(id).classList.add('show'); }

async function api(method, url, data = null) {
    const opts = {
        method,
        headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
    };
    if (data && method !== 'GET') opts.body = JSON.stringify(data);
    const res = await fetch(url, opts);
    return res.json();
}

function badge(text, color = 'blue') {
    const dotMap = { green: '🟢', red: '🔴', yellow: '🟡' };
    return `<span class="badge badge-${color}">${text}</span>`;
}
function statusBadge(disabled) {
    return disabled === 'true' || disabled === true
        ? badge('Disabled', 'red')
        : badge('Running', 'green');
}

function emptyRow(cols, msg = 'Tidak ada data') {
    return `<tr><td colspan="${cols}" style="text-align:center;padding:32px;color:var(--text-muted)">${msg}</td></tr>`;
}

function deleteRow(url, rowEl, msg = 'Berhasil dihapus') {
    if (!confirm('Apakah Anda yakin ingin menghapus ini?')) return;
    api('DELETE', url).then(r => {
        if (r.success) { rowEl.closest('tr').remove(); toast(msg); }
        else toast(r.message, 'error');
    });
}

// ============================
// NAVIGATION
// ============================
function showSection(id) {
    document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    const section = document.getElementById(id);
    if (section) section.classList.add('active');
    const navId = 'nav-' + id.replace('section-', '');
    const navEl = document.getElementById(navId);
    if (navEl) navEl.classList.add('active');
    document.getElementById('placeholder-no-site').style.display = 'none';
}

function loadAndShow(sectionId, loadFn) {
    if (!currentSiteId) { toast('Pilih site terlebih dahulu', 'warn'); return; }
    if (!isConnected) { toast('Hubungkan ke MikroTik terlebih dahulu', 'warn'); return; }
    showSection(sectionId);
    loadFn();
}

function switchSubTab(group, tab) {
    document.querySelectorAll(`[id^="${group}-"]`).forEach(el => {
        if (el.classList.contains('sub-content')) el.classList.remove('active');
    });
    const tabContent = document.getElementById(`${group}-${tab}`);
    if (tabContent) tabContent.classList.add('active');

    document.querySelectorAll('.sub-tab').forEach(t => {
        if (t.textContent.toLowerCase().includes(tab) || t.getAttribute('onclick')?.includes(tab)) {
            t.classList.add('active');
        } else {
            t.classList.remove('active');
        }
    });
}

// ============================
// SITE SELECTION & CONNECTION
// ============================
function onSiteChange(siteId) {
    currentSiteId = siteId || null;
    isConnected = false;
    updateConnStatus(false);
    document.getElementById('btn-connect').disabled = !siteId;
    document.getElementById('router-name').textContent = siteId ? document.querySelector(`#site-select option[value="${siteId}"]`)?.textContent?.trim() : '--';
    document.getElementById('router-stats').style.display = 'none';

    if (siteId) {
        document.getElementById('placeholder-no-site').style.display = 'none';
        showSection('section-dashboard');
    } else {
        document.getElementById('placeholder-no-site').style.display = 'flex';
        document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
    }
}

async function connectToSite() {
    if (!currentSiteId) return;
    const btn = document.getElementById('btn-connect');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner spin"></i> Menghubungkan...';
    updateConnStatus('connecting');

    try {
        const r = await api('POST', '/mikrotik/credentials/test', { site_id: currentSiteId });
        if (r.success) {
            isConnected = true;
            updateConnStatus(true);
            btn.innerHTML = '<i class="fas fa-check"></i> Terhubung';
            toast('Berhasil terhubung ke ' + (r.data?.identity || 'MikroTik'), 'success');
            updateRouterCard(r.data);
            refreshDashboard();
        } else {
            updateConnStatus(false);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Hubungkan';

            // Jika belum ada credentials → buka modal credentials otomatis
            if (r.message && r.message.toLowerCase().includes('credentials belum')) {
                toast('Silakan isi credentials MikroTik terlebih dahulu', 'warn');
                openModal('modal-credentials');
            } else {
                toast('Gagal: ' + r.message, 'error');
            }
        }
    } catch {
        updateConnStatus(false);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plug"></i> Hubungkan';
        toast('Error koneksi', 'error');
    }
}

function updateConnStatus(state) {
    const badge = document.getElementById('conn-status-header');
    const text = document.getElementById('conn-status-text');
    const rb = document.getElementById('router-status-badge');
    badge.className = 'status-badge';
    rb.className = 'status-badge';
    if (state === true) {
        badge.classList.add('online'); rb.classList.add('online');
        text.textContent = 'Terhubung';
        rb.innerHTML = '<span class="status-dot"></span> Online';
    } else if (state === 'connecting') {
        badge.classList.add('connecting'); rb.classList.add('connecting');
        text.textContent = 'Menghubungkan...';
        rb.innerHTML = '<span class="status-dot"></span> Connecting';
    } else {
        badge.classList.add('offline'); rb.classList.add('offline');
        text.textContent = 'Belum Terhubung';
        rb.innerHTML = '<span class="status-dot"></span> Offline';
    }
}

function updateRouterCard(data) {
    if (!data) return;
    const res = data.resource || {};
    document.getElementById('rt-cpu').textContent = (res['cpu-load'] || '0') + '%';
    document.getElementById('rt-ram').textContent = res['free-memory'] ? formatBytes(parseInt(res['total-memory']) - parseInt(res['free-memory'])) : '--';
    document.getElementById('rt-uptime').textContent = (res.uptime || '--').substring(0, 10);
    document.getElementById('rt-os').textContent = (res.version || '--').substring(0, 8);
    document.getElementById('router-stats').style.display = 'grid';
}

// ============================
// CREDENTIALS MODAL
// ============================
function openCredModal() {
    if (!currentSiteId) { toast('Pilih site terlebih dahulu', 'warn'); return; }

    // Auto-fill IP dari data site jika ada
    const siteOption = document.querySelector(`#site-select option[value="${currentSiteId}"]`);
    const ipRouter = siteOption?.dataset?.ip || '';

    api('GET', `/mikrotik/credentials/${currentSiteId}`).then(r => {
        if (r.success) {
            document.getElementById('cred-host').value = r.data.api_host || ipRouter;
            document.getElementById('cred-port').value = r.data.api_port || 8728;
            document.getElementById('cred-user').value = r.data.api_user || 'admin';
        } else {
            // Credentials belum ada — isi default dari IP router site
            document.getElementById('cred-host').value = ipRouter;
            document.getElementById('cred-port').value = 8728;
            document.getElementById('cred-user').value = 'admin';
            document.getElementById('cred-pass').value = '';
        }
    });
    openModal('modal-credentials');
}

async function saveCredentials() {
    if (!currentSiteId) return;
    const data = {
        site_id: currentSiteId,
        api_host: document.getElementById('cred-host').value,
        api_port: parseInt(document.getElementById('cred-port').value),
        api_user: document.getElementById('cred-user').value,
        api_password: document.getElementById('cred-pass').value,
    };
    const r = await api('POST', '/mikrotik/credentials/save', data);
    if (r.success) { toast('Credentials tersimpan!'); closeModal('modal-credentials'); }
    else toast(r.message, 'error');
}

async function testConnectionModal() {
    if (!currentSiteId) return;
    await saveCredentials();
    const r = await api('POST', '/mikrotik/credentials/test', { site_id: currentSiteId });
    if (r.success) toast('✅ Koneksi berhasil! Router: ' + r.data?.identity, 'success');
    else toast('❌ ' + r.message, 'error');
}

// ============================
// DASHBOARD
// ============================
async function refreshDashboard() {
    if (!currentSiteId || !isConnected) return;
    const r = await api('GET', `/mikrotik/system/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    const res = r.data.resource || {};
    const identity = r.data.identity || {};

    const cpu = parseInt(res['cpu-load'] || 0);
    const totalMem = parseInt(res['total-memory'] || 1);
    const freeMem = parseInt(res['free-memory'] || 0);
    const ramPct = Math.round(((totalMem - freeMem) / totalMem) * 100);
    const totalDisk = parseInt(res['total-hdd-space'] || 1);
    const freeDisk = parseInt(res['free-hdd-space'] || 0);
    const diskPct = Math.round(((totalDisk - freeDisk) / totalDisk) * 100);

    document.getElementById('d-cpu').textContent = cpu + '%';
    document.getElementById('d-cpu-bar').style.width = cpu + '%';
    document.getElementById('d-ram').textContent = ramPct + '%';
    document.getElementById('d-ram-bar').style.width = ramPct + '%';
    document.getElementById('d-hdd').textContent = diskPct + '%';
    document.getElementById('d-hdd-bar').style.width = diskPct + '%';
    document.getElementById('d-uptime').textContent = res.uptime || '--';
    document.getElementById('dash-hostname').textContent = identity.name || '--';

    document.getElementById('system-info-table').innerHTML = `
        <tr><td style="color:var(--text-secondary);width:180px">Nama Router</td><td class="mono">${identity.name||'--'}</td></tr>
        <tr><td style="color:var(--text-secondary)">RouterOS Version</td><td class="mono">${res.version||'--'}</td></tr>
        <tr><td style="color:var(--text-secondary)">Architecture</td><td class="mono">${res['architecture-name']||'--'}</td></tr>
        <tr><td style="color:var(--text-secondary)">Board</td><td class="mono">${res['board-name']||'--'}</td></tr>
        <tr><td style="color:var(--text-secondary)">CPU</td><td class="mono">${res.cpu||'--'} × ${res['cpu-count']||1} core</td></tr>
        <tr><td style="color:var(--text-secondary)">RAM Total</td><td class="mono">${formatBytes(totalMem)}</td></tr>
        <tr><td style="color:var(--text-secondary)">HDD Total</td><td class="mono">${formatBytes(totalDisk)}</td></tr>
        <tr><td style="color:var(--text-secondary)">Uptime</td><td class="mono">${res.uptime||'--'}</td></tr>
    `;

    rt_cpu.textContent = cpu + '%';
    rt_ram.textContent = ramPct + '%';
    rt_uptime.textContent = (res.uptime||'--').substring(0,10);
    rt_os.textContent = (res.version||'--').substring(0,8);
    document.getElementById('router-stats').style.display = 'grid';
}

function openIdentityModal() {
    const curr = document.getElementById('dash-hostname').textContent;
    document.getElementById('identity-name').value = curr !== 'Informasi sistem router' ? curr : '';
    openModal('modal-identity');
}

async function saveIdentity() {
    const name = document.getElementById('identity-name').value.trim();
    if (!name) return;
    const r = await api('POST', `/mikrotik/system/${currentSiteId}/identity`, { name });
    if (r.success) { toast('Identity berhasil diubah'); closeModal('modal-identity'); refreshDashboard(); }
    else toast(r.message, 'error');
}

function confirmReboot() {
    if (!confirm('⚠️ PERINGATAN: Router akan di-reboot. Koneksi akan terputus sementara. Yakin?')) return;
    api('POST', `/mikrotik/system/${currentSiteId}/reboot`).then(r => {
        if (r.success) toast('Perintah reboot berhasil dikirim', 'warn');
        else toast(r.message, 'error');
    });
}

// ============================
// INTERFACE
// ============================
async function loadInterfaces() {
    const r = await api('GET', `/mikrotik/interface/${currentSiteId}`);
    const body = document.getElementById('interface-table-body');
    if (!r.success) { body.innerHTML = emptyRow(7, '⚠️ ' + r.message); return; }
    if (!r.data.length) { body.innerHTML = emptyRow(7); return; }
    body.innerHTML = r.data.map(i => `
        <tr>
            <td><strong>${i.name}</strong></td>
            <td>${badge(i.type||'ether', 'purple')}</td>
            <td class="mono" style="font-size:11px">${i['mac-address']||'--'}</td>
            <td>${i.mtu||'1500'}</td>
            <td>${statusBadge(i.disabled)}</td>
            <td class="mono" style="font-size:11px">${i['tx-byte']?formatBytes(parseInt(i['tx-byte']))+' / '+formatBytes(parseInt(i['rx-byte']||0)):'--'}</td>
            <td>
                <button class="btn btn-sm ${i.disabled==='true'?'btn-success':'btn-warning'}" onclick="toggleInterface('${i['.id']}','${i.disabled==='true'?'enable':'disable'}',this)">
                    <i class="fas fa-${i.disabled==='true'?'play':'pause'}"></i>
                </button>
            </td>
        </tr>`).join('');

    const vr = await api('GET', `/mikrotik/vlan/${currentSiteId}`);
    const vBody = document.getElementById('vlan-table-body');
    if (vr.success && vr.data.length) {
        vBody.innerHTML = vr.data.map(v => `
            <tr>
                <td>${v.name}</td>
                <td class="mono">${v['vlan-id']||'--'}</td>
                <td>${v.interface||'--'}</td>
                <td>${statusBadge(v.disabled)}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteRow('/mikrotik/vlan/${currentSiteId}/remove',this,'VLAN dihapus')" data-id="${v['.id']}"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('');
    } else vBody.innerHTML = emptyRow(5);

    const br = await api('GET', `/mikrotik/bridge/${currentSiteId}`);
    const bBody = document.getElementById('bridge-table-body');
    if (br.success && br.data.length) {
        bBody.innerHTML = br.data.map(b => `
            <tr>
                <td>${b.name}</td>
                <td>${b['protocol-mode']||'rstp'}</td>
                <td>${statusBadge(b.disabled)}</td>
                <td class="mono" style="font-size:11px">${b['port-count']||'?'} ports</td>
            </tr>`).join('');
    } else bBody.innerHTML = emptyRow(4);
}

async function toggleInterface(id, action, btn) {
    const r = await api('POST', `/mikrotik/interface/${currentSiteId}/toggle`, { '.id': id, action });
    if (r.success) { toast('Interface berhasil di-' + action, 'success'); loadInterfaces(); }
    else toast(r.message, 'error');
}

// VLAN
function openAddVlanModal() { openModal('modal-add-vlan'); }
async function saveAddVlan() {
    const data = { name: document.getElementById('vlan-name').value, 'vlan-id': document.getElementById('vlan-id').value, interface: document.getElementById('vlan-iface').value };
    const r = await api('POST', `/mikrotik/vlan/${currentSiteId}/add`, data);
    if (r.success) { toast('VLAN ditambahkan'); closeModal('modal-add-vlan'); loadInterfaces(); }
    else toast(r.message, 'error');
}

// ============================
// IP ADDRESS
// ============================
async function loadIpAddresses() {
    const r = await api('GET', `/mikrotik/ip/${currentSiteId}`);
    const body = document.getElementById('ip-table-body');
    if (!r.success) { body.innerHTML = emptyRow(5, '⚠️ ' + r.message); return; }
    if (!r.data.length) { body.innerHTML = emptyRow(5); return; }
    body.innerHTML = r.data.map(ip => `
        <tr>
            <td class="mono">${ip.address}</td>
            <td class="mono">${ip.network||'--'}</td>
            <td>${ip.interface||'--'}</td>
            <td>${statusBadge(ip.disabled)}</td>
            <td style="display:flex;gap:4px">
                <button class="btn btn-danger btn-sm btn-icon" onclick="deleteIp('${ip['.id']}',this)"><i class="fas fa-trash"></i></button>
            </td>
        </tr>`).join('');
}

function openAddIpModal() { openModal('modal-add-ip'); }
async function saveAddIp() {
    const data = { address: document.getElementById('add-ip-address').value, interface: document.getElementById('add-ip-iface').value, comment: document.getElementById('add-ip-comment').value };
    const r = await api('POST', `/mikrotik/ip/${currentSiteId}/add`, data);
    if (r.success) { toast('IP Address ditambahkan'); closeModal('modal-add-ip'); loadIpAddresses(); }
    else toast(r.message, 'error');
}

async function deleteIp(id, btn) {
    if (!confirm('Hapus IP address ini?')) return;
    const r = await api('DELETE', `/mikrotik/ip/${currentSiteId}/remove`, { '.id': id });
    if (r.success) { toast('IP dihapus'); loadIpAddresses(); }
    else toast(r.message, 'error');
}

// ============================
// ROUTES
// ============================
async function loadRoutes() {
    const r = await api('GET', `/mikrotik/routes/${currentSiteId}`);
    const body = document.getElementById('route-table-body');
    if (!r.success) { body.innerHTML = emptyRow(6, '⚠️ ' + r.message); return; }
    if (!r.data.length) { body.innerHTML = emptyRow(6); return; }
    body.innerHTML = r.data.map(rt => `
        <tr>
            <td class="mono">${rt['dst-address']||'--'}</td>
            <td class="mono">${rt.gateway||'--'}</td>
            <td>${rt.distance||'1'}</td>
            <td class="mono">${rt['routing-mark']||'main'}</td>
            <td>${rt.active==='true'?badge('Active','green'):badge('Inactive','red')}</td>
            <td>${rt['static']!=='true'?'':`<button class="btn btn-danger btn-sm btn-icon" onclick="deleteRoute('${rt['.id']}',this)"><i class="fas fa-trash"></i></button>`}</td>
        </tr>`).join('');
}

function openAddRouteModal() { openModal('modal-add-route'); }
async function saveAddRoute() {
    const data = { 'dst-address': document.getElementById('route-dst').value, gateway: document.getElementById('route-gw').value, distance: document.getElementById('route-dist').value, comment: document.getElementById('route-comment').value };
    const r = await api('POST', `/mikrotik/routes/${currentSiteId}/add`, data);
    if (r.success) { toast('Route ditambahkan'); closeModal('modal-add-route'); loadRoutes(); }
    else toast(r.message, 'error');
}

async function deleteRoute(id, btn) {
    if (!confirm('Hapus route ini?')) return;
    const r = await api('DELETE', `/mikrotik/routes/${currentSiteId}/remove`, { '.id': id });
    if (r.success) { toast('Route dihapus'); loadRoutes(); }
    else toast(r.message, 'error');
}

// ============================
// DHCP
// ============================
async function loadDhcp() {
    const [srv, leases, nets] = await Promise.all([
        api('GET', `/mikrotik/dhcp/${currentSiteId}/servers`),
        api('GET', `/mikrotik/dhcp/${currentSiteId}/leases`),
        api('GET', `/mikrotik/dhcp/${currentSiteId}/networks`)
    ]);

    document.getElementById('dhcp-servers-body').innerHTML = srv.success && srv.data.length
        ? srv.data.map(s => `<tr><td>${s.name}</td><td>${s.interface||'--'}</td><td class="mono">${s['address-pool']||'--'}</td><td>${s['lease-time']||'--'}</td><td>${statusBadge(s.disabled)}</td></tr>`).join('')
        : emptyRow(5);

    document.getElementById('dhcp-leases-body').innerHTML = leases.success && leases.data.length
        ? leases.data.map(l => `
            <tr>
                <td class="mono">${l.address||'--'}</td>
                <td class="mono">${l['mac-address']||'--'}</td>
                <td>${l.hostname||'--'}</td>
                <td>${l.server||'--'}</td>
                <td>${l['status']?badge(l.status, l.status==='bound'?'green':'yellow'):badge('Unknown','red')}</td>
                <td style="display:flex;gap:4px">
                    ${l.dynamic==='true'?`<button class="btn btn-purple btn-sm" onclick="makeDhcpStatic('${l['.id']}')"><i class="fas fa-thumbtack"></i></button>`:''}
                    <button class="btn btn-danger btn-sm btn-icon" onclick="deleteDhcpLease('${l['.id']}',this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`).join('')
        : emptyRow(6);

    document.getElementById('dhcp-networks-body').innerHTML = nets.success && nets.data.length
        ? nets.data.map(n => `<tr><td class="mono">${n.address||'--'}</td><td class="mono">${n.gateway||'--'}</td><td class="mono">${n['dns-server']||'--'}</td><td>${n.domain||'--'}</td></tr>`).join('')
        : emptyRow(4);
}

function openAddLeaseModal() { openModal('modal-add-lease'); }
async function saveAddLease() {
    const data = { address: document.getElementById('lease-ip').value, 'mac-address': document.getElementById('lease-mac').value, comment: document.getElementById('lease-comment').value };
    const r = await api('POST', `/mikrotik/dhcp/${currentSiteId}/lease/add`, data);
    if (r.success) { toast('Lease ditambahkan'); closeModal('modal-add-lease'); loadDhcp(); }
    else toast(r.message, 'error');
}

async function deleteDhcpLease(id) {
    if (!confirm('Hapus lease ini?')) return;
    const r = await api('DELETE', `/mikrotik/dhcp/${currentSiteId}/lease`, { '.id': id });
    if (r.success) { toast('Lease dihapus'); loadDhcp(); }
    else toast(r.message, 'error');
}

async function makeDhcpStatic(id) {
    const r = await api('POST', `/mikrotik/dhcp/${currentSiteId}/lease/static`, { '.id': id });
    if (r.success) { toast('Lease dijadikan static'); loadDhcp(); }
    else toast(r.message, 'error');
}

// ============================
// DNS
// ============================
async function loadDns() {
    const [dnsR, stR] = await Promise.all([
        api('GET', `/mikrotik/dns/${currentSiteId}`),
        api('GET', `/mikrotik/dns/${currentSiteId}/static`)
    ]);
    if (dnsR.success && dnsR.data[0]) {
        const d = dnsR.data[0];
        document.getElementById('dns-servers').value = d.servers || '';
        document.getElementById('dns-max-udp').value = d['max-udp-packet-size'] || '';
        document.getElementById('dns-allow-remote').checked = d['allow-remote-requests'] === 'yes';
    }
    document.getElementById('dns-static-body').innerHTML = stR.success && stR.data.length
        ? stR.data.map(s => `<tr><td class="mono">${s.name}</td><td class="mono">${s.address||'--'}</td><td>${s.ttl||'--'}</td><td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteDnsStatic('${s['.id']}')"><i class="fas fa-trash"></i></button></td></tr>`).join('')
        : emptyRow(4);
}

async function saveDnsSettings() {
    const data = {
        servers: document.getElementById('dns-servers').value,
        'max-udp-packet-size': document.getElementById('dns-max-udp').value,
        'allow-remote-requests': document.getElementById('dns-allow-remote').checked ? 'yes' : 'no'
    };
    const r = await api('POST', `/mikrotik/dns/${currentSiteId}/set`, data);
    if (r.success) toast('DNS settings disimpan');
    else toast(r.message, 'error');
}

function openAddDnsStaticModal() { openModal('modal-add-dns'); }
async function saveAddDnsStatic() {
    const data = { name: document.getElementById('dns-static-name').value, address: document.getElementById('dns-static-addr').value };
    const r = await api('POST', `/mikrotik/dns/${currentSiteId}/static/add`, data);
    if (r.success) { toast('DNS static ditambahkan'); closeModal('modal-add-dns'); loadDns(); }
    else toast(r.message, 'error');
}

async function deleteDnsStatic(id) {
    if (!confirm('Hapus DNS static ini?')) return;
    const r = await api('DELETE', `/mikrotik/dns/${currentSiteId}/static`, { '.id': id });
    if (r.success) { toast('DNS static dihapus'); loadDns(); }
    else toast(r.message, 'error');
}

// ============================
// FIREWALL
// ============================
async function loadFirewall() {
    const [filterR, natR, manR, alR] = await Promise.all([
        api('GET', `/mikrotik/firewall/${currentSiteId}/filter`),
        api('GET', `/mikrotik/firewall/${currentSiteId}/nat`),
        api('GET', `/mikrotik/firewall/${currentSiteId}/mangle`),
        api('GET', `/mikrotik/firewall/${currentSiteId}/address-list`)
    ]);

    document.getElementById('fw-filter-body').innerHTML = filterR.success && filterR.data.length
        ? filterR.data.map((r,i) => `
            <tr>
                <td>${i+1}</td>
                <td>${badge(r.chain,'blue')}</td>
                <td>${badge(r.action, r.action==='accept'?'green':r.action==='drop'?'red':'yellow')}</td>
                <td>${r.protocol||'any'}</td>
                <td class="mono" style="font-size:11px">${r['src-address']||'0.0.0.0/0'}</td>
                <td class="mono">${r['dst-port']||'any'}</td>
                <td>${statusBadge(r.disabled)}</td>
                <td style="display:flex;gap:4px">
                    <button class="btn btn-sm ${r.disabled==='true'?'btn-success':'btn-warning'}" onclick="toggleFirewall('${r['.id']}','${r.disabled==='true'?'enable':'disable'}','filter')">
                        <i class="fas fa-${r.disabled==='true'?'play':'pause'}"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-icon" onclick="deleteFirewallFilter('${r['.id']}','filter')"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`).join('')
        : emptyRow(8);

    document.getElementById('fw-nat-body').innerHTML = natR.success && natR.data.length
        ? natR.data.map(r => `
            <tr>
                <td>${badge(r.chain,'blue')}</td>
                <td>${badge(r.action,r.action==='masquerade'?'purple':'yellow')}</td>
                <td>${r.protocol||'any'}</td>
                <td class="mono" style="font-size:11px">${r['dst-address']||'any'}</td>
                <td class="mono" style="font-size:11px">${r['to-addresses']||'--'}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteFirewallFilter('${r['.id']}','nat')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('')
        : emptyRow(6);

    document.getElementById('fw-mangle-body').innerHTML = manR.success && manR.data.length
        ? manR.data.map(r => `<tr><td>${r.chain}</td><td>${r.action}</td><td>${r.protocol||'any'}</td><td class="mono">${r['new-packet-mark']||r['new-connection-mark']||'--'}</td><td>${statusBadge(r.disabled)}</td></tr>`).join('')
        : emptyRow(5);

    document.getElementById('fw-addrlist-body').innerHTML = alR.success && alR.data.length
        ? alR.data.map(r => `
            <tr>
                <td>${badge(r.list,'purple')}</td>
                <td class="mono">${r.address}</td>
                <td>${r.timeout||'permanent'}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteAddressList('${r['.id']}')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('')
        : emptyRow(4);
}

function openAddFirewallModal(type) {
    document.getElementById('fw-type').value = type;
    document.getElementById('fw-modal-title').innerHTML = `<i class="fas fa-shield-alt"></i> Tambah ${type.toUpperCase()} Rule`;
    openModal('modal-add-fw');
}

async function saveFirewallRule() {
    const type = document.getElementById('fw-type').value;
    const data = {
        chain: document.getElementById('fw-chain').value,
        action: document.getElementById('fw-action').value,
        protocol: document.getElementById('fw-protocol').value || undefined,
        'src-address': document.getElementById('fw-src-addr').value || undefined,
        'dst-address': document.getElementById('fw-dst-addr').value || undefined,
        'dst-port': document.getElementById('fw-dst-port').value || undefined,
        'in-interface': document.getElementById('fw-in-iface').value || undefined,
        comment: document.getElementById('fw-comment').value || undefined,
    };
    const r = await api('POST', `/mikrotik/firewall/${currentSiteId}/${type}/add`, data);
    if (r.success) { toast('Rule ditambahkan'); closeModal('modal-add-fw'); loadFirewall(); }
    else toast(r.message, 'error');
}

async function toggleFirewall(id, action, type) {
    const r = await api('POST', `/mikrotik/firewall/${currentSiteId}/filter/toggle`, { '.id': id, action });
    if (r.success) { toast(`Rule di-${action}`); loadFirewall(); }
    else toast(r.message, 'error');
}

async function deleteFirewallFilter(id, type) {
    if (!confirm('Hapus firewall rule ini?')) return;
    const url = type === 'nat' ? `/mikrotik/firewall/${currentSiteId}/nat` : `/mikrotik/firewall/${currentSiteId}/filter`;
    const r = await api('DELETE', url, { '.id': id });
    if (r.success) { toast('Rule dihapus'); loadFirewall(); }
    else toast(r.message, 'error');
}

function openAddAddressListModal() { openModal('modal-add-addrlist'); }
async function saveAddAddressList() {
    const data = { list: document.getElementById('al-list').value, address: document.getElementById('al-addr').value, comment: document.getElementById('al-comment').value };
    const r = await api('POST', `/mikrotik/firewall/${currentSiteId}/address-list`, data);
    if (r.success) { toast('Address list ditambahkan'); closeModal('modal-add-addrlist'); loadFirewall(); }
    else toast(r.message, 'error');
}

async function deleteAddressList(id) {
    if (!confirm('Hapus dari address list?')) return;
    const r = await api('DELETE', `/mikrotik/firewall/${currentSiteId}/address-list`, { '.id': id });
    // reload
    if (r.success) { toast('Dihapus'); loadFirewall(); }
    else toast(r.message, 'error');
}

// ============================
// WIRELESS
// ============================
async function loadWireless() {
    const r = await api('GET', `/mikrotik/wireless/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    const { interfaces, registrations, security_profiles } = r.data;

    document.getElementById('wl-iface-body').innerHTML = interfaces?.length
        ? interfaces.map(i => `
            <tr>
                <td>${i.name}</td>
                <td class="mono">${i.ssid||'--'}</td>
                <td>${i.band||'--'}</td>
                <td class="mono">${i['current-channel']||i.channel||'--'}</td>
                <td>${i['tx-power']||'default'}</td>
                <td>${statusBadge(i.disabled)}</td>
                <td><button class="btn btn-secondary btn-sm" onclick="openEditWireless('${i['.id']}','${i.ssid||''}','${i.channel||''}','${i['tx-power']||''}')"><i class="fas fa-edit"></i></button></td>
            </tr>`).join('')
        : emptyRow(7, 'Tidak ada wireless interface');

    document.getElementById('wl-reg-body').innerHTML = registrations?.length
        ? registrations.map(r => `
            <tr>
                <td class="mono">${r['mac-address']}</td>
                <td>${r.interface}</td>
                <td>${r['signal-strength']||'--'} dBm</td>
                <td class="mono">${r['tx-rate']||'--'} / ${r['rx-rate']||'--'}</td>
                <td>${r.uptime||'--'}</td>
            </tr>`).join('')
        : emptyRow(5, 'Tidak ada klien terhubung');

    document.getElementById('wl-sec-body').innerHTML = security_profiles?.length
        ? security_profiles.map(s => `<tr><td>${s.name}</td><td>${s.mode||'--'}</td><td>${s['authentication-types']||'--'}</td><td>${s['unicast-ciphers']||'--'}</td></tr>`).join('')
        : emptyRow(4);
}

async function openEditWireless(id, ssid, channel, txPower) {
    const newSsid = prompt('SSID baru:', ssid);
    if (newSsid === null) return;
    const params = { ssid: newSsid };
    const r = await api('POST', `/mikrotik/wireless/${currentSiteId}/set`, { '.id': id, ...params });
    if (r.success) { toast('Wireless diupdate'); loadWireless(); }
    else toast(r.message, 'error');
}

// ============================
// USERS
// ============================
async function loadUsers() {
    const r = await api('GET', `/mikrotik/users/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('users-table-body').innerHTML = r.data.users?.length
        ? r.data.users.map(u => `
            <tr>
                <td><strong>${u.name}</strong></td>
                <td>${badge(u.group||'read', u.group==='full'?'green':u.group==='write'?'blue':'purple')}</td>
                <td style="color:var(--text-secondary)">${u.comment||'--'}</td>
                <td class="mono">${u.address||'0.0.0.0/0'}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteUser('${u['.id']}')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('')
        : emptyRow(5);

    document.getElementById('users-active-body').innerHTML = r.data.active_list?.length
        ? r.data.active_list.map(u => `<tr><td>${u.name}</td><td class="mono">${u.address||'--'}</td><td>${u.via||'--'}</td><td>${u.uptime||'--'}</td></tr>`).join('')
        : emptyRow(4, 'Tidak ada sesi aktif');
}

function openAddUserModal() { openModal('modal-add-user'); }
async function saveAddUser() {
    const data = { name: document.getElementById('user-name').value, password: document.getElementById('user-pass').value, group: document.getElementById('user-group').value, address: document.getElementById('user-addr').value };
    const r = await api('POST', `/mikrotik/users/${currentSiteId}/add`, data);
    if (r.success) { toast('User ditambahkan'); closeModal('modal-add-user'); loadUsers(); }
    else toast(r.message, 'error');
}

async function deleteUser(id) {
    if (!confirm('Hapus user ini?')) return;
    const r = await api('DELETE', `/mikrotik/users/${currentSiteId}/remove`, { '.id': id });
    if (r.success) { toast('User dihapus'); loadUsers(); }
    else toast(r.message, 'error');
}

// ============================
// QUEUE
// ============================
async function loadQueues() {
    const r = await api('GET', `/mikrotik/queue/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('queue-table-body').innerHTML = r.data.simple?.length
        ? r.data.simple.map(q => `
            <tr>
                <td><strong>${q.name}</strong></td>
                <td class="mono">${q.target||'--'}</td>
                <td class="mono">${q['max-limit']?.split('/')[0]||'--'}</td>
                <td class="mono">${q['max-limit']?.split('/')[1]||'--'}</td>
                <td>${q.priority||'8'}</td>
                <td>${statusBadge(q.disabled)}</td>
                <td style="display:flex;gap:4px">
                    <button class="btn btn-sm ${q.disabled==='true'?'btn-success':'btn-warning'}" onclick="toggleQueueRow('${q['.id']}','${q.disabled==='true'?'enable':'disable'}')">
                        <i class="fas fa-${q.disabled==='true'?'play':'pause'}"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-icon" onclick="deleteQueue('${q['.id']}')"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`).join('')
        : emptyRow(7);
}

function openAddQueueModal() { openModal('modal-add-queue'); }
async function saveAddQueue() {
    const ul = document.getElementById('q-upload').value;
    const dl = document.getElementById('q-download').value;
    const data = { name: document.getElementById('q-name').value, target: document.getElementById('q-target').value, 'max-limit': `${ul}/${dl}` };
    const r = await api('POST', `/mikrotik/queue/${currentSiteId}/add`, data);
    if (r.success) { toast('Queue ditambahkan'); closeModal('modal-add-queue'); loadQueues(); }
    else toast(r.message, 'error');
}

async function toggleQueueRow(id, action) {
    const r = await api('POST', `/mikrotik/queue/${currentSiteId}/toggle`, { '.id': id, action });
    if (r.success) { toast(`Queue di-${action}`); loadQueues(); }
    else toast(r.message, 'error');
}

async function deleteQueue(id) {
    if (!confirm('Hapus queue ini?')) return;
    const r = await api('DELETE', `/mikrotik/queue/${currentSiteId}/remove`, { '.id': id });
    if (r.success) { toast('Queue dihapus'); loadQueues(); }
    else toast(r.message, 'error');
}

// ============================
// PPP
// ============================
async function loadPpp() {
    const r = await api('GET', `/mikrotik/ppp/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('ppp-secrets-body').innerHTML = r.data.secrets?.length
        ? r.data.secrets.map(s => `
            <tr>
                <td><strong>${s.name}</strong></td>
                <td>${badge(s.service||'any','blue')}</td>
                <td>${s.profile||'--'}</td>
                <td class="mono">${s['local-address']||'--'}</td>
                <td class="mono">${s['remote-address']||'--'}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deletePppSecret('${s['.id']}')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('')
        : emptyRow(6);

    document.getElementById('ppp-active-body').innerHTML = r.data.active?.length
        ? r.data.active.map(a => `<tr><td>${a.name}</td><td class="mono">${a.address||'--'}</td><td>${a.service||'--'}</td><td>${a.uptime||'--'}</td></tr>`).join('')
        : emptyRow(4, 'Tidak ada sesi aktif');

    document.getElementById('ppp-profiles-body').innerHTML = r.data.profiles?.length
        ? r.data.profiles.map(p => `<tr><td>${p.name}</td><td class="mono">${p['local-address']||'--'}</td><td class="mono">${p['remote-address']||'--'}</td><td class="mono">${p['rate-limit']||'--'}</td></tr>`).join('')
        : emptyRow(4);
}

function openAddPppModal() { openModal('modal-add-ppp'); }
async function saveAddPpp() {
    const data = { name: document.getElementById('ppp-name').value, password: document.getElementById('ppp-pass').value, service: document.getElementById('ppp-service').value, profile: document.getElementById('ppp-profile').value, 'local-address': document.getElementById('ppp-local').value, 'remote-address': document.getElementById('ppp-remote').value };
    const r = await api('POST', `/mikrotik/ppp/${currentSiteId}/secret/add`, data);
    if (r.success) { toast('PPP Secret ditambahkan'); closeModal('modal-add-ppp'); loadPpp(); }
    else toast(r.message, 'error');
}

async function deletePppSecret(id) {
    if (!confirm('Hapus PPP secret ini?')) return;
    const r = await api('DELETE', `/mikrotik/ppp/${currentSiteId}/secret`, { '.id': id });
    if (r.success) { toast('Secret dihapus'); loadPpp(); }
    else toast(r.message, 'error');
}

// ============================
// HOTSPOT
// ============================
async function loadHotspot() {
    const r = await api('GET', `/mikrotik/hotspot/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('hs-users-body').innerHTML = r.data.users?.length
        ? r.data.users.map(u => `
            <tr>
                <td><strong>${u.name}</strong></td>
                <td>${u.profile||'default'}</td>
                <td>${u['limit-uptime']||'unlimited'}</td>
                <td>${u['limit-bytes-total']||'unlimited'}</td>
                <td><button class="btn btn-danger btn-sm btn-icon" onclick="deleteHotspotUser('${u['.id']}')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('')
        : emptyRow(5);

    document.getElementById('hs-active-body').innerHTML = r.data.active?.length
        ? r.data.active.map(a => `<tr><td>${a.user||'--'}</td><td class="mono">${a.address||'--'}</td><td class="mono">${a['mac-address']||'--'}</td><td>${a.uptime||'--'}</td><td>${a['session-time-left']||'unlimited'}</td></tr>`).join('')
        : emptyRow(5, 'Tidak ada sesi aktif');

    document.getElementById('hs-servers-body').innerHTML = r.data.servers?.length
        ? r.data.servers.map(s => `<tr><td>${s.name}</td><td>${s.interface||'--'}</td><td>${s['address-pool']||'--'}</td><td>${s.profile||'default'}</td><td>${statusBadge(s.invalid)}</td></tr>`).join('')
        : emptyRow(5);
}

function openAddHotspotUserModal() { openModal('modal-add-hs-user'); }
async function saveAddHotspotUser() {
    const data = { name: document.getElementById('hs-uname').value, password: document.getElementById('hs-upass').value, profile: document.getElementById('hs-uprof').value, 'limit-uptime': document.getElementById('hs-ulimit').value };
    const r = await api('POST', `/mikrotik/hotspot/${currentSiteId}/user/add`, data);
    if (r.success) { toast('User hotspot ditambahkan'); closeModal('modal-add-hs-user'); loadHotspot(); }
    else toast(r.message, 'error');
}

async function deleteHotspotUser(id) {
    if (!confirm('Hapus user hotspot ini?')) return;
    const r = await api('DELETE', `/mikrotik/hotspot/${currentSiteId}/user`, { '.id': id });
    if (r.success) { toast('User dihapus'); loadHotspot(); }
    else toast(r.message, 'error');
}

// ============================
// IP SERVICES
// ============================
async function loadServices() {
    const r = await api('GET', `/mikrotik/services/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('services-table-body').innerHTML = r.data.length
        ? r.data.map(s => `
            <tr>
                <td><strong>${s.name}</strong></td>
                <td class="mono">${s.port||'--'}</td>
                <td class="mono">${s.address||'0.0.0.0/0'}</td>
                <td>${statusBadge(s.disabled)}</td>
                <td>
                    <button class="btn btn-sm ${s.disabled==='true'?'btn-success':'btn-warning'}" onclick="toggleService('${s['.id']}','${s.disabled==='true'?'enable':'disable'}')">
                        <i class="fas fa-${s.disabled==='true'?'play':'pause'}"></i> ${s.disabled==='true'?'Enable':'Disable'}
                    </button>
                </td>
            </tr>`).join('')
        : emptyRow(5);
}

async function toggleService(id, action) {
    const r = await api('POST', `/mikrotik/services/${currentSiteId}/toggle`, { '.id': id, action });
    if (r.success) { toast(`Service di-${action}`); loadServices(); }
    else toast(r.message, 'error');
}

// ============================
// ARP
// ============================
async function loadArp() {
    const r = await api('GET', `/mikrotik/arp/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('arp-table-body').innerHTML = r.data.arp?.length
        ? r.data.arp.map(a => `<tr><td class="mono">${a.address}</td><td class="mono">${a['mac-address']||'--'}</td><td>${a.interface||'--'}</td><td>${badge(a.dynamic==='true'?'Dynamic':'Static', a.dynamic==='true'?'blue':'purple')}</td></tr>`).join('')
        : emptyRow(4);

    document.getElementById('neighbor-table-body').innerHTML = r.data.neighbors?.length
        ? r.data.neighbors.map(n => `<tr><td>${n.identity||'--'}</td><td class="mono">${n.address||'--'}</td><td class="mono">${n['mac-address']||'--'}</td><td>${n.interface||'--'}</td><td>${n.platform||'--'}</td><td>${n.version||'--'}</td></tr>`).join('')
        : emptyRow(6, 'Tidak ada neighbor');
}

// ============================
// SCRIPTS
// ============================
async function loadScripts() {
    const r = await api('GET', `/mikrotik/scripts/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('scripts-table-body').innerHTML = r.data.scripts?.length
        ? r.data.scripts.map(s => `
            <tr>
                <td><strong>${s.name}</strong></td>
                <td class="mono" style="font-size:10px">${(s.policy||'').substring(0,30)}</td>
                <td>${s['last-started']||'--'}</td>
                <td style="display:flex;gap:4px">
                    <button class="btn btn-success btn-sm" onclick="runScriptRow('${s['.id']}','${s.name}')"><i class="fas fa-play"></i> Run</button>
                    <button class="btn btn-danger btn-sm btn-icon" onclick="deleteScriptRow('${s['.id']}')"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`).join('')
        : emptyRow(4);

    document.getElementById('schedulers-table-body').innerHTML = r.data.schedulers?.length
        ? r.data.schedulers.map(s => `<tr><td>${s.name}</td><td class="mono">${s['start-date']||'--'}</td><td class="mono">${s.interval||'--'}</td><td class="mono">${s['on-event']||'--'}</td><td>${statusBadge(s.disabled)}</td></tr>`).join('')
        : emptyRow(5);
}

function openAddScriptModal() { openModal('modal-add-script'); }
async function saveAddScript() {
    const data = { name: document.getElementById('sc-name').value, policy: document.getElementById('sc-policy').value, source: document.getElementById('sc-source').value };
    const r = await api('POST', `/mikrotik/scripts/${currentSiteId}/add`, data);
    if (r.success) { toast('Script disimpan'); closeModal('modal-add-script'); loadScripts(); }
    else toast(r.message, 'error');
}

async function runScriptRow(id, name) {
    if (!confirm(`Jalankan script "${name}"?`)) return;
    const r = await api('POST', `/mikrotik/scripts/${currentSiteId}/run`, { '.id': id });
    if (r.success) toast('Script berhasil dieksekusi');
    else toast(r.message, 'error');
}

async function deleteScriptRow(id) {
    if (!confirm('Hapus script ini?')) return;
    const r = await api('DELETE', `/mikrotik/scripts/${currentSiteId}/remove`, { '.id': id });
    if (r.success) { toast('Script dihapus'); loadScripts(); }
    else toast(r.message, 'error');
}

function openAddSchedulerModal() { openModal('modal-add-scheduler'); }
async function saveAddScheduler() {
    const data = { name: document.getElementById('sch-name').value, 'on-event': document.getElementById('sch-event').value, 'start-date': document.getElementById('sch-date').value, 'start-time': document.getElementById('sch-time').value, interval: document.getElementById('sch-interval').value };
    const r = await api('POST', `/mikrotik/scheduler/${currentSiteId}/add`, data);
    if (r.success) { toast('Scheduler ditambahkan'); closeModal('modal-add-scheduler'); loadScripts(); }
    else toast(r.message, 'error');
}

// ============================
// BACKUP & FILES
// ============================
async function loadFiles() {
    const r = await api('GET', `/mikrotik/files/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('files-table-body').innerHTML = r.data.length
        ? r.data.map(f => `<tr><td class="mono">${f.name}</td><td>${badge(f.type||'file','blue')}</td><td class="mono">${f.size?formatBytes(parseInt(f.size)):'--'}</td><td>${f['creation-time']||'--'}</td></tr>`).join('')
        : emptyRow(4);
}

async function createBackup() {
    const name = document.getElementById('backup-filename').value.trim() || 'backup_' + new Date().toISOString().replace(/[:.]/g,'').substring(0,15);
    const r = await api('POST', `/mikrotik/backup/${currentSiteId}`, { name });
    if (r.success) { toast('Backup berhasil dibuat: ' + r.data?.filename); loadFiles(); }
    else toast(r.message, 'error');
}

// ============================
// TOOLS
// ============================
async function runPing() {
    if (!currentSiteId || !isConnected) { toast('Hubungkan ke MikroTik dulu', 'warn'); return; }
    const addr = document.getElementById('ping-addr').value.trim();
    const count = document.getElementById('ping-count').value;
    if (!addr) return;
    document.getElementById('ping-result').textContent = 'Mengirim ping ke ' + addr + '...\n';
    const r = await api('POST', `/mikrotik/tools/${currentSiteId}/ping`, { address: addr, count });
    if (r.success) {
        const lines = r.data.map(p => `Seq ${p.seq}: ${p['response-time']||'timeout'} (TTL ${p.ttl||'?'})`).join('\n');
        document.getElementById('ping-result').textContent = lines || 'Tidak ada response';
    } else {
        document.getElementById('ping-result').textContent = 'Error: ' + r.message;
        document.getElementById('ping-result').style.color = '#fca5a5';
    }
}

async function checkTraffic() {
    if (!currentSiteId || !isConnected) return;
    const iface = document.getElementById('traffic-iface').value.trim();
    if (!iface) return;
    const r = await api('POST', `/mikrotik/tools/${currentSiteId}/traffic`, { interface: iface });
    if (r.success && r.data[0]) {
        document.getElementById('t-rx').textContent = formatBps(parseInt(r.data[0]['rx-bits-per-second']||0));
        document.getElementById('t-tx').textContent = formatBps(parseInt(r.data[0]['tx-bits-per-second']||0));
    }
}

// ============================
// SYSTEM LOG
// ============================
async function loadSystemLog() {
    if (!currentSiteId || !isConnected) return;
    const r = await api('GET', `/mikrotik/system/${currentSiteId}/log`);
    const term = document.getElementById('log-terminal');
    if (!r.success) { term.textContent = 'Error: ' + r.message; return; }
    term.innerHTML = r.data.slice(-100).reverse().map(l => {
        const type = l.topics?.includes('error') ? 'error' : l.topics?.includes('warning') ? 'warning' : 'info';
        return `<div class="log-line"><span class="log-time">${l.time||'--:--:--'}</span><span class="log-topic">[${(l.topics||'info').split(',')[0]}]</span><span class="log-msg ${type}">${l.message||''}</span></div>`;
    }).join('');
}

// ============================
// AUDIT LOG
// ============================
async function loadAuditLog() {
    const r = await api('GET', `/mikrotik/logs/${currentSiteId}`);
    if (!r.success) { toast(r.message, 'error'); return; }
    document.getElementById('audit-log-body').innerHTML = r.data.length
        ? r.data.map(l => `
            <tr>
                <td class="mono" style="font-size:11px;white-space:nowrap">${new Date(l.executed_at).toLocaleString('id')}</td>
                <td>${l.user?.name||'--'}</td>
                <td class="mono" style="font-size:11px">${l.command}</td>
                <td>${l.category?badge(l.category,'blue'):''}</td>
                <td>${l.status==='success'?badge('Success','green'):badge('Failed','red')}</td>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;font-size:11px;color:var(--text-secondary)">${(l.response||'').substring(0,80)}</td>
            </tr>`).join('')
        : emptyRow(6, 'Belum ada riwayat perintah');
}

// ============================
// FORMAT HELPERS
// ============================
function formatBytes(bytes) {
    if (!bytes) return '0 B';
    const k = 1024;
    const sizes = ['B','KB','MB','GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return (bytes / Math.pow(k, i)).toFixed(1) + ' ' + sizes[i];
}

function formatBps(bps) {
    if (!bps) return '0 bps';
    if (bps > 1e9) return (bps/1e9).toFixed(1) + ' Gbps';
    if (bps > 1e6) return (bps/1e6).toFixed(1) + ' Mbps';
    if (bps > 1e3) return (bps/1e3).toFixed(1) + ' Kbps';
    return bps + ' bps';
}
</script>
</body>
</html>
