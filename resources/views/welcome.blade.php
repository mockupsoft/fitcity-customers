<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>FIT CITY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet"
    />

    <style>
        :root {
            --primary-color: #6c3bdf;
            --primary-shadow-color: rgba(83, 47, 170, 0.2);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
            background-color: #f5f5f5;
        }

        .frame {
            width: 100%;
            max-width: 490px;
            margin: 0 auto;
            min-height: 100vh;
            height: 100dvh;
            position: relative;
            overflow-x: hidden;
            background-image: url("https://c.animaapp.com/md5yv0cxrhWgd1/img/bg.svg");
            background-size: 100% 100%;
        }

        .image-container {
            position: absolute;
            width: 390px;
            max-width: 100%;
            height: 430px;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
        }

        #onboarding-image {
            position: absolute;
            width: 100%;
            height: auto;
            top: 87px;
            left: 0;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        #onboarding-image.visible {
            opacity: 1;
        }

        #onboarding-title {
            position: absolute;
            width: 90%;
            max-width: 359px;
            top: 475px;
            left: 50%;
            transform: translateX(-50%);
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            color: #0a0615;
            font-size: 27px;
            text-align: center;
            line-height: 2rem;
            white-space: pre-line;
            transition: opacity 0.3s ease-in-out;
        }

        .terms-text {
            position: absolute;
            width: 90%;
            max-width: 359px;
            top: 570px;
            left: 50%;
            transform: translateX(-50%);
            font-family: "Open Sans", sans-serif;
            font-weight: 600;
            color: #404b52;
            font-size: 1rem;
            text-align: center;
            line-height: 22px;
        }

        .pagination-container {
            position: absolute;
            top: 683px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .pagination-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background-color: #d9dfe7;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: all 0.3s ease-in-out;
        }

        .pagination-dot.active {
            background-color: var(--primary-color);
            width: 16px;
        }

        #next-button {
            position: absolute;
            width: 335px;
            max-width: 90%;
            height: 48px;
            top: 715px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 25px;
            background-color: var(--primary-color);
            box-shadow: 0px 6px 10px var(--primary-shadow-color);
            border: none;
            cursor: pointer;
            color: white;
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-size: 17px;
            text-align: center;
            line-height: 1.25rem;
        }

        .login-section {
            position: absolute;
            width: 100%;
            bottom: 7%;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 8px;
        }

        .login-prompt {
            display: flex;
            align-items: center;
            color: #404b52;
            font-size: 14px;
            line-height: 1.5rem;
        }

        .login-button {
            margin-left: 8px;
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            color: #262b30;
            font-size: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            text-decoration: none;
        }

        .bottom-line-container {
            width: 134px;
            height: 5px;
            background-color: black;
            border-radius: 100px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
<div class="frame">
    <div class="image-container">
        <img id="onboarding-image" alt="Açılış ekranı resmi" src="{{asset('img/sayfa1.png')}}" />
    </div>

    <h1 id="onboarding-title"></h1>

    <p class="terms-text">
        Devam ederek Gizlilik Bildirimimizi, Kullanım Koşullarımızı ve Abonelik
        Koşullarımızı kabul etmiş olursunuz
    </p>

    <div id="pagination-container" class="pagination-container"></div>

    <button id="next-button"></button>

    <div class="login-section">
        <div class="login-prompt">
            <span>Zaten hesabınız var mı?</span>
            <a href="{{ route('login') }}" class="login-button">Giriş Yap</a>
        </div>

    </div>
</div>

<script>
    window.sayfa2Url = "{{ route('sayfa2') }}";
    document.addEventListener("DOMContentLoaded", () => {
        const onboardingPages = [
            {
                title: "FIT CITY'E\nHOŞ GELDİNİZ",
                image: "{{asset('img/sayfa1.png')}}",
            },
            {
                title: "SPOR SALONLARI\nKEŞFEDİN",
                image: "{{asset('img/sayfa1.png')}}",
            },
            {
                title: "ANTRENMANLARI\nTAKİP EDİN",
                image: "{{asset('img/sayfa1.png')}}",
            },
        ];

        let currentPage = 0;

        const imageElement = document.getElementById("onboarding-image");
        const titleElement = document.getElementById("onboarding-title");
        const paginationContainer = document.getElementById(
            "pagination-container"
        );
        const nextButton = document.getElementById("next-button");

        function updatePage() {
            const pageData = onboardingPages[currentPage];

            imageElement.classList.remove("visible");

            setTimeout(() => {
                imageElement.src = pageData.image;
                titleElement.innerText = pageData.title;
                imageElement.classList.add("visible");
            }, 100);

            if (currentPage === onboardingPages.length - 1) {
                nextButton.innerText = "Hadi Gidelim";
            } else {
                nextButton.innerText = "Devam Et";
            }
            renderPagination();
        }

        function renderPagination() {
            paginationContainer.innerHTML = "";
            onboardingPages.forEach((_, index) => {
                const dot = document.createElement("button");
                dot.className = "pagination-dot";
                if (index === currentPage) {
                    dot.classList.add("active");
                }
                dot.setAttribute("aria-label", `Slayt ${index + 1}'e git`);
                dot.onclick = () => {
                    goToPage(index);
                };
                paginationContainer.appendChild(dot);
            });
        }

        function handleNext() {
            if (currentPage < onboardingPages.length - 1) {
                currentPage++;
                updatePage();
            } else {
                window.location.href = window.sayfa2Url;
            }
        }

        function goToPage(pageIndex) {
            currentPage = pageIndex;
            updatePage();
        }

        nextButton.addEventListener("click", handleNext);

        updatePage();
    });
</script>
</body>
</html>
