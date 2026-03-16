
<!DOCTYPE html>

<html lang="tr">

<head>


    <meta charset="UTF-8" />

    <title>Fitness Planınız</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>

    <style>

        /* CSS stilleri aynı kalır */

        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }

        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; padding-top: 0; }

        .top-background { width: 100%; height: 304px; position: absolute; top: 0; left: 0; overflow: hidden; background: linear-gradient(77deg, rgba(120, 108, 255, 0.5) 0%, rgba(90, 200, 250, 0.4) 100%); }

        .top-background::before { content: ""; position: absolute; width: 222px; height: 174px; left: 84px; top: 69px; background: #282d32; z-index: 1; }

        .main-content-card { width: 100%; min-height: 540px; background: white; border-top-left-radius: 24px; border-top-right-radius: 24px; position: absolute; top: 304px; left: 0; overflow: hidden; padding: 24px 16px; box-sizing: border-box; z-index: 2; }

        .main-title { color: #0a0615; font-size: 27px; font-weight: 600; text-align: center; margin-bottom: 8px; }

        .subtitle-text { color: #0a0615; font-size: 16px; font-family: "Open Sans", sans-serif; line-height: 22px; text-align: center; margin-bottom: 30px; }

        .feature-list { list-style: none; padding: 0; margin-bottom: 30px; }

        .feature-item { display: flex; align-items: center; margin-bottom: 8px; }

        .feature-icon { width: 15px; height: 16px; background: #282d32; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin-right: 8px; flex-shrink: 0; }

        .feature-icon::after { content: "✓"; color: white; font-size: 10px; }

        .feature-text { color: #0a0615; font-size: 14px; font-family: "Open Sans", sans-serif; line-height: 18px; }

        .subscription-options { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 30px; }

        /* DEĞİŞİKLİK: Kartları tıklanabilir yapmak için label'a cursor:pointer eklendi */

        .subscription-card { cursor: pointer; flex: 1; background: white; border-radius: 8px; border: 1px solid #e5e9ef; padding: 16px 10px; display: flex; flex-direction: column; align-items: center; text-align: center; min-height: 104px; box-sizing: border-box; position: relative; overflow: hidden; }

        .subscription-card.selected { border: 2px solid #282d32; } /* Border kalınlaştırıldı */

        .subscription-card .type { color: #0a0615; font-size: 16px; font-weight: 400; margin-bottom: 8px; }

        .subscription-card .price { color: #0a0615; font-size: 20px; font-weight: 600; margin-bottom: 4px; }

        .subscription-card .duration { color: #404b52; font-size: 12px; font-family: "Open Sans", sans-serif; }

        .save-tag { position: absolute; top: 0; right: 0; background: linear-gradient(77deg, rgba(120, 108, 255, 0.5) 0%, rgba(90, 200, 250, 0.4) 100%); border-radius: 0 8px 0 8px; padding: 2px 8px; color: #282d32; font-size: 8px; font-weight: 400; height: 16px; }

        .bottom-text { color: #404b52; font-size: 12px; font-family: "Open Sans", sans-serif; line-height: 18px; text-align: center; margin-bottom: 20px; padding: 0 10px; }

        .continue-button-container { width: 100%; }

        .continue-button { width: 100%; height: 48px; background: #34383f; box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 17px; font-weight: 500; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }

        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; z-index: 3; }

        .d-none { display: none; }
        .accordion-button { font-weight: 600; }
        .accordion-body { padding: 0; }
        .accordion-button:not(.collapsed) { background-color: #f1f4f8; color: #0a0615; }
        .hidden { display: none; }
    </style>

</head>

<body>

<div class="container-fluid app-container">

    <div class="top-background"></div>



    <div class="main-content-card">

        <h1 class="main-title">Millions of Users’ Choice</h1>

        <p class="subtitle-text">

            We believe that our app should inspire you<br />to be the best version

            of yourself

        </p>



        <ul class="feature-list">

            {{-- Feature list aynı kalır --}}

            <li class="feature-item">

                <div class="feature-icon"></div>

                <span class="feature-text">Professional videos with coaches</span>

            </li>

            <li class="feature-item">

                <div class="feature-icon"></div>

                <span class="feature-text">Over 100 ready-made workouts</span>

            </li>

            <li class="feature-item">

                <div class="feature-icon"></div>

                <span class="feature-text">Create your personal training plan</span>

            </li>

            <li class="feature-item">

                <div class="feature-icon"></div>

                <span class="feature-text">Without advertising</span>

            </li>

        </ul>



        <form id="subscription-form" method="POST" action="{{ route('payment.initiate') }}" enctype="multipart/form-data">
            @csrf

            {{-- ANA PAKETLER --}}
            <div class="subscription-options">
                @foreach($mainPackages as $package)
                    <label class="subscription-card" data-package-id="{{ $package->id }}" data-package-name="{{ $package->name }}">
                        <input type="radio" name="package_id" value="{{ $package->id }}" class="d-none">
                        <div class="type">{{ Str::contains($package->name, '1 Ay') ? 'Aylık' : 'Yıllık' }}</div>
                        <div class="price">{{ number_format($package->price, 0, ',', '.') }} TL</div>
                        <div class="duration">{{ Str::contains($package->name, '1 Ay') ? 'her ay' : 'her yıl' }}</div>
                        @if(Str::contains($package->name, '12 Ay'))
                            <div class="save-tag">Tasarruf Edin</div>
                        @endif
                    </label>
                @endforeach
            </div>

            {{-- DİĞER SEÇENEKLER (AKORDİYON) --}}
            <div class="accordion" id="otherOptionsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Diğer Seçenekler
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#otherOptionsAccordion">
                        <div class="accordion-body">
                            <div class="subscription-options flex-column align-items-center mt-3">
                                @foreach($otherPackages as $package)
                                    <label class="subscription-card w-100 mb-3" data-package-id="{{ $package->id }}" data-package-name="{{ $package->name }}">
                                        <input type="radio" name="package_id" value="{{ $package->id }}" class="d-none">
                                        <div class="type">{{ $package->name }}</div>
                                        <div class="price">{{ number_format($package->price, 0, ',', '.') }} TL</div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Belge yükleme alanı (başlangıçta gizli) --}}
            <div id="document-upload-section" class="mt-3 hidden">
                <label for="document" id="document-label" class="form-label"></label>
                <input type="file" name="document" id="document-input" class="form-control">
            </div>

            <div class="continue-button-container mt-4">
                <button type="submit" class="continue-button">Ödemeye Geç</button>
            </div>
        </form>

    </div>



</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const subscriptionCards = document.querySelectorAll('.subscription-card');
        const documentUploadSection = document.getElementById('document-upload-section');
        const documentLabel = document.getElementById('document-label');
        const documentInput = document.getElementById('document-input');

        // Varsayılan olarak ilk ana paketi seçili yap
        const firstMainCard = document.querySelector('.subscription-options .subscription-card');
        if(firstMainCard) {
            firstMainCard.classList.add('selected');
            firstMainCard.querySelector('input[type="radio"]').checked = true;
        }

        subscriptionCards.forEach(card => {
            card.addEventListener('click', function () {
                // Seçim mantığı
                subscriptionCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }

                // Belge yükleme mantığı
                const packageName = this.dataset.packageName.toLowerCase();
                documentUploadSection.classList.add('hidden');
                documentInput.required = false;

                if (packageName.includes('öğrenci')) {
                    documentLabel.textContent = 'Lütfen Öğrenci Belgenizi Yükleyin (.pdf, .jpg)';
                    documentInput.required = true;
                    documentUploadSection.classList.remove('hidden');
                } else if (packageName.includes('aile')) {
                    documentLabel.textContent = 'Lütfen Evlilik Cüzdanı Yükleyin (.pdf, .jpg)';
                    documentInput.required = true;
                    documentUploadSection.classList.remove('hidden');
                }
            });
        });
    });
</script>
</body>

</html>

