<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fitness Planınız</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz olduğu gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; z-index: 10; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; position: absolute; top: 66px; left: 50%; transform: translateX(-50%); }
        .main-title { color: #0a0615; font-size: 25px; font-family: "Poppins", sans-serif; font-weight: 700; line-height: 27px; text-align: center; padding: 0 25px; position: absolute; width: calc(100% - 50px); top: 106px; left: 50%; transform: translateX(-50%); }
        .target-info { position: absolute; top: 207px; left: 50%; transform: translateX(-50%); text-align: center; width: calc(100% - 80px); max-width: 331px; }
        .target-info p { color: black; font-size: 12px; font-weight: 400; line-height: 14px; margin-bottom: 10px; }
        .target-info .target-date { color: black; font-size: 16px; font-weight: 400; line-height: 14px; margin-top: 10px; margin-bottom: 15px; }
        .target-info .surprise-message { color: black; font-size: 13px; font-weight: 400; line-height: 14px; margin-top: 15px; }
        /* Grafiği kapattığınız için stillerini sildim */
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

    <h1 class="main-title">
        Tek ve Biricik<br />Forma Girmek İçin İhtiyacınız Olan Plan
    </h1>

    <div class="target-info">
        <p>
            Verdiğiniz bilgilere göre,<br />hedef kilonuza şu tarihte
            ulaşacaksınız
        </p>
        <div class="target-date">
            {{ $targetWeight }} kg by {{ $targetDate->translatedFormat('j M, Y') }}
        </div>
        <div class="surprise-message">
            Spor etkinliğinizde herkesi şaşırtmaya hazır olun
        </div>
    </div>

    <div class="continue-button-container">
        <a href="{{ route('infos.subscription') }}" class="continue-button">Devam et</a>
    </div>

    <div class="home-indicator"></div>
</div>
</body>
</html>
