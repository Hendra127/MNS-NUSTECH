<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTECH | Login Access</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            background-color: #1e2b4b;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
            position: relative;
        }

        /* =============================================
           LEFT SECTION
        ============================================= */
        .left-section {
            flex: 1.25;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 10;
            clip-path: ellipse(90% 120% at 10% 50%);
            box-shadow: 10px 0 40px rgba(0,0,0,0.12);
        }

        @media (max-width: 768px) {
            .left-section { display: none; }
            .right-section { flex: 1; clip-path: none; }
        }

        .logo-container {
            text-align: center;
            animation: fadeInScale 1s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* =============================================
           CSS N-LOGO
        ============================================= */
        .n-logo-wrap {
            width: 160px;
            height: 160px;
            margin: 0 auto 24px;
            position: relative;
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
        }

        .logo-text-area { font-family: 'Outfit', sans-serif; }

        .logo-subtext {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e2b4b;
            letter-spacing: 5px;
            margin-top: -4px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            opacity: 0.6;
        }

        .logo-subtext::before {
            content: '';
            height: 2px;
            background: #1e2b4b;
            flex: 1;
            margin-right: 12px;
            opacity: 0.4;
        }

        .left-tagline {
            margin-top: 20px;
            font-size: 0.95rem;
            color: #5a6a82;
            font-weight: 500;
        }

        /* =============================================
           RIGHT SECTION
        ============================================= */
        .right-section {
            flex: 1;
            background-color: #1e2b4b;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
        }

        .particles-overlay {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }

        /* =============================================
           CSS ROBOT CHARACTER
        ============================================= */
        .robot-wrap {
            position: absolute;
            top: 14px;
            right: 20px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: robotFloat 3.5s ease-in-out infinite;
            cursor: default;
        }

        @keyframes robotFloat {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-7px); }
        }

        /* Antenna */
        .robot-antenna {
            width: 3px;
            height: 14px;
            background: linear-gradient(to top, #7986cb, #c5cae9);
            border-radius: 2px;
            margin-bottom: 0;
            position: relative;
        }

        .robot-antenna::after {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px; height: 8px;
            background: #ff8a65;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255,138,101,0.9);
            animation: antennaBlink 1.2s ease-in-out infinite;
        }

        @keyframes antennaBlink {
            0%, 100% { opacity: 1; box-shadow: 0 0 8px rgba(255,138,101,0.9); }
            50%       { opacity: 0.3; box-shadow: none; }
        }

        /* Head */
        .robot-head {
            width: 70px;
            height: 58px;
            background: linear-gradient(160deg, #37474f 0%, #263238 100%);
            border-radius: 14px;
            position: relative;
            box-shadow:
                0 4px 16px rgba(0,0,0,0.4),
                inset 0 1px 2px rgba(255,255,255,0.1),
                inset 0 -2px 4px rgba(0,0,0,0.3);
            border: 2px solid #455a64;
        }

        /* Visor / face plate */
        .robot-visor {
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            height: 28px;
            background: linear-gradient(135deg, #0d47a1 0%, #1565c0 50%, #0d47a1 100%);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.5), 0 0 12px rgba(21,101,192,0.4);
        }

        /* Scan line inside visor */
        .robot-visor::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background: rgba(100,181,246,0.6);
            top: 0;
            left: 0;
            animation: visorScan 2s linear infinite;
        }

        @keyframes visorScan {
            0%   { top: 0; opacity: 0.8; }
            80%  { top: calc(100% - 3px); opacity: 0.8; }
            100% { top: calc(100% - 3px); opacity: 0; }
        }

        /* Eyes inside visor */
        .robot-eyes {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            gap: 14px;
            z-index: 2;
        }

        .robot-eye {
            width: 14px;
            height: 14px;
            background: #64b5f6;
            border-radius: 50%;
            box-shadow: 0 0 10px #64b5f6, 0 0 4px #fff;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        /* Pupil dot */
        .robot-eye::before {
            content: '';
            position: absolute;
            width: 6px; height: 6px;
            background: #0d47a1;
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }

        /* Closed eye state — horizontal line */
        .robot-eye.closed {
            height: 3px;
            border-radius: 3px;
            background: #546e7a;
            box-shadow: none;
        }

        .robot-eye.closed::before { display: none; }

        /* Guard plate over eyes (when covering) */
        .robot-eye-guard {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #263238, #37474f);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: 3;
        }

        .robot-eye-guard.active { opacity: 1; }

        .robot-eye-guard::after {
            content: '//';
            color: #546e7a;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            font-family: monospace;
        }

        /* Mouth / speaker grille */
        .robot-mouth {
            position: absolute;
            bottom: 7px;
            left: 50%;
            transform: translateX(-50%);
            width: 34px;
            height: 8px;
            display: flex;
            gap: 3px;
            align-items: center;
            justify-content: center;
        }

        .mouth-bar {
            width: 3px;
            height: 100%;
            background: #546e7a;
            border-radius: 2px;
            transition: height 0.2s ease;
        }

        /* Animated mouth (talking) */
        .mouth-bar:nth-child(1) { animation: mouthWave 0.8s ease-in-out infinite 0.0s; }
        .mouth-bar:nth-child(2) { animation: mouthWave 0.8s ease-in-out infinite 0.1s; }
        .mouth-bar:nth-child(3) { animation: mouthWave 0.8s ease-in-out infinite 0.2s; }
        .mouth-bar:nth-child(4) { animation: mouthWave 0.8s ease-in-out infinite 0.3s; }
        .mouth-bar:nth-child(5) { animation: mouthWave 0.8s ease-in-out infinite 0.4s; }
        .mouth-bar:nth-child(6) { animation: mouthWave 0.8s ease-in-out infinite 0.1s; }
        .mouth-bar:nth-child(7) { animation: mouthWave 0.8s ease-in-out infinite 0.0s; }

        @keyframes mouthWave {
            0%, 100% { height: 4px; }
            50%       { height: 8px; }
        }

        /* Ear panels */
        .robot-ear {
            position: absolute;
            top: 12px;
            width: 8px;
            height: 20px;
            background: linear-gradient(160deg, #455a64, #37474f);
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(255,255,255,0.08);
        }

        .robot-ear.left  { left: -10px; }
        .robot-ear.right { right: -10px; }

        /* Tiny led on ear */
        .robot-ear::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px; height: 4px;
            background: #26c6da;
            border-radius: 50%;
            box-shadow: 0 0 6px #26c6da;
            animation: earLed 2.5s ease-in-out infinite;
        }

        .robot-ear.right::after { animation-delay: 0.5s; }

        @keyframes earLed {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.2; }
        }

        /* Neck */
        .robot-neck {
            width: 24px; height: 8px;
            background: linear-gradient(to bottom, #455a64, #37474f);
            margin: 0 auto;
            border-radius: 0 0 4px 4px;
        }

        /* Body */
        .robot-body {
            width: 78px;
            height: 52px;
            background: linear-gradient(160deg, #37474f 0%, #263238 100%);
            border-radius: 10px;
            position: relative;
            box-shadow: 0 6px 20px rgba(0,0,0,0.35), inset 0 1px 2px rgba(255,255,255,0.07);
            border: 2px solid #455a64;
            overflow: hidden;
        }

        /* Chest panel */
        .robot-chest {
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 20px;
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.4);
        }

        .chest-led {
            width: 6px; height: 6px;
            border-radius: 50%;
        }

        .chest-led:nth-child(1) { background: #ff5252; box-shadow: 0 0 6px #ff5252; animation: chestBlink 1.5s ease-in-out infinite 0s; }
        .chest-led:nth-child(2) { background: #ffeb3b; box-shadow: 0 0 6px #ffeb3b; animation: chestBlink 1.5s ease-in-out infinite 0.5s; }
        .chest-led:nth-child(3) { background: #69f0ae; box-shadow: 0 0 6px #69f0ae; animation: chestBlink 1.5s ease-in-out infinite 1.0s; }

        @keyframes chestBlink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.2; }
        }

        /* Shoulder bolts */
        .robot-bolt {
            position: absolute;
            top: 4px;
            width: 8px; height: 8px;
            background: #546e7a;
            border-radius: 50%;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.4);
        }

        .robot-bolt.left  { left: 4px; }
        .robot-bolt.right { right: 4px; }

        /* Status label */
        .robot-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 5px;
            font-family: monospace;
        }

        /* =============================================
           FORM
        ============================================= */
        .form-container {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 10;
            animation: slideInRight 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .form-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
            margin-bottom: 36px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.82rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.55);
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            background-color: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 14px;
            display: flex;
            align-items: center;
            padding: 4px 6px;
            margin-bottom: 22px;
            transition: all 0.35s ease;
        }

        .input-group:focus-within {
            border-color: rgba(255,255,255,0.55);
            background-color: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.06);
        }

        .icon-circle {
            width: 44px; height: 44px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e2b4b;
            font-size: 1.1rem;
            margin-right: 12px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .eye-toggle {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 8px 10px;
            transition: color 0.3s;
            flex-shrink: 0;
        }

        .eye-toggle:hover { color: rgba(255,255,255,0.9); }

        .cyber-input {
            background: transparent;
            border: none;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
            padding: 12px 6px;
            outline: none;
        }

        .cyber-input::placeholder { color: rgba(255,255,255,0.3); }

        /* Remember Me */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            font-weight: 500;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            user-select: none;
        }

        .remember-me input { display: none; }

        .checkmark {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .remember-me input:checked + .checkmark {
            background: white;
            border-color: white;
        }

        .remember-me input:checked + .checkmark::after {
            content: '';
            width: 5px; height: 9px;
            border: 2px solid #1e2b4b;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
            display: block;
        }

        /* Login Button */
        .btn-login {
            background-color: white;
            color: #1e2b4b;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 15px 40px;
            border-radius: 12px;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.35) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 14px 30px rgba(0,0,0,0.3); }
        .btn-login:hover::after { transform: translateX(100%); }
        .btn-login:active { transform: translateY(1px); }

        /* Error */
        .error-alert {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.35);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 22px;
            color: #fca5a5;
            font-size: 0.875rem;
        }

        .shake-horizontal { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px,0,0); }
            20%, 80% { transform: translate3d(2px,0,0); }
            30%, 50%, 70% { transform: translate3d(-4px,0,0); }
            40%, 60% { transform: translate3d(4px,0,0); }
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        <!-- ==================== LEFT SECTION ==================== -->
        <div class="left-section">
            <div class="logo-container">

                <!-- NUSTECH LOGO -->
                <div class="n-logo-wrap">
                    <img src="{{ asset('assets/img/logonustech.png') }}" alt="NUSTECH Logo" class="w-full h-full object-contain">
                </div>

                <div class="logo-text-area" style="margin-top: -10px;">
                    <div class="logo-subtext">MAINFRAME</div>
                </div>

                <p class="left-tagline">Secure · Reliable · Operational</p>
            </div>
        </div>

        <!-- ==================== RIGHT SECTION ==================== -->
        <div class="right-section">
            <div class="particles-overlay"></div>

            <!-- ===== ROBOT CHARACTER ===== -->
            <div class="robot-wrap" id="robotWrap">
                <!-- Antenna -->
                <div class="robot-antenna"></div>

                <!-- Head -->
                <div class="robot-head">
                    <!-- Ears -->
                    <div class="robot-ear left"></div>
                    <div class="robot-ear right"></div>

                    <!-- Visor with eyes -->
                    <div class="robot-visor" id="robotVisor">
                        <div class="robot-eyes">
                            <div class="robot-eye" id="robotEyeLeft"></div>
                            <div class="robot-eye" id="robotEyeRight"></div>
                        </div>
                        <!-- Guard plate (privacy shield) -->
                        <div class="robot-eye-guard" id="eyeGuard"></div>
                    </div>

                    <!-- Speaker mouth -->
                    <div class="robot-mouth">
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                        <div class="mouth-bar"></div>
                    </div>
                </div>

                <!-- Neck -->
                <div class="robot-neck"></div>

                <!-- Body -->
                <div class="robot-body">
                    <div class="robot-bolt left"></div>
                    <div class="robot-bolt right"></div>
                    <div class="robot-chest">
                        <div class="chest-led"></div>
                        <div class="chest-led"></div>
                        <div class="chest-led"></div>
                    </div>
                </div>

                <div class="robot-label" id="robotLabel">SYS: ACTIVE</div>
            </div>

            <!-- ===== FORM ===== -->
            <div class="form-container">
                <p class="form-title">Welcome Back</p>
                <p class="form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

                @if ($errors->any() || session('error'))
                    <div class="error-alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() ?: session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST"
                      class="@if($errors->any()) shake-horizontal @endif"
                      id="loginForm">
                    @csrf

                    <!-- Username / Email -->
                    <div class="group">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <div class="icon-circle" id="userIcon">
                                <i class="fas fa-user" id="userIconInner"></i>
                            </div>
                            <input type="email" name="email"
                                id="usernameInput"
                                class="cyber-input"
                                placeholder="email@example.com"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <div class="icon-circle" id="lockIcon">
                                <i class="fas fa-lock" id="lockIconInner"></i>
                            </div>
                            <input type="password" name="password"
                                id="passwordInput"
                                class="cyber-input"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                required>
                            <button type="button" class="eye-toggle" id="eyeToggleBtn"
                                    title="Tampilkan / Sembunyikan Password">
                                <i class="fas fa-eye-slash" id="eyeIconEl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="rememberMe">
                        <span class="checkmark"></span>
                        Remember Me
                    </label>

                    <!-- Submit -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---- DOM ---- */
        const usernameInput = document.getElementById('usernameInput');
        const passwordInput = document.getElementById('passwordInput');
        const userIcon      = document.getElementById('userIcon');
        const lockIcon      = document.getElementById('lockIcon');
        const eyeToggleBtn  = document.getElementById('eyeToggleBtn');
        const eyeIconEl     = document.getElementById('eyeIconEl');
        const rememberMe    = document.getElementById('rememberMe');

        // Robot refs
        const robotEyeLeft  = document.getElementById('robotEyeLeft');
        const robotEyeRight = document.getElementById('robotEyeRight');
        const eyeGuard      = document.getElementById('eyeGuard');
        const robotLabel    = document.getElementById('robotLabel');

        /* =============================================
           REMEMBER ME — restore saved email from cookie
        ============================================= */
        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
            return match ? decodeURIComponent(match[1]) : null;
        }

        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
            document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
        }

        function deleteCookie(name) {
            document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
        }

        // Restore saved email on page load
        const savedEmail = getCookie('remember_email');
        if (savedEmail && !usernameInput.value) {
            usernameInput.value = savedEmail;
            rememberMe.checked  = true;
        }

        // Save / clear on form submit
        document.getElementById('loginForm').addEventListener('submit', () => {
            if (rememberMe.checked && usernameInput.value) {
                setCookie('remember_email', usernameInput.value, 30); // 30 days
            } else {
                deleteCookie('remember_email');
            }
        });

        /* =============================================
           ROBOT — eye shield logic
        ============================================= */
        function shieldEyes() {
            robotEyeLeft.classList.add('closed');
            robotEyeRight.classList.add('closed');
            eyeGuard.classList.add('active');
            robotLabel.textContent = 'PWD: ENCRYPTED';
        }

        function unShieldEyes() {
            robotEyeLeft.classList.remove('closed');
            robotEyeRight.classList.remove('closed');
            eyeGuard.classList.remove('active');
            robotLabel.textContent = 'SYS: ACTIVE';
        }

        passwordInput.addEventListener('focus', shieldEyes);

        passwordInput.addEventListener('input', () => {
            if (passwordInput.value.length > 0) {
                shieldEyes();
            } else {
                unShieldEyes();
            }
        });

        passwordInput.addEventListener('blur', () => {
            if (passwordInput.value.length === 0) unShieldEyes();
        });

        /* =============================================
           EYE TOGGLE
        ============================================= */
        let isVisible = false;

        eyeToggleBtn.addEventListener('click', () => {
            isVisible = !isVisible;
            if (isVisible) {
                passwordInput.type = 'text';
                eyeIconEl.classList.replace('fa-eye-slash', 'fa-eye');
                // Robot briefly looks
                eyeGuard.classList.remove('active');
                robotEyeLeft.classList.remove('closed');
                robotEyeRight.classList.remove('closed');
                robotLabel.textContent = 'SCAN: READING';
                setTimeout(() => {
                    if (isVisible) { shieldEyes(); robotLabel.textContent = 'DATA: SECURED'; }
                }, 700);
            } else {
                passwordInput.type = 'password';
                eyeIconEl.classList.replace('fa-eye', 'fa-eye-slash');
                if (passwordInput.value.length > 0) shieldEyes();
            }
        });

        /* =============================================
           ICON CIRCLE ANIMATIONS
        ============================================= */
        function triggerBlink(el) {
            el.classList.remove('eye-blink', 'eye-open-anim');
            void el.offsetWidth;
            el.classList.add('eye-blink');
            el.addEventListener('animationend', () => el.classList.remove('eye-blink'), { once: true });
        }

        userIcon.addEventListener('mouseenter', () => {
            userIcon.style.transform = 'scale(1.1) rotate(5deg)';
        });
        userIcon.addEventListener('mouseleave', () => {
            userIcon.style.transform = '';
        });

        usernameInput.addEventListener('focus', () => {
            userIcon.style.transform = 'scale(1.08) rotate(5deg)';
            userIcon.style.boxShadow = '0 4px 16px rgba(255,255,255,0.3)';
        });
        usernameInput.addEventListener('blur', () => {
            userIcon.style.transform = '';
            userIcon.style.boxShadow = '';
        });

        passwordInput.addEventListener('focus', () => {
            lockIcon.style.transform = 'scale(1.08) rotate(-5deg)';
            lockIcon.style.boxShadow = '0 4px 16px rgba(255,255,255,0.3)';
        });
        passwordInput.addEventListener('blur', () => {
            lockIcon.style.transform = '';
            lockIcon.style.boxShadow = '';
        });

        /* Robot idle eye-blink */
        setInterval(() => {
            if (!robotEyeLeft.classList.contains('closed') && !eyeGuard.classList.contains('active')) {
                robotEyeLeft.style.transition  = 'height 0.07s';
                robotEyeRight.style.transition = 'height 0.07s';
                robotEyeLeft.style.height  = '2px';
                robotEyeRight.style.height = '2px';
                setTimeout(() => {
                    robotEyeLeft.style.height  = '';
                    robotEyeRight.style.height = '';
                    robotEyeLeft.style.transition  = '';
                    robotEyeRight.style.transition = '';
                }, 110);
            }
        }, 4000);
    });
    </script>
</body>
</html>
