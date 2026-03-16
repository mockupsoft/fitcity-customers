<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kullanım Koşulları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;900&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz olduğu gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; margin: 0 auto; margin-top: 66px; }
        .hero-image { width: 100%; max-width: 435px; height: 270px; object-fit: cover; margin-top: 40px; margin-bottom: 40px; display: block; margin-left: auto; margin-right: auto; }
        .main-title { color: #0a0615; font-size: 27px; font-family: "Poppins", sans-serif; font-weight: 700; line-height: 32px; text-align: center; padding: 0 30px; margin-top: 20px; }
        .description-text { color: #0b0616; font-size: 16px; font-family: "Open Sans", sans-serif; font-weight: 400; line-height: 22px; text-align: center; padding: 0 40px; margin-top: 30px; }
        .continue-button-container { position: absolute; bottom: 60px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <a href="{{ route('register') }}" class="back-button">
        <div class="icon"></div>
    </a>

    <div class="progress-bar-indicator"></div>



    <h1 class="main-title">
        Kullanım Koşulları
    </h1>

    <p><strong>Son Güncelleme:</strong> 14 Eylül 2025</p>

    <p>Lütfen FitCity mobil uygulamasını ve web sitelerini ("Hizmetler") kullanmadan önce bu Kullanım Koşulları'nı dikkatlice okuyun. Hizmetlerimize erişerek veya kullanarak, bu koşullara bağlı kalmayı kabul etmiş olursunuz.</p>

    <h2>1. Hesaplar</h2>
    <p>Hizmetlerimizi kullanmak için bir hesap oluşturduğunuzda, bize sağladığınız bilgilerin doğru, eksiksiz ve güncel olduğunu garanti edersiniz. Hesabınızın güvenliğinden ve şifrenizin gizliliğinden siz sorumlusunuz.</p>

    <h2>2. Abonelikler ve Ödemeler</h2>
    <p>Bazı hizmetlerimiz abonelik bazında sunulmaktadır. Bir abonelik satın aldığınızda, seçtiğiniz paketin ücreti belirtilen periyotlarda (aylık/yıllık) otomatik olarak tahsil edilecektir. Ödeme işlemleri, güvenli bir üçüncü taraf ödeme sağlayıcısı (PayTR) tarafından yürütülür.</p>

    <h2>3. Fikri Mülkiyet</h2>
    <p>Hizmetler ve orijinal içeriği, özellikleri ve işlevselliği FitCity'nin mülkiyetindedir ve telif hakkı, ticari marka ve diğer yasalarla korunmaktadır.</p>

    <h2>4. Sorumluluğun Sınırlandırılması</h2>
    <p>FitCity, sunduğu antrenman programları ve içeriklerin kullanımından kaynaklanabilecek herhangi bir yaralanma veya zarardan sorumlu tutulamaz. Herhangi bir egzersiz programına başlamadan önce bir sağlık profesyoneline danışmanız tavsiye edilir.</p>

    <h2>5. Fesih</h2>
    <p>Bu koşulları ihlal etmeniz durumunda, önceden haber vermeksizin hesabınıza erişiminizi derhal sonlandırma veya askıya alma hakkımızı saklı tutarız.</p>

    <h2>6. İletişim</h2>
    <p>Kullanım Koşulları hakkında herhangi bir sorunuz varsa, lütfen bizimle [destek@fitcity.com.tr] adresi üzerinden iletişime geçin.</p>




</div>
</body>
</html>
