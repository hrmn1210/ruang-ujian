<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bukti Pengerjaan Ujian</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #34495e;
            font-size: 11px;
        }

        .card {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }

        .header {
            background: #ff6a4a;
            color: white;
            padding: 30px 25px;
            text-align: center;
        }

        .app-name {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        /* --- CSS FINAL UNTUK PENENGAHAN SKOR --- */
        .score-circle {
            width: 80px;
            height: 80px;
            margin: 15px auto;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .score {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding-bottom: 5px;
            font-size: 32px;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .score-label {
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            font-weight: 500;
        }

        /* --- AKHIR DARI CSS FINAL --- */

        .student-name {
            font-size: 18px;
            font-weight: 700;
            margin: 10px 0 5px 0;
            color: white;
        }

        .student-class {
            font-size: 12px;
            opacity: 0.9;
            color: white;
        }

        .content {
            padding: 20px 25px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 600;
            color: #34495e;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin: 18px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .details-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .details-list .label {
            font-weight: 500;
            width: 60px;
            color: #7f8c8d;
        }

        .details-list .value {
            font-weight: 500;
        }

        .correct {
            color: #16a34a;
        }

        .incorrect {
            color: #dc2626;
        }

        .motivation-box {
            margin-top: 15px;
            padding: 12px 16px;
            border-radius: 10px;
            background: #e7f7ec;
            border-left: 4px solid #16a34a;
            font-size: 11px;
            line-height: 1.5;
            color: #16a34a;
        }

        .footer {
            padding: 20px 25px;
            border-top: 1px dashed #ddd;
            font-size: 10px;
            color: #7f8c8d;
            text-align: center;
        }

        .qr-container {
            margin-top: 15px;
        }

        .qr-container img {
            width: 80px;
            height: 80px;
            border: 1px solid #eee;
            border-radius: 8px;
            margin: 0 auto;
        }

        .qr-caption {
            display: block;
            margin-top: 6px;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="header">
            <div class="app-name">Ruang Ujian</div>

            <div class="score-circle">
                <div class="score">{{ round($attempt->score) }}</div>
                <div class="score-label">SKOR</div>
            </div>

            <div class="student-name">{{ $attempt->student->user->name }}</div>
            <div class="student-class">{{ $attempt->student->classModel->name }}</div>
        </div>

        <div class="content">
            <div class="section-title">DETAIL UJIAN</div>
            <ul class="details-list">
                <li>
                    <span class="label">Ujian</span>
                    <span class="value">: {{ $attempt->exam->title }}</span>
                </li>
                <li>
                    <span class="label">Tanggal</span>
                    <span class="value">: {{ \Carbon\Carbon::parse($attempt->finished_at)->format('d F Y') }}</span>
                </li>
                <li>
                    <span class="label">Mapel</span>
                    <span class="value">: {{ $attempt->exam->subject->name }}</span>
                </li>
            </ul>

            <div class="section-title">RANGKUMAN HASIL</div>
            <ul class="details-list">
                <li>
                    <span class="label">Benar</span>
                    <span class="value correct">: {{ $correctAnswers }} dari {{ $totalQuestions }}</span>
                </li>
                <li>
                    <span class="label">Salah</span>
                    <span class="value incorrect">: {{ $incorrectAnswers }}</span>
                </li>
                <li>
                    <span class="label">Durasi</span>
                    <span class="value">: {{ $duration }}</span>
                </li>
            </ul>

            <div class="motivation-box">
                @php
                $score = round($attempt->score);
                $name = explode(' ', $attempt->student->user->name)[0];
                @endphp
                @if ($score >= 90)
                Wah, {{ $name }}! Otakmu kayak SSD, cepat dan gak error! 💻🔥
                @elseif ($score >= 80)
                Keren, {{ $name }}! Nilainya tinggi, gayanya santai! 😎🚀
                @elseif ($score >= 70)
                Mantap, {{ $name }}! Hampir sempurna, tinggal sedikit lagi jadi legenda! 🏆📚
                @elseif ($score >= 60)
                {{ $name }}, kamu lulus… dengan gaya! Tapi next time, kita kejar nilai 100 ya! 💪😄
                @elseif ($score >= 50)
                Wah, {{ $name }}, nilai kamu kayak kuota internet: pas-pasan, tapi masih bisa buka YouTube! 📺😂
                @else
                {{ $name }}, ini bukan akhir dunia… tapi mungkin akhir kuota! 😂 Tapi tenang, semua bisa diperbaiki!
                @endif
            </div>
        </div>

        <div class="footer">
            <p>Bukti ini sah jika QR code terbaca dan data sesuai sistem.</p>
            <p>ID Verifikasi: <strong>{{ $attempt->id }}</strong></p>

            <div class="qr-container">
                @php
                $qrData = route('student.exam.proof', $attempt->id);
                $qrCodeImage = (new \chillerlan\QRCode\QRCode)->render($qrData);
                @endphp

                {!! '<img src="' . $qrCodeImage . '" alt="QR Code">' !!}

                <span class="qr-caption">Scan untuk verifikasi</span>
            </div>
        </div>
    </div>

</body>

</html>