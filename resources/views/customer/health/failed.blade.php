<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sağlık Uyarısı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff5f5; font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .container { max-width: 450px; padding: 20px; }
        .warning-card { background: white; padding: 40px 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1); text-align: center; }
        .icon-circle { width: 100px; height: 100px; background-color: #ffe3e3; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px auto; }
        .icon-text { font-size: 50px; }
        h2 { color: #2d3748; font-weight: 700; margin-bottom: 15px; font-size: 24px; }
        p { color: #718096; font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
        .highlight { color: #dc3545; font-weight: 600; }
        .btn-outline-secondary { border-radius: 25px; padding: 12px 25px; font-weight: 500; border: 2px solid #e2e8f0; color: #718096; background: transparent; transition: all 0.3s; width: 100%; }
        .btn-outline-secondary:hover { border-color: #cbd5e0; background-color: #f7fafc; color: #2d3748; }
    </style>
</head>
<body>

<div class="container">
    <div class="warning-card">
        <div class="icon-circle">
            <span class="icon-text">⚠️</span>
        </div>
        <h2>Sağlık Raporu Gerekli</h2>
        <p>Verdiğiniz cevaplara göre, sağlığınız için antrenmanlara başlamadan önce mutlaka bir <span class="highlight">doktor kontrolünden</span> geçmeniz ve <span class="highlight">sağlık raporu</span> almanız gerekmektedir.</p>

        <a href="{{ route('health-screening.start') }}" class="btn btn-outline-secondary">
            Hatalı Giriş Yaptıysanız Tekrar Deneyin
        </a>
    </div>
</div>

</body>
</html>
