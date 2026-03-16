<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kötü Alışkanlıklar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;900&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz istediğiniz gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; text-decoration: none; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; margin: 0 auto; margin-top: 66px; }
        .title { color: #0a0615; font-size: 27px; font-weight: 600; text-align: center; margin-top: 10px; padding: 0 30px; }
        .subtitle { color: black; font-size: 14px; font-weight: 400; text-align: center; margin-top: 0; padding: 0 30px; }
        .habit-selection-container { display: flex; flex-direction: column; gap: 13px; margin-top: 30px; padding: 0 1rem; }
        .habit-item { display: flex; align-items: center; width: 100%; height: 68px; border-radius: 8px; border: 1px solid #dae0e8; cursor: pointer; transition: background-color 0.3s ease, border-color 0.3s ease; position: relative; }
        .habit-item.selected { background-color: #32363c; border-color: #32363c; color: white; }
        .habit-item:not(.selected) { background-color: white; color: black; }
        .habit-item .icon-wrapper { width: 52.87px; height: 52.89px; display: flex; justify-content: center; align-items: center; border-radius: 8px; margin-left: 7.55px; flex-shrink: 0; }
        .habit-item.selected .icon-wrapper { background-color: #32363c; }
        .habit-item:not(.selected) .icon-wrapper { background-color: #fff8df; }
        .habit-item .icon { font-size: 26px; line-height: 1; }
        .habit-item .text { flex-grow: 1; padding-left: 15px; font-size: 16px; font-weight: 500; line-height: 20px; }
        .habit-item.selected .text { color: white; }
        .habit-item .checkbox-wrapper { width: 20px; height: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); }
        .habit-item.selected .checkbox-wrapper { background: linear-gradient(90deg, #fdfc0e 0%, #fcfc10 100%); }
        .habit-item:not(.selected) .checkbox-wrapper { background: linear-gradient(90deg, #d2d2d2 0%, #d2d2d2 100%); }
        .habit-item .checkbox-wrapper::after { content: ""; display: none; width: 7.39px; height: 5.41px; border-bottom: 2px solid black; border-left: 2px solid black; transform: rotate(-45deg); position: absolute; }
        .habit-item.selected .checkbox-wrapper::after { display: block; }
        .continue-button-container { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
        .d-none { display: none; }
    </style>
</head>
<body>
<form id="habits-form" method="POST" action="{{ route('infos.habits.store') }}" style="display: none;">
    @csrf
</form>

<div class="container-fluid app-container">
    <a href="{{ route('infos.step-goal') }}" class="back-button">
        <div class="icon"></div>
    </a>

    <div class="progress-bar-indicator"></div>

    <h1 class="title">KÖTÜ ALIŞKANLIKLAR</h1>
    <p class="subtitle">Hepimizde biraz var; sizinki ne?</p>

    <main class="habit-selection-container">
        @php
            $habits = [
                'Yeterince dinlenemiyorum' => '😴',
                'Çikolatayı ve şekeri severim' => '🍬',
                'Soda benim en iyi arkadaşımdır' => '🥤',
                'Çok fazla tuzlu yiyecek tüketiyorum' => '🧂',
                'Gece yarısı atıştırmalıkları yerim' => '🌭',
                'Yukarıdakilerin hiçbiri' => '❌',
            ];
        @endphp

        @foreach($habits as $habit => $emoji)
            @php
                $isSelected = in_array($habit, $savedHabits ?? []);
            @endphp
            <div class="habit-item {{ $isSelected ? 'selected' : '' }}" data-value="{{ $habit }}">
                <input type="checkbox" name="bad_habits[]" value="{{ $habit }}" class="d-none" {{ $isSelected ? 'checked' : '' }}>
                <div class="icon-wrapper"><span class="icon">{{ $emoji }}</span></div>
                <div class="text">{{ $habit }}</div>
                <div class="checkbox-wrapper"></div>
            </div>
        @endforeach
    </main>

    <div class="continue-button-container">
        <a  id="continue-btn" class="continue-button">Devam et</a>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const allHabits = document.querySelectorAll(".habit-item");
        const continueBtn = document.getElementById('continue-btn');
        const hiddenForm = document.getElementById('habits-form');
        const noneOfTheAboveValue = 'Yukarıdakilerin hiçbiri';

        allHabits.forEach((item) => {
            item.addEventListener("click", function () {
                const checkbox = this.querySelector('input[type="checkbox"]');
                const isNoneOfTheAbove = this.dataset.value === noneOfTheAboveValue;

                if (isNoneOfTheAbove) {
                    // "Hiçbiri" tıklandıysa, durumunu değiştir ve diğerlerini temizle
                    const wasSelected = this.classList.contains('selected');

                    allHabits.forEach(el => {
                        el.classList.remove('selected');
                        el.querySelector('input[type="checkbox"]').checked = false;
                    });

                    if (!wasSelected) {
                        this.classList.add('selected');
                        checkbox.checked = true;
                    }

                } else {
                    // Başka bir öğe tıklandıysa, "Hiçbiri" seçimini kaldır
                    const noneOfTheAboveItem = document.querySelector(`[data-value="${noneOfTheAboveValue}"]`);
                    if (noneOfTheAboveItem && noneOfTheAboveItem.classList.contains('selected')) {
                        noneOfTheAboveItem.classList.remove('selected');
                        noneOfTheAboveItem.querySelector('input[type="checkbox"]').checked = false;
                    }

                    // Tıklanan öğenin durumunu değiştir
                    this.classList.toggle('selected');
                    checkbox.checked = this.classList.contains('selected');
                }
            });
        });

        continueBtn.addEventListener('click', function(event) {
            event.preventDefault();

            hiddenForm.innerHTML = ''; // Formu temizle
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            hiddenForm.appendChild(csrfInput);

            const selectedHabits = document.querySelectorAll('.habit-item.selected');

            selectedHabits.forEach(item => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'bad_habits[]';
                hiddenInput.value = item.dataset.value;
                hiddenForm.appendChild(hiddenInput);

            });

            hiddenForm.submit();
        });
    });
</script>
</body>
</html>
