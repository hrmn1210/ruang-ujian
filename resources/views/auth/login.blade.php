<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang Ujian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Warna oranye Shopee untuk gradasi */
            --color-1: #ff9a8b;
            --color-2: #ff6a88;
            --color-3: #ffb347;
            --text-light: #ffffff;
            --text-dark: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            /* Gradasi animasi satu halaman penuh */
            background: linear-gradient(-45deg, var(--color-1), var(--color-2), var(--color-3));
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 950px;
            min-height: 550px;
            /* Efek Glassmorphism */
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Panel Ilustrasi (Kiri) */
        .image-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            animation: slideInLeft 1s ease-in-out;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .image-panel img {
            max-width: 90%;
            animation: float 4s ease-in-out infinite;
        }

        /* Panel Form (Kanan) */
        .form-panel {
            flex: 1.2;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideInRight 1s ease-in-out;
        }

        .form-panel h1 {
            font-size: 2.1rem;
            color: var(--text-light);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            font-weight: 700;
            animation: fadeInUp 0.8s ease-in-out forwards;
            opacity: 0;
        }

        .form-panel p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
            font-size: 0.95rem;
            animation: fadeInUp 0.8s ease-in-out 0.2s forwards;
            opacity: 0;
        }

        /* Input Field disesuaikan untuk Glassmorphism */
        .input-field {
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-in-out 0.4s forwards;
            opacity: 0;
        }

        .input-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-light);
            text-align: left;
        }

        .input-field input {
            width: 100%;
            height: 50px;
            padding: 0 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            color: var(--text-light);
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-field input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-field input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }

        .error-message {
            color: #ffdddd;
            font-size: 0.875rem;
            margin-top: 5px;
            text-align: left;
        }

        /* Tombol */
        .login-button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background: #ffffff;
            color: var(--color-2);
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-in-out 0.6s forwards;
            opacity: 0;
        }

        .login-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
            animation: fadeInUp 0.8s ease-in-out 0.8s forwards;
            opacity: 0;
        }

        .back-link:hover {
            color: var(--text-light);
        }

        /* Definisi Animasi */
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

        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="image-panel">
            <img src="{{ asset('images/ilustrasi.png') }}" alt="Ilustrasi">
        </div>
        <div class="form-panel">
            <h1>Masuk Akun</h1>
            <p>Selamat datang! Silakan masuk untuk melanjutkan.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-field">
                    <label for="email">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="contoh@email.com">
                </div>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="input-field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="login-button">Login Sekarang</button>
            </form>

            <a href="{{ url('/') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</body>

</html>