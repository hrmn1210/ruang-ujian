@extends('layouts.app')

@section('content')
<style>
    /* === EXISTING CSS (unchanged) === */
    :root {
        --color-1: #ff9a8b;
        --color-2: #ff6a88;
        --color-3: #ffb347;
        --text-light: #ffffff;
        --text-dark: #34495e;
        --bg-white: #ffffff;
        --bg-light: #f8f9fa;
        --border-color: #eef2f7;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
    }

    body,
    html {
        background-color: var(--bg-light);
        font-family: 'Poppins', sans-serif;
        /* Anti-select untuk mencegah copy-paste */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        /* Disable text selection */
        -webkit-touch-callout: none;
        -webkit-tap-highlight-color: transparent;
    }

    .container-fluid,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        padding: 0 !important;
        max-width: none !important;
    }

    .exam-wrapper {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 30px;
        padding: 30px;
        align-items: flex-start;
    }

    .status-panel {
        background: linear-gradient(-45deg, var(--color-1), var(--color-2), var(--color-3));
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        color: var(--text-light);
        padding: 30px;
        border-radius: 24px;
        position: sticky;
        top: 30px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(143, 148, 251, 0.2);
    }

    .status-panel h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .status-panel p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin-bottom: 25px;
    }

    #timer {
        font-size: 3.8rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-family: 'Courier New', Courier, monospace;
    }

    #timer.warning-time {
        animation: pulse-timer 1.5s infinite ease-in-out;
        color: var(--warning-color);
    }

    .question-nav {
        margin-top: 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        padding-top: 20px;
    }

    .question-nav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
        gap: 12px;
        max-height: 180px;
        overflow-y: auto;
        padding: 5px;
    }

    .question-nav-item {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.2);
        color: var(--text-light);
        border: 2px solid transparent;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .question-nav-item:hover {
        background-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }

    .question-nav-item.answered {
        background-color: var(--success-color);
        border-color: #fff;
    }

    .question-nav-item.active {
        background-color: #fff;
        color: var(--color-1);
        border-color: var(--color-2);
        transform: scale(1.1);
    }

    .progress-info {
        margin-top: 25px;
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .progress-bar-container {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 50px;
        height: 12px;
        overflow: hidden;
    }

    .progress-bar-fill {
        background: linear-gradient(90deg, #fff, var(--success-color));
        height: 100%;
        width: 0%;
        border-radius: 50px;
        transition: width 0.5s ease;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        margin-top: 30px;
        background: var(--text-light);
        color: var(--color-1);
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .submit-btn:disabled {
        background-color: rgba(255, 255, 255, 0.5);
        color: rgba(255, 255, 255, 0.7);
        cursor: not-allowed;
    }

    .questions-panel {
        background: var(--bg-white);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .question-block {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .question-block.active {
        display: block;
    }

    .question-text {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.2rem;
        line-height: 1.7;
    }

    .options-group {
        margin-top: 25px;
    }

    .question-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid var(--border-color);
    }

    .nav-btn {
        padding: 12px 35px;
        border: 2px solid var(--border-color);
        background-color: #fff;
        color: var(--text-dark);
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .nav-btn:hover:not(:disabled) {
        background-color: var(--color-2);
        color: #fff;
        border-color: var(--color-2);
        transform: translateY(-2px);
    }

    .nav-btn:disabled {
        background-color: #f8f9fa;
        color: #ced4da;
        cursor: not-allowed;
    }

    .custom-option {
        display: block;
        position: relative;
        padding: 15px 20px 15px 60px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        user-select: none;
        color: var(--text-dark);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .custom-option:hover {
        border-color: var(--color-2);
        background-color: #fff8f9;
    }

    input[type="radio"]:checked+.checkmark+span {
        font-weight: 700;
        color: var(--color-2);
    }

    .custom-option input:checked~.checkmark {
        background-color: var(--color-2);
        border-color: var(--color-2);
    }

    .custom-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .custom-option .checkmark {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        height: 28px;
        width: 28px;
        background-color: var(--border-color);
        border: 2px solid var(--border-color);
        border-radius: 50%;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: white;
    }

    .custom-option input:checked~.checkmark:after {
        display: block;
    }

    .mobile-header {
        display: none;
        background: #fff;
        padding: 10px 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1001;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-header .timer-mobile {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Courier New', Courier, monospace;
    }

    .nav-toggle-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }

    .nav-toggle-btn svg {
        width: 28px;
        height: 28px;
        color: var(--text-dark);
    }

    .mobile-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }

    .mobile-overlay.is-visible {
        opacity: 1;
        pointer-events: auto;
    }

    /* === SECURITY WARNING MODAL === */
    .security-warning-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 0, 0, 0.8);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px);
    }

    .security-warning-content {
        background: white;
        color: #dc3545;
        padding: 40px;
        border-radius: 24px;
        text-align: center;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
        animation: shake 0.5s ease-in-out;
        border: 3px solid #dc3545;
    }

    .security-warning-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .security-warning-content p {
        font-size: 1.2rem;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .warning-timer {
        font-size: 3rem;
        font-weight: 700;
        color: #dc3545;
        margin: 20px 0;
        font-family: 'Courier New', Courier, monospace;
    }

    @media (max-width: 992px) {
        body {
            padding-top: 60px;
        }

        .exam-wrapper {
            grid-template-columns: 1fr;
            padding: 0;
            gap: 0;
        }

        .questions-panel {
            border-radius: 0;
            padding: 20px 15px;
            box-shadow: none;
        }

        .mobile-header {
            display: flex;
        }

        .status-panel {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 2000;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            width: 320px;
            border-radius: 0;
        }

        .status-panel.is-open {
            transform: translateX(0);
        }
    }

    .submit-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 5000;
        display: none;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(5px);
    }

    .submit-modal-content {
        background: white;
        color: var(--text-dark);
        padding: 40px;
        border-radius: 24px;
        text-align: center;
        width: 90%;
        max-width: 450px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: zoomIn 0.3s ease-out;
    }

    .submit-modal-content h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .submit-modal-content p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        line-height: 1.6;
        color: #6c757d;
    }

    .submit-modal-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .modal-btn {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn.confirm {
        background-color: var(--success-color);
        color: white;
    }

    .modal-btn.cancel {
        background-color: var(--border-color);
        color: var(--text-dark);
    }

    .modal-btn:hover {
        transform: translateY(-3px);
    }

    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes pulse-timer {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        75% {
            transform: translateX(10px);
        }
    }

    /* Disable right-click context menu */
    * {
        -webkit-context-menu: none;
        -moz-context-menu: none;
        -o-context-menu: none;
        context-menu: none;
    }
</style>

<div class="exam-wrapper" data-attempt-id="{{ $attempt->id }}">
    <aside class="status-panel" id="status-panel">
        <h3>{{ $exam->title }}</h3>
        <p>Mapel: {{ $exam->subject->name ?? 'Umum' }}</p>
        <div id="timer" class="mb-0 fw-bold">Memuat...</div>
        <div class="progress-info">
            <div class="progress-text">
                <span>PROGRESS 🏃‍♂️</span>
                <span id="progress-count">0/{{ $questions->count() }}</span>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" id="progress-bar"></div>
            </div>
        </div>
        <div class="question-nav">
            <div class="question-nav-grid">
                @foreach($questions as $index => $question)
                <div class="question-nav-item" data-index="{{ $index }}">{{ $index + 1 }}</div>
                @endforeach
            </div>
        </div>
        <button type="button" class="submit-btn" disabled>Selesai & Kirim Jawaban</button>
    </aside>

    <main class="questions-panel">
        <form id="exam-form" action="{{ route('student.exam.store', $exam) }}" method="POST">
            @csrf
            @foreach($questions as $index => $question)
            <div class="question-block" data-index="{{ $index }}">
                <div class="question-text">{!! $index + 1 !!}. {!! $question->question_text !!}</div>
                <div class="options-group">
                    @foreach($question->options as $option)
                    <label class="custom-option">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                        <span class="checkmark"></span>
                        <span>{{ $option->option_text }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </form>
        <div class="question-navigation">
            <button id="prev-btn" class="nav-btn">⬅️ Sebelumnya</button>
            <button id="next-btn" class="nav-btn">Berikutnya ➡️</button>
        </div>
    </main>
</div>

<div class="mobile-header">
    <button class="nav-toggle-btn" id="nav-toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-3x3-gap-fill" viewBox="0 0 16 16">
            <path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z" />
        </svg>
    </button>
    <div id="timer-mobile" class="timer-mobile">Memuat...</div>
    <button type="button" class="submit-btn mobile-submit-btn" disabled>Kirim</button>
</div>
<div class="mobile-overlay" id="mobile-overlay"></div>

<div id="submit-modal" class="submit-modal-overlay">
    <div class="submit-modal-content">
        <h2>Kirim Jawaban? 🤔</h2>
        <p>Pastikan semua jawabanmu sudah benar ya. Setelah dikirim, kamu tidak bisa mengubahnya lagi!</p>
        <div class="submit-modal-actions">
            <button id="cancel-submit-btn" class="modal-btn cancel">Batal</button>
            <button id="confirm-submit-btn" class="modal-btn confirm">Ya, Kirim Sekarang!</button>
        </div>
    </div>
</div>

<!-- Security Warning Modal -->
<div id="security-warning-modal" class="security-warning-overlay">
    <div class="security-warning-content">
        <h2>⚠️ PERINGATAN KEAMANAN!</h2>
        <p id="security-message">Terdeteksi aktivitas mencurigakan!</p>
        <div class="warning-timer" id="warning-countdown">10</div>
        <p><strong>Ujian akan otomatis terkirim jika Anda meninggalkan halaman atau melakukan tindakan mencurigakan lagi!</strong></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === SECURITY & ANTI-CHEATING SYSTEM ===
        const securityConfig = {
            maxTabSwitches: 3,
            maxRightClicks: 2,
            maxKeyboardShortcuts: 3,
            warningDuration: 10,
            autoSubmitOnViolation: true
        };

        let securityViolations = {
            tabSwitch: 0,
            rightClick: 0,
            keyboardShortcut: 0,
            totalViolations: 0
        };

        let isExamActive = true;
        let warningTimer = null;

        // Security Warning Modal
        const securityModal = document.getElementById('security-warning-modal');
        const securityMessage = document.getElementById('security-message');
        const warningCountdown = document.getElementById('warning-countdown');

        function logSecurityViolation(type, details = '') {
            if (!isExamActive) return;

            securityViolations[type]++;
            securityViolations.totalViolations++;

            console.warn(`🚨 SECURITY VIOLATION: ${type} - Count: ${securityViolations[type]} - Details: ${details}`);

            // Send to server for logging
            if (typeof sendSecurityLog === 'function') {
                sendSecurityLog(type, securityViolations[type], details);
            }

            // Check if violation limit exceeded
            if (shouldShowWarning(type)) {
                showSecurityWarning(type);
            }
        }

        function shouldShowWarning(type) {
            switch (type) {
                case 'tabSwitch':
                    return securityViolations.tabSwitch >= securityConfig.maxTabSwitches;
                case 'rightClick':
                    return securityViolations.rightClick >= securityConfig.maxRightClicks;
                case 'keyboardShortcut':
                    return securityViolations.keyboardShortcut >= securityConfig.maxKeyboardShortcuts;
                default:
                    return false;
            }
        }

        function showSecurityWarning(violationType) {
            let message = '';
            switch (violationType) {
                case 'tabSwitch':
                    message = 'Anda terlalu sering berpindah tab! Ujian akan otomatis terkirim jika Anda melakukannya lagi.';
                    break;
                case 'rightClick':
                    message = 'Klik kanan terdeteksi! Hal ini tidak diperbolehkan selama ujian.';
                    break;
                case 'keyboardShortcut':
                    message = 'Shortcut keyboard mencurigakan terdeteksi! Ini melanggar aturan ujian.';
                    break;
                default:
                    message = 'Aktivitas mencurigakan terdeteksi!';
            }

            securityMessage.textContent = message;
            securityModal.style.display = 'flex';

            let countdown = securityConfig.warningDuration;
            warningCountdown.textContent = countdown;

            warningTimer = setInterval(() => {
                countdown--;
                warningCountdown.textContent = countdown;

                if (countdown <= 0) {
                    hideSecurityWarning();
                    if (securityConfig.autoSubmitOnViolation && securityViolations.totalViolations >= 5) {
                        forceSubmitExam('Terlalu banyak pelanggaran keamanan');
                    }
                }
            }, 1000);
        }

        function hideSecurityWarning() {
            securityModal.style.display = 'none';
            if (warningTimer) {
                clearInterval(warningTimer);
                warningTimer = null;
            }
        }

        function forceSubmitExam(reason) {
            isExamActive = false;
            alert(`Ujian dihentikan secara otomatis. Alasan: ${reason}`);
            clearLocalStorage();
            examForm.submit();
        }

        // === TAB SWITCH DETECTION ===
        let isTabActive = true;

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                isTabActive = false;
                if (isExamActive) {
                    logSecurityViolation('tabSwitch', 'Tab switched away from exam');
                }
            } else {
                isTabActive = true;
            }

            // Save answers when switching tabs
            if (isExamActive) {
                saveAnswersToLocal();
            }
        });

        // Window focus/blur detection
        window.addEventListener('blur', function() {
            if (isExamActive && isTabActive) {
                logSecurityViolation('tabSwitch', 'Window lost focus');
            }
        });

        // === RIGHT-CLICK PREVENTION ===
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            if (isExamActive) {
                logSecurityViolation('rightClick', 'Right-click attempted');
            }
            return false;
        });

        // === KEYBOARD SHORTCUT PREVENTION ===
        document.addEventListener('keydown', function(e) {
            if (!isExamActive) return;

            // Prevent common cheating shortcuts
            const suspiciousKeys = [{
                    key: 'F12',
                    description: 'Developer Tools'
                },
                {
                    key: 'F5',
                    description: 'Refresh'
                },
                {
                    ctrl: true,
                    key: 'u',
                    description: 'View Source'
                },
                {
                    ctrl: true,
                    key: 'i',
                    description: 'Developer Tools'
                },
                {
                    ctrl: true,
                    key: 'j',
                    description: 'Console'
                },
                {
                    ctrl: true,
                    key: 's',
                    description: 'Save Page'
                },
                {
                    ctrl: true,
                    key: 'a',
                    description: 'Select All'
                },
                {
                    ctrl: true,
                    key: 'c',
                    description: 'Copy'
                },
                {
                    ctrl: true,
                    key: 'v',
                    description: 'Paste'
                },
                {
                    ctrl: true,
                    key: 'x',
                    description: 'Cut'
                },
                {
                    ctrl: true,
                    key: 'r',
                    description: 'Refresh'
                },
                {
                    ctrl: true,
                    shift: true,
                    key: 'i',
                    description: 'Developer Tools'
                },
                {
                    ctrl: true,
                    shift: true,
                    key: 'j',
                    description: 'Console'
                },
                {
                    ctrl: true,
                    shift: true,
                    key: 'c',
                    description: 'Inspector'
                },
                {
                    alt: true,
                    key: 'Tab',
                    description: 'Alt+Tab'
                },
                {
                    key: 'PrintScreen',
                    description: 'Screenshot'
                }
            ];

            for (let shortcut of suspiciousKeys) {
                let isMatch = true;

                if (shortcut.ctrl && !e.ctrlKey) isMatch = false;
                if (shortcut.shift && !e.shiftKey) isMatch = false;
                if (shortcut.alt && !e.altKey) isMatch = false;
                if (shortcut.key && e.key !== shortcut.key) isMatch = false;

                if (isMatch) {
                    e.preventDefault();
                    e.stopPropagation();
                    logSecurityViolation('keyboardShortcut', shortcut.description);
                    return false;
                }
            }

            // Prevent specific key combinations
            if (e.ctrlKey && e.shiftKey && (e.key === 'K' || e.key === 'Delete')) {
                e.preventDefault();
                logSecurityViolation('keyboardShortcut', 'Clear browsing data shortcut');
                return false;
            }
        });

        // === MOUSE SELECTION PREVENTION ===
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
            return false;
        });

        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // === COPY/PASTE PREVENTION ===
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            if (isExamActive) {
                logSecurityViolation('keyboardShortcut', 'Copy attempt detected');
            }
            return false;
        });

        document.addEventListener('paste', function(e) {
            e.preventDefault();
            if (isExamActive) {
                logSecurityViolation('keyboardShortcut', 'Paste attempt detected');
            }
            return false;
        });

        // === FULLSCREEN MONITORING ===
        function enforceFullscreen() {
            if (document.fullscreenElement === null && isExamActive) {
                logSecurityViolation('tabSwitch', 'Exited fullscreen mode');
            }
        }

        document.addEventListener('fullscreenchange', enforceFullscreen);
        document.addEventListener('webkitfullscreenchange', enforceFullscreen);
        document.addEventListener('mozfullscreenchange', enforceFullscreen);

        // === NETWORK CONNECTIVITY MONITORING ===
        window.addEventListener('online', function() {
            console.log('🌐 Network connection restored');
        });

        window.addEventListener('offline', function() {
            console.warn('🌐 Network connection lost - answers saved locally');
            saveAnswersToLocal();
        });

        // === INACTIVITY DETECTION ===
        let inactivityTimer;
        let lastActivity = Date.now();
        const maxInactivity = 5 * 60 * 1000; // 5 minutes

        function resetInactivityTimer() {
            lastActivity = Date.now();
            clearTimeout(inactivityTimer);

            inactivityTimer = setTimeout(() => {
                if (isExamActive) {
                    const inactive = Date.now() - lastActivity;
                    if (inactive >= maxInactivity) {
                        console.warn('⏰ User inactive for too long');
                        // Could implement auto-save or warning here
                        saveAnswersToLocal();
                    }
                }
            }, maxInactivity);
        }

        // Track user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer, true);
        });

        // === BROWSER BACK/FORWARD PREVENTION ===
        window.addEventListener('beforeunload', function(event) {
            if (isExamActive) {
                const message = 'Anda yakin ingin meninggalkan ujian? Jawaban yang belum tersimpan akan hilang.';
                event.preventDefault();
                event.returnValue = message;

                // Log attempt to leave
                logSecurityViolation('tabSwitch', 'Attempted to leave exam page');
                saveAnswersToLocal();
                return message;
            }
        });

        // Prevent back button
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function(event) {
            if (isExamActive) {
                history.pushState(null, null, location.href);
                logSecurityViolation('tabSwitch', 'Back button pressed');
            }
        });

        // === EXISTING CODE (unchanged) ===
        const examWrapper = document.querySelector('.exam-wrapper');
        const attemptId = examWrapper.dataset.attemptId;
        const storageKey = `exam_answers_${attemptId}`;
        const positionKey = `exam_position_${attemptId}`;
        const examForm = document.getElementById('exam-form');
        const questionBlocks = document.querySelectorAll('.question-block');
        const totalQuestions = questionBlocks.length;
        const navItems = document.querySelectorAll('.question-nav-item');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtns = document.querySelectorAll('.submit-btn');
        const progressCount = document.getElementById('progress-count');
        const progressBar = document.getElementById('progress-bar');
        const timerDisplay = document.getElementById('timer');
        const timerMobileDisplay = document.getElementById('timer-mobile');
        const submitModal = document.getElementById('submit-modal');
        const confirmSubmitBtn = document.getElementById('confirm-submit-btn');
        const cancelSubmitBtn = document.getElementById('cancel-submit-btn');
        let currentQuestionIndex = 0;
        const statusPanel = document.getElementById('status-panel');
        const navToggleBtn = document.getElementById('nav-toggle-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');

        // === ENHANCED AUTOSAVE WITH SECURITY ===
        function saveAnswersToLocal() {
            try {
                const answers = {};
                document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                    answers[radio.name] = radio.value;
                });

                // Add security metadata
                const secureData = {
                    answers: answers,
                    position: currentQuestionIndex,
                    timestamp: Date.now(),
                    securityViolations: securityViolations,
                    userAgent: navigator.userAgent,
                    sessionId: attemptId
                };

                localStorage.setItem(storageKey, JSON.stringify(secureData));
                localStorage.setItem(positionKey, currentQuestionIndex.toString());

                console.log('💾 Answers saved securely:', answers);
            } catch (error) {
                console.warn('❌ Failed to save answers:', error);
                // Try to save to server as backup
                if (typeof saveToServer === 'function') {
                    saveToServer(answers);
                }
            }
        }

        function loadAnswersFromLocal() {
            try {
                const savedData = localStorage.getItem(storageKey);
                if (savedData) {
                    const secureData = JSON.parse(savedData);

                    // Validate data integrity
                    if (secureData.sessionId !== attemptId) {
                        console.warn('⚠️ Session ID mismatch - clearing local data');
                        clearLocalStorage();
                        return;
                    }

                    const answers = secureData.answers || {};
                    Object.entries(answers).forEach(([questionName, optionValue]) => {
                        const radio = document.querySelector(`input[name="${questionName}"][value="${optionValue}"]`);
                        if (radio) {
                            radio.checked = true;
                        }
                    });

                    // Restore security violations count
                    if (secureData.securityViolations) {
                        securityViolations = {
                            ...securityViolations,
                            ...secureData.securityViolations
                        };
                    }

                    console.log('📂 Secure data loaded successfully');
                }

                const savedPosition = localStorage.getItem(positionKey);
                if (savedPosition) {
                    const position = parseInt(savedPosition);
                    if (position >= 0 && position < totalQuestions) {
                        currentQuestionIndex = position;
                    }
                }
            } catch (error) {
                console.warn('❌ Failed to load saved data:', error);
                clearLocalStorage();
            }
        }

        function clearLocalStorage() {
            try {
                localStorage.removeItem(storageKey);
                localStorage.removeItem(positionKey);
                console.log('🧹 Local storage cleared');
            } catch (error) {
                console.warn('❌ Failed to clear local storage:', error);
            }
        }

        // === ENHANCED FUNCTIONS ===
        function showQuestion(index) {
            questionBlocks.forEach((block, i) => block.classList.toggle('active', i === index));
            navItems.forEach((item) => {
                item.classList.toggle('active', parseInt(item.dataset.index) === index);
            });
            updateNavButtons();
            saveAnswersToLocal();
        }

        function updateNavButtons() {
            prevBtn.disabled = currentQuestionIndex === 0;
            const isCurrentQuestionAnswered = questionBlocks[currentQuestionIndex]?.querySelector('input[type="radio"]:checked');
            nextBtn.disabled = currentQuestionIndex === totalQuestions - 1 || !isCurrentQuestionAnswered;
        }

        function updateProgress() {
            const answeredQuestionNames = new Set();
            document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                answeredQuestionNames.add(radio.name);
            });
            const answeredCount = answeredQuestionNames.size;
            if (progressCount) progressCount.textContent = `${answeredCount}/${totalQuestions}`;
            if (progressBar) progressBar.style.width = `${totalQuestions > 0 ? (answeredCount / totalQuestions) * 100 : 0}%`;
            navItems.forEach(item => {
                const isAnswered = questionBlocks[parseInt(item.dataset.index)]?.querySelector('input[type="radio"]:checked');
                item.classList.toggle('answered', !!isAnswered);
            });
            submitBtns.forEach(btn => btn.disabled = answeredCount !== totalQuestions);
        }

        function toggleSidebar() {
            statusPanel.classList.toggle('is-open');
            mobileOverlay.classList.toggle('is-visible');
        }

        // === ENHANCED TIMER WITH SECURITY ===
        const finishTime = new Date('{{ $finishTime ?? now()->addMinutes($exam->duration) }}').getTime();
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = finishTime - now;
            if (distance > 0) {
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                const timeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                if (timerDisplay) timerDisplay.textContent = timeString;
                if (timerMobileDisplay) timerMobileDisplay.textContent = timeString;
                if (distance < 300000) { // 5 minutes warning
                    if (timerDisplay) timerDisplay.classList.add('warning-time');
                    if (timerMobileDisplay) timerMobileDisplay.style.color = 'var(--warning-color)';
                }
            } else {
                clearInterval(interval);
                if (timerDisplay) timerDisplay.textContent = 'Waktu Habis!';
                if (timerMobileDisplay) timerMobileDisplay.textContent = 'Waktu Habis!';
                forceSubmitExam('Waktu pengerjaan habis');
            }
        }, 1000);

        // === ENHANCED AUTO-SAVE ===
        setInterval(() => {
            if (isExamActive) {
                saveAnswersToLocal();
            }
        }, 15000); // More frequent saves for security

        // === ENHANCED EVENT LISTENERS ===
        nextBtn.addEventListener('click', () => {
            if (currentQuestionIndex < totalQuestions - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
            }
        });

        navItems.forEach(item => {
            item.addEventListener('click', () => {
                currentQuestionIndex = parseInt(item.dataset.index);
                showQuestion(currentQuestionIndex);
                if (window.innerWidth <= 992 && statusPanel.classList.contains('is-open')) {
                    toggleSidebar();
                }
            });
        });

        examForm.addEventListener('change', (event) => {
            if (event.target.type === 'radio') {
                updateProgress();
                updateNavButtons();
                saveAnswersToLocal();
            }
        });

        submitBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                submitModal.style.display = 'flex';
            });
        });

        cancelSubmitBtn.addEventListener('click', () => {
            submitModal.style.display = 'none';
        });

        confirmSubmitBtn.addEventListener('click', () => {
            isExamActive = false;
            clearLocalStorage();
            examForm.submit();
        });

        navToggleBtn.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', toggleSidebar);

        // Security warning modal close on click outside
        securityModal.addEventListener('click', (e) => {
            if (e.target === securityModal) {
                hideSecurityWarning();
            }
        });

        // === INITIALIZATION ===
        loadAnswersFromLocal();
        showQuestion(currentQuestionIndex);
        updateProgress();
        resetInactivityTimer();

        console.log('🔒 Secure Exam System Initialized');
        console.log('📊 Security Config:', securityConfig);
        console.log('🆔 Attempt ID:', attemptId);

        // === DEBUGGING & MONITORING (Production should remove these) ===
        window.examSecurity = {
            violations: securityViolations,
            config: securityConfig,
            isActive: () => isExamActive,
            forceSubmit: (reason) => forceSubmitExam(reason),
            clearData: clearLocalStorage,
            showWarning: (type) => showSecurityWarning(type)
        };

        // === SERVER COMMUNICATION (Optional - implement based on your backend) ===
        function sendSecurityLog(type, count, details) {
            // Implement AJAX call to log security violations to server
            fetch('/api/exam/security-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    attempt_id: attemptId,
                    violation_type: type,
                    violation_count: count,
                    details: details,
                    timestamp: new Date().toISOString(),
                    user_agent: navigator.userAgent
                })
            }).catch(error => {
                console.warn('Failed to send security log:', error);
            });
        }

        function saveToServer(answers) {
            // Implement AJAX call to save answers to server as backup
            fetch('/api/exam/auto-save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    attempt_id: attemptId,
                    answers: answers,
                    timestamp: new Date().toISOString()
                })
            }).catch(error => {
                console.warn('Failed to save to server:', error);
            });
        }

        // === HEARTBEAT (Optional - to detect if student is still active) ===
        setInterval(() => {
            if (isExamActive) {
                fetch('/api/exam/heartbeat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify({
                        attempt_id: attemptId,
                        timestamp: new Date().toISOString(),
                        violations: securityViolations
                    })
                }).catch(error => {
                    console.warn('Heartbeat failed:', error);
                });
            }
        }, 60000); // Every minute
    });
</script>
@endsection