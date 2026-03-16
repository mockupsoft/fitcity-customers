<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alışkanlıkları Değiştirme</title>
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
    <a href="{{ route('infos.habits') }}" class="back-button">
        <div class="icon"></div>
    </a>

    <div class="progress-bar-indicator"></div>

    <img class="hero-image" src="{{ asset('img/sayfa9.png') }}" alt="Alışkanlıklar için illüstrasyon"/>

    <h1 class="main-title">
        Alışkanlıklarınızı her zaman daha iyiye doğru değiştirebilirsiniz
    </h1>

    <p class="description-text">
        Kendinizin daha iyi bir versiyonunu yaratmaya yönelik basit ve
        istikrarlı adımlar atın. Kendinize güveniyorsanız ve vücudunuzu
        seviyorsanız, her zaman çekici ve çekici olursunuz.
    </p>

    <div class="continue-button-container">
        <a href="{{ route('infos.target-areas') }}" class="continue-button">
            Devam et
        </a>
    </div>

</div>
</body>
</html>
