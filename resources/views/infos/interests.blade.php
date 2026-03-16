<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>İlgi Alanları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        /* Stilleriniz olduğu gibi korunmuştur */
        body { background-color: #e9ecef; font-family: "Poppins", sans-serif; }
        .mobile-container { max-width: 490px; min-height: 100vh; margin: auto; background-color: #f8fafc; display: flex; flex-direction: column; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
        .interest-list { flex-grow: 1; overflow-y: auto; padding: 0 1rem; }
        .interest-item { display: flex; align-items: center; width: 100%; height: 68px; border-radius: 8px; border: 1px solid #dae0e8; cursor: pointer; transition: background-color 0.3s ease, border-color 0.3s ease; position: relative; margin-bottom: 10px; padding: 0 15px; }
        .interest-item.selected { background-color: #32363c; border-color: #32363c; color: white; }
        .interest-item img { width: 50px; height: 50px; border-radius: 8px; flex-shrink: 0; }
        .interest-item .fw-medium { flex-grow: 1; padding-left: 20px; font-size: 16px; font-weight: 500; }
        .interest-item .checkbox-wrapper { width: 20px; height: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); }
        .interest-item.selected .checkbox-wrapper { background: linear-gradient(90deg, #fdfc0e 0%, #fcfc10 100%); }
        .interest-item:not(.selected) .checkbox-wrapper { background: linear-gradient(90deg, #d2d2d2 0%, #d2d2d2 100%); }
        .interest-item .checkbox-wrapper::after { content: ""; display: none; width: 7.39px; height: 5.41px; border-bottom: 2px solid black; border-left: 2px solid black; transform: rotate(-45deg); position: absolute; }
        .interest-item.selected .checkbox-wrapper::after { display: block; }
        .continue-btn { font-weight: 900; font-size: 20px; padding-top: 0.6rem; padding-bottom: 0.6rem; box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border: none; }
        .d-none { display: none; }
    </style>
</head>
<body>
<div class="container-fluid mobile-container p-0">
    <form method="POST" action="{{ route('infos.interests.store') }}" class="d-flex flex-column h-100">
        @csrf

        <header class="text-center py-5 px-3">
            <h2 class="fw-bold" style="font-size: 27px">NE İLE İLGİLENİYORSUN</h2>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger mx-3">
                Lütfen devam etmek için en az bir ilgi alanı seçiniz.
            </div>
        @endif

        <main class="interest-list">
            @php
                $interests = [
                    'Antrenmanlar' => asset('img/sayfa4-0.png'),
                    'Yemek Planları' => asset('img/sayfa4-1.png'),
                    'Oruç' => asset('img/sayfa4-2.png'),
                    'Yürüyüş' => asset('img/sayfa4-3.png'),
                    'Yoga' => asset('img/sayfa4-4.png'),
                    'Yüz Germe' => asset('img/sayfa4-5.png'),
                ];
            @endphp

            @foreach($interests as $interest => $image)
                @php
                    $isSelected = in_array($interest, $savedInterests ?? []);
                @endphp
                <label
                    class="interest-item {{ $isSelected ? 'selected' : '' }}"
                    for="interest_{{ Str::slug($interest) }}">

                    <input
                        type="checkbox"
                        name="interests[]"
                        value="{{ $interest }}"
                        id="interest_{{ Str::slug($interest) }}"
                        class="d-none"
                        {{ $isSelected ? 'checked' : '' }}>

                    <img src="{{ $image }}" alt="{{ $interest }}" class="rounded" />
                    <span class="flex-grow-1 mx-3 fw-medium">{{ $interest }}</span>
                    <div class="checkbox-wrapper"></div>
                </label>
            @endforeach
        </main>

        <footer class="p-3 mt-auto">
            <button type="submit" class="btn btn-dark w-100 rounded-pill continue-btn">
                Devam et
            </button>
        </footer>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Doğrudan checkbox'ları seçiyoruz
        const checkboxes = document.querySelectorAll('.interest-item input[type="checkbox"]');

        checkboxes.forEach((checkbox) => {
            // Checkbox'ın durumu değiştiğinde (tıklandığında) çalışacak olay
            checkbox.addEventListener("change", function () {
                // Checkbox'ın kapsayıcısı olan label'ı buluyoruz
                const parentLabel = this.closest('.interest-item');

                if (parentLabel) {
                    // Label'ın 'selected' class'ını, checkbox'ın 'checked' durumuna göre ayarla.
                    // Eğer checkbox 'checked' ise 'selected' class'ını ekle, değilse kaldır.
                    parentLabel.classList.toggle('selected', this.checked);
                }
            });
        });
    });
</script>
</body>
</html>
