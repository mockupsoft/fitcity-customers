<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telefon Doğrulama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400&family=SF+Pro&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        .app-container {
            max-width: 390px;
            width: 100%;
            min-height: 844px;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Numpad'i aşağı itmek için */
            align-items: center;
        }
        .content-section {
            width: 100%;
            max-width: 358px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
            flex-grow: 1; /* içeriği büyüt */
        }
        .app-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 25px;
            font-family: "SF Pro", sans-serif;
            position: absolute;
            top: 0;
        }
        .app-header .time { font-size: 15px; font-weight: 590; }
        .page-title {
            color: #0A0615;
            font-size: 27px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 10px;
        }
        .page-subtitle {
            color: #0B0616;
            font-size: 16px;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            margin-bottom: 10px;
        }
        .phone-number {
            color: #0B0616;
            font-size: 16px;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700; /* Daha belirgin */
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-input-area {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px; /* Boşluk artırıldı */
        }
        .otp-box {
            width: 50px; /* Boyut biraz küçültüldü */
            height: 50px;
            background: #F1F4F8; /* Arkaplan rengi */
            border-radius: 8px;
            border: 1px solid #E5E9EF;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
            color: #0A0615;
        }
        .resend-code {
            color: #282D32;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .numpad-overlay {
            width: 100%;
            height: auto; /* İçeriğe göre yükseklik */
            background: #F3F3F6;
            padding: 20px 5px 15px 5px; /* Padding ayarlandı */
        }
        .numpad-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .numpad-key {
            width: 100%;
            height: 46px;
            background: #FCFCFE;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            font-family: 'SF Pro', sans-serif;
        }
        .numpad-key.icon { font-size: 20px; }
        .numpad-key.transparent { background-color: transparent; }
        .home-indicator {
            width: 134px;
            height: 5px;
            background: black;
            border-radius: 100px;
            margin-top: 15px;
        }
        /* Hata mesajı stili */
        .error-message {
            color: #dc3545;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
            min-height: 20px;
        }
    </style>
</head>
<body>
<div class="app-container">
    <form id="verify-form" method="POST" action="{{ route('sms.verify.submit') }}" class="content-section">
        @csrf
        <input type="hidden" name="code" id="code-input">

        <h1 class="page-title">Telefon Doğrulaması</h1>
        <p class="page-subtitle">Numaranıza bir kod gönderdik</p>

        <div class="phone-number">{{ $user->phone ?? 'telefon numaranız' }}</div>

        <div class="error-message">
            @error('code')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="otp-input-area">
            <div class="otp-box"></div>
            <div class="otp-box"></div>
            <div class="otp-box"></div>
            <div class="otp-box"></div>
            <div class="otp-box"></div>
            <div class="otp-box"></div>
        </div>

{{--        <a href="#" class="resend-code">Resend code</a>--}}
    </form>
    <div class="numpad-overlay">
        <div class="numpad-grid">
            <button class="numpad-key" data-key="1">1</button>
            <button class="numpad-key" data-key="2">2</button>
            <button class="numpad-key" data-key="3">3</button>
            <button class="numpad-key" data-key="4">4</button>
            <button class="numpad-key" data-key="5">5</button>
            <button class="numpad-key" data-key="6">6</button>
            <button class="numpad-key" data-key="7">7</button>
            <button class="numpad-key" data-key="8">8</button>
            <button class="numpad-key" data-key="9">9</button>
            <button class="numpad-key transparent"></button> <button class="numpad-key" data-key="0">0</button>
            <button class="numpad-key icon" data-key="backspace">⌫</button>
        </div>
        <div class="home-indicator"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const otpBoxes = document.querySelectorAll('.otp-box');
        const numpad = document.querySelector('.numpad-grid');
        const hiddenInput = document.getElementById('code-input');
        const form = document.getElementById('verify-form');
        let otpCode = '';

        // Numpad'e tıklandığında çalışacak fonksiyon
        numpad.addEventListener('click', function (e) {
            const target = e.target.closest('.numpad-key');
            if (!target) return;

            const key = target.dataset.key;

            if (key === 'backspace') {
                // Silme tuşuna basıldıysa
                if (otpCode.length > 0) {
                    otpCode = otpCode.slice(0, -1);
                }
            } else if (key && otpCode.length < 6) {
                // Rakam tuşuna basıldıysa ve kod 6 haneden küçükse
                otpCode += key;
            }

            updateDisplay();

            // Kod 6 haneye ulaştığında formu otomatik gönder
            if (otpCode.length === 6) {
                form.submit();
            }
        });

        // Görsel kutucukları ve gizli input'u güncelleyen fonksiyon
        function updateDisplay() {
            otpBoxes.forEach((box, index) => {
                box.textContent = otpCode[index] || '';
            });
            hiddenInput.value = otpCode;
        }
    });
</script>
</body>
</html>
