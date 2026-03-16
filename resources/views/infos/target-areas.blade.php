<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hedef Bölgelerinizi Seçin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;900&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz olduğu gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; z-index: 10; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; margin: 0 auto; position: absolute; top: 66px; left: 50%; transform: translateX(-50%); }
        .main-title { color: #0a0615; font-size: 27px; font-family: "Poppins", sans-serif; font-weight: 700; line-height: 32px; text-align: center; padding: 0 25px; position: absolute; width: calc(100% - 50px); top: 137px; left: 50%; transform: translateX(-50%); }
        .human-figure-container { position: absolute; width: 227px; height: 597px; left: 14px; top: 143px; overflow: hidden; }
        .human-figure-img { width: 100%; height: 100%; object-fit: contain; position: absolute; left: 0; top: 0; z-index: 1; }
        .target-area-buttons { position: absolute; right: 16px; top: 229px; display: flex; flex-direction: column; gap: 10px; }
        .target-button { width: 94px; height: 41px; background-color: #31353b; border-radius: 20px; display: flex; justify-content: center; align-items: center; color: white; font-size: 12px; font-weight: 500; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease; border: none; }
        .target-button.selected { background-color: #fdfd10; color: #33373d; }
        .continue-button-container { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
    </style>
</head>
<body>
<form id="target-areas-form" method="POST" action="{{ route('infos.target-areas.store') }}" style="display: none;">
    @csrf
</form>

<div class="container-fluid app-container">
    <a href="{{ route('infos.habits') }}" class="back-button">
        <div class="icon"></div>
    </a>

    <div class="progress-bar-indicator"></div>
    <h1 class="main-title">Hedef bölgelerinizi seçin</h1>

    <div class="human-figure-container">
        <img class="human-figure-img" src="{{ asset('img/sayfa11.png') }}" alt="Human figure"/>
    </div>

    <div class="target-area-buttons">
        @php
            $targetAreas = ['Yüz', 'Boyun', 'Göğüsler', 'Silâh', 'Karın', 'Geri', 'Kalça', 'Bacaklar', 'Dizler'];
        @endphp

        @foreach($targetAreas as $area)
            @php
                $isSelected = in_array($area, $savedTargetAreas ?? []);
            @endphp
            <button type="button" class="target-button {{ $isSelected ? 'selected' : '' }}" data-value="{{ $area }}">
                {{ $area }}
            </button>
        @endforeach
    </div>

    <div class="continue-button-container">
        <a href="#" id="continue-btn" class="continue-button">Devam et</a>
    </div>


</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const targetButtons = document.querySelectorAll(".target-button");
        const continueBtn = document.getElementById("continue-btn");
        const hiddenForm = document.getElementById("target-areas-form");

        // Hedef bölge butonlarına tıklama olayı
        targetButtons.forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                this.classList.toggle("selected");
            });
        });

        // "Devam et" butonuna tıklama olayı
        continueBtn.addEventListener("click", function (event) {
            event.preventDefault();

            hiddenForm.innerHTML = '';
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            hiddenForm.appendChild(csrfInput);

            const selectedButtons = document.querySelectorAll(".target-button.selected");

            // Formu sadece en az bir seçim varsa gönder
            if (selectedButtons.length > 0) {
                selectedButtons.forEach(button => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'target_areas[]';
                    hiddenInput.value = button.dataset.value;
                    hiddenForm.appendChild(hiddenInput);
                });
                hiddenForm.submit();
            } else {
                // İsteğe bağlı: kullanıcıya bir seçim yapması gerektiğini belirten bir uyarı gösterebilirsiniz.
                alert('Lütfen en az bir hedef bölge seçiniz.');
            }
        });
    });
</script>
</body>
</html>
