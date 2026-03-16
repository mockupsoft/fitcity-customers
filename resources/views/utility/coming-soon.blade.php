<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yakında</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: #F8FAFC; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content {
            height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .icon-container svg {
            width: 80px;
            height: 80px;
            color: #D9376E; /* Ana renk */
            margin-bottom: 20px;
        }
        .page-title {
            color: #0a0615;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .page-description {
            color: #404b52;
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 300px;
        }
        .back-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 180px;
            height: 50px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            background-color: #D9376E;
            color: white;
            border: 2px solid #D9376E;
        }
        .back-button:hover {
            background-color: #c33164;
            border-color: #c33164;
        }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
        </div>
        <h1 class="page-title">Çok Yakında!</h1>
        <p class="page-description">
            Bu özellik üzerinde çalışıyoruz ve en kısa sürede kullanımınıza sunmak için sabırsızlanıyoruz.
        </p>
        <a href="{{ url()->previous() }}" class="back-button">Geri Dön</a>
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
