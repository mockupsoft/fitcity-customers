<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Qr İşlemleri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: #F8FAFC; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px; }
        .page-header {
            margin-top: 50px;
            margin-bottom: 40px;
        }
        .page-title {
            color: #0a0615;
            font-size: 28px;
            font-weight: 700;
        }
        .buttons-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Butonlar arası boşluk */
        }
        .qr-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 50px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .qr-button-filled {
            background-color: #D9376E; /* Ekran görüntüsündeki pembe/mor renk */
            color: white;
            border: 2px solid #D9376E;
        }
        .qr-button-filled:hover {
            background-color: #c33164;
            border-color: #c33164;
        }
        .qr-button-outlined {
            background-color: white;
            color: #D9376E;
            border: 2px solid #D9376E;
        }
        .qr-button-outlined:hover {
            background-color: #D9376E;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="page-header">
            <h1 class="page-title">Qr İşlemleri</h1>
        </div>

        <div class="buttons-container">
            <a href="{{ route('coming-soon') }}" class="qr-button qr-button-filled">Salona Giriş</a>
            <a href="{{ route('qr.scan') }}" class="qr-button qr-button-outlined">Qr Okut</a>
        </div>
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
