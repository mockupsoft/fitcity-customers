<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Boy & Kilo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; }
        .form-container { display: flex; flex-direction: column; height: calc(100vh - 80px); /* bottom-nav için boşluk bırak */ padding: 20px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .title { color: #0a0615; font-size: 27px; font-weight: 600; text-align: center; margin-top: 60px; margin-bottom: 20px; }
        .info-box { background-color: #eff9ef; padding: 15px; margin: 0 auto 30px; width: 100%; max-width: 318px; }
        .info-box p { font-size: 10px; font-family: Poppins; font-weight: 500; color: black; margin-bottom: 0; text-align: center;}
        .input-container { margin: 0 auto; padding: 0 20px; width: 100%; }
        .input-container .form-label { font-weight: 500; margin-bottom: 0.5rem; text-align: center; display: block; }
        .input-container .form-control { border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center; font-size: 24px; font-weight: 600; color: #0a0615; box-shadow: none; }
        .content-wrapper { flex-grow: 1; /* Bu alanın tüm boşluğu kaplamasını sağlar */ }
        .continue-button-container { padding: 0 20px 20px; /* Alttan boşluk bırakır */ }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="app-container">
    <form method="POST" action="{{ route('infos.body-metrics.store') }}" class="form-container">
        @csrf

        <a href="{{ url()->previous() }}" class="back-button">
            <div class="icon"></div>
        </a>

        <div class="content-wrapper">
            <h1 class="title">Boy ve Kilonuz</h1>

            <div class="info-box">
                <p>Vücut Kitle Endeksinizi doğru hesaplamak için bu bilgilere ihtiyacımız var.</p>
            </div>

            <div class="input-container">
                <label for="height" class="form-label">Boy (cm)</label>
                <input type="number" name="height" id="height" class="form-control mb-4" placeholder="175" value="{{ old('height', $height) }}" required>

                <label for="weight" class="form-label">Kilo (kg)</label>
                <input type="number" step="0.1" name="weight" id="weight" class="form-control" placeholder="70.5" value="{{ old('weight', $weight) }}" required>
            </div>
        </div>

        <div class="continue-button-container">
            <button type="submit" class="continue-button">
                Devam Et
            </button>
        </div>
    </form>

</div>
</body>
</html>
