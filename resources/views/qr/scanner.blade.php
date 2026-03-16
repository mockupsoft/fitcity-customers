<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QR Kod Okuyucu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; }
        .app-container { max-width: 490px; margin: auto; background: #f8fafc; min-height: 100vh; }

        #qr-reader {
            width: 100%;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Kütüphanenin çirkin çerçevelerini temizliyoruz */
        #qr-reader video {
            width: 100% !important;
            height: auto !important;
            border-radius: 15px;
            object-fit: cover;
        }
        .spinner-border { width: 3rem; height: 3rem; }
    </style>
</head>
<body>
<div class="container-fluid app-container p-4">
    <h1 class="text-center my-4 fw-bold">Stüdyo Girişi</h1>
    <p class="text-center text-muted mb-4">Lütfen kameranızı stüdyo girişindeki QR koda tutun.</p>

    <div id="qr-reader-container" class="position-relative">
        <div id="qr-reader"></div>
    </div>

    <div id="result-container" class="mt-4 text-center">
        <div id="loading" class="d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <p class="mt-2">Check-in yapılıyor, lütfen bekleyin...</p>
        </div>
        <div id="message"></div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrCode;

    // Kamerayı otomatik başlatan fonksiyon
    function startCamera() {
        html5QrCode = new Html5Qrcode("qr-reader");

        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        };

        // facingMode: "environment" ile doğrudan arka kamerayı çağırıyoruz
        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
            .catch((err) => {
                console.error(err);
                document.getElementById('message').innerHTML = `
                <div class="alert alert-danger text-start" style="font-size: 0.9rem;">
                    <strong>Kamera başlatılamadı!</strong><br><br>
                    1. Tarayıcı ayarlarına girip bu site için <b>Kamera</b> iznini verdiğinize emin olun.<br>
                    2. Eğer siteyi telefondan test ediyorsanız, adres çubuğunda <b>https://</b> yazdığından emin olun.
                </div>
            `;
            });
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (html5QrCode) {
            html5QrCode.stop().catch(err => console.error("Kamera durdurulamadı", err));
        }

        document.getElementById('qr-reader-container').classList.add('d-none');
        document.getElementById('loading').classList.remove('d-none');
        document.querySelector('#loading p').innerText = "Check-in yapılıyor, lütfen bekleyin...";

        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = '';

        let classId = null;
        try {
            // QR'dan gelen link: https://portal.fitcity.com.tr/member/classes/5/check-in
            const urlObj = new URL(decodedText);
            const pathParts = urlObj.pathname.split('/');

            // "check-in" yazısının dizideki yerini bulup, bir önceki elemanı (yani 5'i) alıyoruz
            const checkInIndex = pathParts.indexOf('check-in');
            if (checkInIndex > 0) {
                classId = pathParts[checkInIndex - 1];
            } else {
                throw new Error("URL içinde check-in kelimesi yok");
            }

            // Eğer bulduğumuz değer bir sayı değilse hata ver
            if (!classId || isNaN(classId)) {
                throw new Error("Bulunan ID geçerli bir sayı değil");
            }
        } catch (e) {
            handleCheckInError("Geçersiz QR kod formatı. Ders ID'si okunamadı.");
            return;
        }

        // TAM URL'YE DEĞİL, KENDİ MÜŞTERİ SUNUCUMUZA (Örn: /api/check-in/5) İSTEK ATIYORUZ
        sendCheckInRequest('/api/check-in/' + classId);
    }

    function sendCheckInRequest(requestUrl) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const apiToken = localStorage.getItem('api_token');

        fetch(requestUrl, {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(csrfToken && {'X-CSRF-TOKEN': csrfToken}),
                ...(apiToken && {'Authorization': 'Bearer ' + apiToken})
            }
        })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            })
            .then(result => {
                if (result.success) {
                    handleCheckInSuccess(result.message);
                } else {
                    handleCheckInError(result.message || "Bilinmeyen bir hata oluştu.");
                }
            })
            .catch(err => {
                // Telefonda hatayı net görmek için alert ekledik
                alert("Sunucu Hatası: " + (err.message || JSON.stringify(err)));
                handleCheckInError(err.message || "Sunucuya bağlanırken bir hata oluştu.");
            });
    }

    function handleCheckInSuccess(message) {
        document.getElementById('loading').classList.add('d-none');
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = `<div class="alert alert-success">${message}</div>`;
        setTimeout(() => window.location.href = '/dashboard', 3000);
    }

    function handleCheckInError(message) {
        document.getElementById('loading').classList.add('d-none');
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = `<div class="alert alert-danger">${message}</div>`;
        setTimeout(() => {
            messageDiv.innerHTML = '';
            document.getElementById('qr-reader-container').classList.remove('d-none');
            // Hata sonrası kamerayı tekrar başlat
            startCamera();
        }, 5000);
    }

    // Sayfa yüklendiğinde kamerayı başlat
    document.addEventListener("DOMContentLoaded", function() {
        startCamera();
    });
</script>
</body>
</html>
