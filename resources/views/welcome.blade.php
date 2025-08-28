<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di Ruang Ujian Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-1: #ff9a8b;
            --color-2: #ff6a88;
            --color-3: #ffb347;
            --text-light: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(-45deg, var(--color-1), var(--color-2), var(--color-3));
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            color: var(--text-light);
            overflow-x: hidden;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-light);
            text-decoration: none;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn {
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            color: var(--color-2);
        }

        .btn-light:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .hero {
            padding: 100px 0;
            text-align: center;
        }

        .hero .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 60px 40px;
            border-radius: 25px;
            display: inline-block;
        }

        /* Gaya untuk Animasi Teks "Wave on Hover" */
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        .hero h1 span {
            display: inline-block;
            transition: transform 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0), color 0.3s;
            cursor: default;
        }

        .hero h1 span:hover {
            transform: translateY(-20px);
            color: var(--color-3);
            /* Warna berubah saat terangkat */
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        .features {
            padding: 60px 0 80px;
            text-align: center;
        }

        .features h2,
        .features .lead {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .features.is-visible h2,
        .features.is-visible .lead {
            opacity: 1;
            transform: translateY(0);
        }

        .features h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .features .lead {
            max-width: 700px;
            margin: 0 auto 50px;
            opacity: 0.9;
            transition-delay: 0.2s;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 20px;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(50px);
        }

        .features.is-visible .feature-card {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-card:nth-child(1) {
            transition-delay: 0.3s;
        }

        .feature-card:nth-child(2) {
            transition-delay: 0.4s;
        }

        .feature-card:nth-child(3) {
            transition-delay: 0.5s;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-card .icon {
            font-size: 3rem;
            margin-bottom: 20px;
            line-height: 1;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .feature-card p {
            opacity: 0.9;
            line-height: 1.6;
        }

        .footer {
            background: rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
            font-size: 0.9rem;
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
    </style>
</head>

<body>

    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">RuangUjian</a>
                <a href="{{ route('login') }}" class="btn btn-light">Login</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="glass-panel">
                    <h1 id="animated-headline">Ujian Online Modern & Handal</h1>
                    <p>Menyelenggarakan ujian menjadi lebih mudah, efisien, dan aman untuk semua tingkat pendidikan.</p>
                    <a href="{{ route('login') }}" class="btn btn-light">Mulai Sekarang</a>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2 class="animated-on-scroll">Dirancang untuk Semua Peran</h2>
                <p class="lead animated-on-scroll">Setiap pengguna mendapatkan pengalaman terbaik yang disesuaikan dengan kebutuhannya, mulai dari murid, guru, hingga administrator sekolah.</p>
                <div class="features-grid">
                    <div class="feature-card animated-on-scroll">
                        <div class="icon">🎓</div>
                        <h3>Untuk Murid</h3>
                        <p>Akses ujian dengan mudah, antarmuka pengerjaan yang bersih, dan lihat hasil secara instan. Fokus pada soal, bukan pada teknis.</p>
                    </div>
                    <div class="feature-card animated-on-scroll">
                        <div class="icon">👩‍🏫</div>
                        <h3>Untuk Guru</h3>
                        <p>Buat soal ujian dalam hitungan menit, impor soal dari dokumen Word, dan pantau nilai murid secara real-time dari satu tempat.</p>
                    </div>
                    <div class="feature-card animated-on-scroll">
                        <div class="icon">⚙️</div>
                        <h3>Untuk Admin</h3>
                        <p>Kelola semua data master seperti kelas, mata pelajaran, guru, dan murid dengan mudah melalui panel administrasi yang terpusat.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} RuangUjian. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi Teks "Wave on Hover"
            const headline = document.getElementById('animated-headline');
            if (headline) {
                const text = headline.textContent;
                const wrappedText = text.split('').map(char => `<span>${char === ' ' ? '&nbsp;' : char}</span>`).join('');
                headline.innerHTML = wrappedText;
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

            const elementsToAnimate = document.querySelectorAll('.features, .feature-card');
            elementsToAnimate.forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>