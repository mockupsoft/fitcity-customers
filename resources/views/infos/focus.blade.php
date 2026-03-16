<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Odak Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz istediğiniz gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; cursor: pointer; text-decoration: none; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; margin: 0 auto; margin-top: 66px; }
        .title { color: #0a0615; font-size: 27px; font-weight: 600; text-align: center; margin-top: 80px; padding: 0 30px; }
        .focus-options { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-top: 50px; padding: 0 20px; }
        .focus-option-btn { background-color: #34383e; color: white; border-radius: 20px; padding: 8px 21px; font-size: 12px; font-weight: 500; text-align: center; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease; border: none; }
        .focus-option-btn.selected { background-color: #ffeb3b; color: black; }
        .continue-button-container { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
    </style>
</head>
<body>
<form id="focus-form" method="POST" action="{{ route('infos.focus.store') }}" style="display: none;">
    @csrf
</form>

<div class="container-fluid app-container p-0">
    <a href="{{ route('infos.body-type') }}" class="back-button">
        <div class="icon"></div>
    </a>


    <h1 class="title">ODAĞINIZI SEÇİN</h1>

    <main class="focus-options">
        @php
            $focusAreas = ['Vücut Şekillendirme', 'Enerji Artışı', 'Hareketlilik', 'Libido Artışı', 'Kas Kazancı', 'Tutarlılık', 'Daha İyi Şekil', 'Kalp Sağlığı'];
        @endphp

        @foreach ($focusAreas as $area)
            @php
                $isSelected = in_array($area, $savedFocusAreas ?? []);
            @endphp
            <a  class="focus-option-btn {{ $isSelected ? 'selected' : '' }}" data-value="{{ $area }}">
                {{ $area }}
            </a>
        @endforeach
    </main>

    <div class="continue-button-container">
        <a id="continue-btn" class="continue-button">
            Devam et
        </a>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".focus-option-btn");
        const continueBtn = document.getElementById("continue-btn");
        const hiddenForm = document.getElementById("focus-form");

        // Odak alanı butonlarına tıklama olayı
        items.forEach((item) => {
            item.addEventListener("click", function (event) {
                event.preventDefault(); // a etiketinin varsayılan davranışını engelle
                this.classList.toggle("selected");
            });
        });

        // "Devam et" butonuna tıklama olayı
        continueBtn.addEventListener("click", function (event) {
            event.preventDefault(); // a etiketinin varsayılan davranışını engelle

            // Formu her seferinde temizle
            hiddenForm.innerHTML = '';

            // CSRF token'ını tekrar ekle (innerHTML ile silindiği için)
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            hiddenForm.appendChild(csrfInput);

            // Seçili olan tüm butonları bul
            const selectedItems = document.querySelectorAll(".focus-option-btn.selected");

            // Her bir seçili buton için gizli forma bir input ekle
            selectedItems.forEach(item => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'focus_areas[]';
                hiddenInput.value = item.dataset.value; // data-value'dan değeri al
                hiddenForm.appendChild(hiddenInput);
            });

            // Gizli formu gönder
            hiddenForm.submit();
        });
    });
</script>
</body>
</html>
