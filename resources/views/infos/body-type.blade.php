<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vücut Tipi Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        body { background-color: #f8f9fa; font-family: "Poppins", sans-serif; }
        .mobile-container { max-width: 490px; min-height: 100vh; margin: auto; background-color: #ffffff; display: flex; flex-direction: column; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
        .body-type-list { flex-grow: 1; overflow-y: auto; padding: 0 1rem; }
        .body-type-item { display: flex; align-items: center; width: 100%; height: 88px; border-radius: 8px; border: 1px solid #dae0e8; cursor: pointer; transition: background-color 0.3s ease, border-color 0.3s ease; position: relative; margin-bottom: 10px; padding: 0 15px; }
        .body-type-item.selected { background-color: #32363c; border-color: #32363c; color: white; }
        .body-type-item img { width: 60px; height: 60px; border-radius: 8px; flex-shrink: 0; }
        .body-type-item span { flex-grow: 1; padding-left: 20px; font-size: 16px; font-weight: 500; }
        .body-type-item .checkbox-wrapper { width: 20px; height: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); }
        .body-type-item.selected .checkbox-wrapper { background: linear-gradient(90deg, #fdfc0e 0%, #fcfc10 100%); }
        .body-type-item:not(.selected) .checkbox-wrapper { background: linear-gradient(90deg, #d2d2d2 0%, #d2d2d2 100%); }
        .body-type-item .checkbox-wrapper::after { content: ""; display: none; width: 7.39px; height: 5.41px; border-bottom: 2px solid black; border-left: 2px solid black; transform: rotate(-45deg); position: absolute; }
        .body-type-item.selected .checkbox-wrapper::after { display: block; }
        .continue-btn { font-weight: 900; font-size: 20px; padding-top: 0.6rem; padding-bottom: 0.6rem; box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border: none; }
        .d-none { display: none; }
    </style>
</head>
<body>
<div class="container-fluid mobile-container p-0">
    <form method="POST" action="{{ route('infos.body-type.store') }}" class="d-flex flex-column">
        @csrf

        <header class="text-center py-5 px-3">
            <h2 class="fw-bold" style="font-size: 27px">VÜCÜT TİPİNİZİ SEÇİN</h2>
        </header>

        <main class="body-type-list">
            @php
                $bodyTypes = [
                    'Skinny' => asset('img/sayfa5-1.png'),
                    'Regular' => asset('img/sayfa5-2.png'),
                    'Extra' => asset('img/sayfa5-3.png'),
                    'Overweight' => asset('img/sayfa5-4.png'),
                    'Obese' => asset('img/sayfa5-5.png'),
                ];
            @endphp

            @foreach ($bodyTypes as $type => $image)
                @php
                    $isSelected = ($type === $savedBodyType);
                @endphp
                <label
                    class="body-type-item {{ $isSelected ? 'selected' : '' }}"
                    for="body_type_{{ $type }}">

                    <input
                        type="radio"
                        name="body_type"
                        value="{{ $type }}"
                        id="body_type_{{ $type }}"
                        class="d-none"
                        {{ $isSelected ? 'checked' : '' }}>

                    <img src="{{ $image }}" alt="{{ $type }}" />
                    <span class="fw-medium ms-4">{{ $type }}</span>
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
        const items = document.querySelectorAll(".body-type-item");

        items.forEach((item) => {
            item.addEventListener("click", function () {
                items.forEach(el => el.classList.remove("selected"));
                this.classList.add("selected");

                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });
    });
</script>
</body>
</html>
