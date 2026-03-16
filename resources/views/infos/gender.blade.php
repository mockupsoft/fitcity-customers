<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cinsiyet Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        /* Stillerinizde değişiklik yapmadım, aynen kopyalandı */
        body { background-color: #e9ecef; font-family: "Poppins", sans-serif; }
        .mobile-container { max-width: 490px; min-height: 100vh; margin: auto; background-color: #f8fafc; display: flex; flex-direction: column; padding: 1.5rem; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
        .habit-item { display: flex; align-items: center; width: 100%; height: 68px; border-radius: 8px; border: 1px solid #dae0e8; cursor: pointer; transition: background-color 0.3s ease, border-color 0.3s ease; position: relative; margin-bottom: 10px; }
        .habit-item.selected { background-color: #32363c; border-color: #32363c; color: white; }
        .habit-item:not(.selected) { background-color: white; color: black; }
        .habit-item .icon-wrapper { width: 52.87px; height: 52.89px; display: flex; justify-content: center; align-items: center; border-radius: 8px; margin-left: 7.55px; flex-shrink: 0; }
        .habit-item.selected .icon-wrapper { background-color: #32363c; }
        .habit-item:not(.selected) .icon-wrapper { background-color: #fff8df; }
        .habit-item .icon { font-size: 26px; line-height: 1; }
        .habit-item .text { flex-grow: 1; padding-left: 20px; font-size: 16px; font-weight: 500; }
        .habit-item .checkbox-wrapper { width: 20px; height: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); }
        .habit-item.selected .checkbox-wrapper { background: linear-gradient(90deg, #fdfc0e 0%, #fcfc10 100%); }
        .habit-item:not(.selected) .checkbox-wrapper { background: #d2d2d2; }
        .habit-item .checkbox-wrapper::after { content: ""; display: none; width: 7.39px; height: 5.41px; border-bottom: 2px solid black; border-left: 2px solid black; transform: rotate(-45deg); position: absolute; }
        .habit-item.selected .checkbox-wrapper::after { display: block; }
        .continue-btn { font-weight: 900; font-size: 20px; padding-top: 0.7rem; padding-bottom: 0.7rem; box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); }
        .d-none { display: none; } /* Gizli radio butonları için */
    </style>
</head>
<body>
<div class="container mobile-container">
    <header class="text-center" style="margin-top: 6rem; margin-bottom: 2rem">
        <h2 class="fw-bold" style="font-size: 27px">CİNSİYET SEÇİN</h2>
    </header>

    <form method="POST" action="{{ route('infos.gender.store') }}" class="flex-grow-1 w-100">
        @csrf

        @error('gender')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <main>
            <label class="habit-item selected" for="gender_female">
                <input type="radio" name="gender" value="female" id="gender_female" class="d-none" checked>
                <div class="icon-wrapper"><span class="icon">👩</span></div>
                <div class="text">Kadın</div>
                <div class="checkbox-wrapper"></div>
            </label>

            <label class="habit-item" for="gender_male">
                <input type="radio" name="gender" value="male" id="gender_male" class="d-none">
                <div class="icon-wrapper"><span class="icon">👨</span></div>
                <div class="text">Erkek</div>
                <div class="checkbox-wrapper"></div>
            </label>

            <label class="habit-item" for="gender_other">
                <input type="radio" name="gender" value="other" id="gender_other" class="d-none">
                <div class="icon-wrapper"><span class="icon">❓</span></div>
                <div class="text">Belirtmemeyi Tercih Ediyorum</div>
                <div class="checkbox-wrapper"></div>
            </label>
        </main>

        <footer class="mt-auto">
            <button type="submit" class="btn btn-dark w-100 rounded-pill continue-btn">
                Devam et
            </button>
        </footer>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels = document.querySelectorAll(".habit-item");

        labels.forEach((label) => {
            label.addEventListener("click", function () {
                // Tüm labellardan 'selected' class'ını kaldır
                labels.forEach((el) => el.classList.remove("selected"));
                // Sadece tıklanan label'a 'selected' class'ını ekle
                this.classList.add("selected");

                // İlişkili radio butonu manuel olarak seçili hale getir (label zaten yapıyor ama bu garanti yöntem)
                const radio = this.querySelector('input[type="radio"]');
                if(radio) {
                    radio.checked = true;
                }
            });
        });
    });
</script>
</body>
</html>
