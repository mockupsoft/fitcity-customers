<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sağlıklı Yaşam</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;0,800;1,800&family=Poppins:wght@900&display=swap"
        rel="stylesheet"
    />

    <style>
        /* Sayfa genel stilleri ve özel ayarlar */
        body {
            background-color: #e9ecef; /* Simülasyon için dış arka plan */
            font-family: "Open Sans", sans-serif;
        }

        /* Orijinal tasarımdaki mobil ekran görünümünü taklit etmek için */
        .mobile-container {
            max-width: 490px;
            min-height: 100vh;
            margin: auto;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            justify-content: space-around; /* İçerikleri dikeyde yaymak için */
            padding: 2rem 1.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Özel buton stili */
        .custom-btn {
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-size: 17px;
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
            box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2);
            /* Bootstrap'in kendi rengiyle uyumlu olması için btn-dark kullandık */
        }

        /* Özel başlık stili */
        .custom-heading {
            font-size: 25px;
            font-weight: 800;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container mobile-container">
    <main class="text-center">
        <img
            src="{{asset('img/sayfa2.png')}}"
            class="img-fluid rounded-5 mb-5"
            alt="Sağlıklı yaşam görseli"
        />

        <p class="h5 fw-semibold text-secondary mb-4">
            Merhaba! Daha sağlıklı bir yaşam yolunda ilerlediğinizi gördüğüme
            sevindim!
        </p>
    </main>

    <footer class="text-center">
        <p class="custom-heading mb-4">ZATEN HESABINIZ VAR MI?</p>
        <div class="row g-3">
            <div class="col">
                <a href="{{route('login')}}" class="btn btn-dark w-100 rounded-pill custom-btn"
                >EVET</a
                >
            </div>
            <div class="col">
                <a href="{{route('register')}}"  class="btn btn-dark w-100 rounded-pill custom-btn"
                >HAYIR</a
                >
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
