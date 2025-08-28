@extends('layouts.app')

@section('content')

<style>
    :root {
        --color-1: #ff9a8b;
        --color-2: #ff6a88;
        --color-3: #ffb347;
        --text-light: #ffffff;
        --success-color: #d4ffea;
        --danger-color: #ffdddd;
        --info-color: #d1e7ff;
        --secondary-color: rgba(255, 255, 255, 0.5);
    }

    body {
        background: linear-gradient(-45deg, var(--color-1), var(--color-2), var(--color-3));
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        color: var(--text-light);
    }

    #app {
        background: none;
    }

    .dashboard-hero {
        padding: 40px;
        text-align: center;
    }

    .hero-panel {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 40px;
        border-radius: 25px;
        display: inline-block;
        /* Menghilangkan transisi untuk 3D */
    }

    /* Gaya untuk Animasi Teks "Wave on Hover" */
    .hero-panel h3 {
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .hero-panel h3 span {
        display: inline-block;
        transition: transform 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0), color 0.3s;
        cursor: default;
    }

    .hero-panel h3 span:hover {
        transform: translateY(-15px);
        color: var(--color-3);
    }

    .hero-panel p {
        opacity: 0.9;
        font-size: 1.1rem;
        margin-top: 10px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .exam-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(50px);
    }

    .features.is-visible .exam-card {
        opacity: 1;
        transform: translateY(0);
    }

    @for ($i =1; $i <=10; $i++) .exam-card:nth-child({
            {
            $i
        }

    }) {
        transition-delay: {
                {
                0.1+($i * 0.05)
            }
        }

        s;
    }

    @endfor .exam-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .exam-card .card-body {
        padding: 25px;
        color: var(--text-light);
    }

    .exam-card .card-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 20px;
    }

    .exam-info {
        list-style: none;
        padding: 0;
        margin-bottom: 25px;
    }

    .exam-info li {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .exam-info svg {
        margin-right: 12px;
        width: 20px;
        height: 20px;
    }

    .status-btn {
        width: 100%;
        padding: 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.2);
        color: var(--text-light);
    }

    .status-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .status-btn.download {
        border-color: var(--info-color);
        color: var(--info-color);
    }

    .status-btn.download:hover {
        background: var(--info-color);
        color: var(--text-dark);
    }

    .status-btn.completed {
        border-color: var(--success-color);
        color: var(--success-color);
    }

    .status-btn.missed {
        border-color: var(--danger-color);
        color: var(--danger-color);
    }

    .status-btn.locked {
        color: var(--secondary-color);
        border-color: var(--secondary-color);
        cursor: not-allowed;
        opacity: 0.7;
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

    /* === MOOD BOOSTER: DI DALAM CARD, ANTARA DURASI DAN TOMBOL === */
    .mood-booster {
        /* Tetap dalam flow layout */
        margin: 15px auto;
        padding: 10px 16px;
        max-width: 90%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-size: 0.95rem;
        font-weight: 500;
        text-align: center;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s cubic-bezier(0.25, 0.1, 0.25, 1);
        pointer-events: none;

        /* Sembunyikan secara default */
        display: block;
    }

    /* Muncul saat hover */
    .exam-card:hover .mood-booster {
        opacity: 1;
        transform: translateY(0);
    }

    .mood-booster::before {
        content: '💡';
        margin-right: 8px;
    }
</style>

<div class="container py-5">
    <div class="dashboard-hero">
        <div class="hero-panel">
            <h3 id="animated-heading">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p>Ujian hari ini sudah menantimu. Tunjukkan kemampuan terbaikmu!</p>
        </div>
    </div>

    @if(session('success')) <div class="alert alert-success" style="background: rgba(212, 255, 234, 0.9); color: #0f5132; border-color: rgba(15, 81, 50, 0.3);">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger" style="background: rgba(255, 221, 221, 0.9); color: #842029; border-color: rgba(132, 32, 41, 0.3);">{{ session('error') }}</div> @endif

    @if($exams->isNotEmpty())
    <section class="features">
        <h2 class="section-title">Ujian Hari Ini</h2>
        <div class="row">
            @foreach($exams as $exam)
            @php
            $now = now();
            $startTime = \Carbon\Carbon::parse($exam->start_time);
            $endTime = \Carbon\Carbon::parse($exam->end_time);
            $attempt = $exam->examAttempts->first();
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card exam-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $exam->title }}</h5>
                        <ul class="exam-info">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
                                    <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                </svg>
                                {{ $exam->subject->name }}
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                </svg>
                                Jadwal: {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }} WIB
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                </svg>
                                Durasi: {{ $exam->duration }} menit
                            </li>
                        </ul>
                        <div class="mood-booster">Kamu pasti bisa! 💪</div>

                        <div class="mt-auto">
                            @if($attempt && $attempt->finished_by_violation)
                            {{-- Status baru jika selesai karena pelanggaran --}}
                            <button class="btn status-btn missed" disabled>Ujian Dihentikan (Pelanggaran)</button>

                            @elseif($attempt && $attempt->finished_at)
                            {{-- Jika sudah selesai normal --}}
                            <a href="{{ route('student.exam.proof', $attempt) }}" class="btn status-btn download" target="_blank">Download Bukti</a>

                            @elseif($now->lt($startTime))
                            {{-- Jika belum dimulai --}}
                            <button class="btn status-btn locked" disabled>Ujian Belum Dimulai</button>

                            @elseif($now->gt($endTime))
                            {{-- Jika sudah terlewat --}}
                            <button class="btn status-btn missed" disabled>Ujian Terlewat</button>

                            @else
                            {{-- Jika bisa dikerjakan --}}
                            <a href="{{ route('student.exam.show', $exam) }}" class="btn status-btn">Mulai Ujian</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @else
    <div class="alert alert-info text-center" style="background: rgba(209, 231, 255, 0.9); color: #0c5460; border: none;">
        Tidak ada ujian yang dijadwalkan untuk Anda hari ini.
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi Teks "Wave on Hover" untuk Dashboard
        const animatedHeading = document.getElementById('animated-heading');
        if (animatedHeading) {
            const text = animatedHeading.textContent;
            const wrappedText = text.split('').map(char => `<span>${char === ' ' ? '&nbsp;' : char}</span>`).join('');
            animatedHeading.innerHTML = wrappedText;
        }

        // Animasi saat Scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, {
            threshold: 0.1
        });

        const elementsToAnimate = document.querySelectorAll('.features');
        elementsToAnimate.forEach(el => {
            observer.observe(el);
        });
    });

    // === MOOD BOOSTER: GANTI PESAN ACAK SAAT HOVER DI DALAM CARD ===
    const motivationalMessages = [
        "Kamu pasti bisa! 💪",
        "Fokus dan tenang, hasil akan mengikuti 🌟",
        "Ini saatnya menunjukkan kemampuanmu! 🚀",
        "Percaya diri, kamu lebih siap dari yang kamu kira 😊",
        "Setiap soal adalah langkah menuju kesuksesan 🏆",
        "Nafas dalam-dalam, kamu siap menghadapinya! 🌬️",
        "Jangan buru-buru, kecepatan datang dari ketenangan ⏳",
        "Otakmu kuat, semangatmu tinggi! 🔥",
        "Kamu bukan hanya mengerjakan ujian, kamu mengukir prestasi 📜",
        "Langkah kecil hari ini, kemenangan besar besok 🌈",
        "Semangat pagi! Hari ini milikmu! ☀️",
        "Kamu dilindungi oleh semua doa orang tua 🙏",
        "Tetap tenang, kamu sudah belajar keras 📚",
        "Jawab dengan hati, bukan hanya otak ❤️",
        "Kamu hebat! Terus maju! 🌟"
    ];

    // Untuk setiap kartu ujian
    document.querySelectorAll('.exam-card').forEach(card => {
        const booster = card.querySelector('.mood-booster');
        if (!booster) return;

        // Simpan teks asli (untuk debugging)
        const defaultText = booster.textContent.trim();

        // Saat hover: ganti dengan pesan acak
        card.addEventListener('mouseenter', () => {
            const randomMsg = motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)];
            booster.textContent = randomMsg;
        });

        // Opsional: kembalikan ke default saat hover keluar (atau biarkan tetap)
        // card.addEventListener('mouseleave', () => {
        //     booster.textContent = defaultText;
        // });
    });
</script>
@endsection