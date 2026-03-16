<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kondisyon Seviyesi Özeti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@275;400;500;700;800;900&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz olduğu gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; z-index: 10; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; position: absolute; top: 66px; left: 50%; transform: translateX(-50%); }
        .main-title { color: #0a0615; font-size: 25px; font-family: "Poppins", sans-serif; font-weight: 700; line-height: 32px; text-align: center; padding: 0 25px; position: absolute; width: calc(100% - 50px); top: 114px; left: 50%; transform: translateX(-50%); }
        .bmi-card { width: calc(100% - 32px); max-width: 358px; min-height: 178px; background: white; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; position: absolute; top: 175px; left: 50%; transform: translateX(-50%); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
        .bmi-card-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
        .bmi-title { color: #0a0615; font-size: 16px; font-weight: 500; white-space: nowrap; }
        .bmi-value-normal { color: #9299a3; font-size: 15px; font-weight: 500; text-align: right; white-space: nowrap; }
        .bmi-slider-track { width: calc(100% - 20px); height: 1px; background-color: #e5e9ef; margin: 10px auto 5px; position: relative; }
        .bmi-indicator {
            /* ... */

            /* Dinamik Pozisyonlama */
            @php
                $percentage = 50; // Varsayılan pozisyon
                // SADECE $bmiValue SAYISAL BİR DEĞERSE HESAPLAMA YAP
                if (is_numeric($bmiValue)) {
                    $minBmi = 18.5;
                    $maxBmi = 35;
                    $percentage = ($bmiValue - $minBmi) / ($maxBmi - $minBmi) * 100;
                    $percentage = max(0, min(100, $percentage));
                }
            @endphp
left: {{ $percentage }}%;
            transform: translateX(-{{ $percentage / 2 }}%); /* Daha doğru ortalama için */

            border: 2px solid white;
            box-sizing: border-box;
        }
        .bmi-labels { display: flex; justify-content: space-between; width: 100%; padding: 0 10px; margin-top: 5px; }
        .bmi-label { color: #9299a3; font-size: 8px; font-weight: 900; }
        .your-bmi-tag { background-color: #282d32; border-radius: 12px; color: white; font-size: 7px; font-weight: 500; padding: 0 10px; height: 17px; display: flex; align-items: center; justify-content: center; position: absolute; top: 99px; left: 80px; white-space: nowrap; }
        .person-image { width: 148px; height: 225px; position: absolute; left: 35px; top: 380px; object-fit: contain; }
        .info-section { display: flex; flex-direction: column; gap: 15px; position: absolute; left: 224px; top: 430px; }
        .info-item { display: flex; align-items: center; width: 143px; height: 40px; }
        .info-item img { width: 22px; height: 22px; margin-right: 7px; }
        .info-text { display: flex; flex-direction: column; justify-content: center; }
        .info-label { color: #686869; font-size: 12px; font-weight: 275; line-height: 20px; white-space: nowrap; }
        .info-value { color: #31353b; font-size: 15px; font-weight: 900; line-height: 20px; white-space: nowrap; }
        .info-value.small-text { font-size: 11px; }
        .muscle-gain-info { width: 318px; min-height: 57px; background-color: #eff9ef; border-radius: 7px; position: absolute; left: 50%; transform: translateX(-50%); top: 631px; padding: 10px 15px; display: flex; flex-direction: column; justify-content: center; }
        .muscle-gain-title { color: black; font-size: 10px; font-weight: 800; line-height: 24px; margin-bottom: 2px; display: flex; align-items: center; }
        .muscle-gain-title .emoji { font-size: 25px; margin-right: 5px; line-height: 1; }
        .muscle-gain-description { color: black; font-size: 5px; font-weight: 500; line-height: 6px; }
        .continue-button-container { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <a href="{{ route('infos.target-areas') }}" class="back-button">
        <div class="icon"></div>
    </a>

    <div class="progress-bar-indicator"></div>
    <h1 class="main-title">Kondisyon Seviyenizin Özeti</h1>

    <div class="bmi-card">
        <div class="bmi-card-header">
            <div class="bmi-title">Vücut Kitle İndeksi (BMI)</div>
            <div class="bmi-value-normal">{{ $bmiCategory }} - {{ $bmiValue }}</div>
        </div>
        <div class="bmi-slider-track">
            <div class="bmi-indicator"></div>
        </div>
        <div class="bmi-labels">
            <div class="bmi-label">NORMAL</div>
            <div class="bmi-label">KİLOLU</div>
            <div class="bmi-label">OBEZ</div>
        </div>
        <div class="your-bmi-tag">Sen - {{ $bmiValue }}</div>
    </div>

    <img class="person-image" src="{{ asset('img/sayfa12.png') }}" alt="Person representing fitness level"/>

    <div class="info-section">
        <div class="info-item">
            <img src="{{ asset('img/sayfa12-1.png') }}" alt="Lifestyle Icon" />
            <div class="info-text">
                <div class="info-label">Yaşam Tarzı</div>
                <div class="info-value">{{ $lifestyle }}</div>
            </div>
        </div>
        <div class="info-item">
            <img src="{{ asset('img/sayfa12-2.png') }}" alt="Exercise Icon" />
            <div class="info-text">
                <div class="info-label">Egzersiz</div>
                <div class="info-value small-text">{{ $exercisePreference }}</div>
            </div>
        </div>
        <div class="info-item">
            <img src="{{ asset('img/sayfa12-3.png') }}" alt="Activity Level Icon" />
            <div class="info-text">
                <div class="info-label">Etkinlik seviyesi</div>
                <div class="info-value">{{ $lifestyle }}</div>
            </div>
        </div>
    </div>

    <div class="muscle-gain-info">
        <div class="muscle-gain-title">
            <span class="emoji">💪</span>Kas kazanımı için iyi bir başlangıç BMI
        </div>
        <div class="muscle-gain-description">
            Araştırmalara göre, %8-12, erkeklerin kas kazanmaya başlaması ve daha
            hızlı <br />hacim kazanması için ideal vücut yağ oranıdır.
        </div>
    </div>

    <div class="continue-button-container">
        <a href="{{ route('code.index') }}" class="continue-button">
            Devam et
        </a>
    </div>

</div>
</body>
</html>
