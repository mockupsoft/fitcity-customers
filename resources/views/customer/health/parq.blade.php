<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sağlık Taraması - PAR-Q</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
        .container { max-width: 600px; margin-top: 40px; margin-bottom: 40px; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; }
        .question-item { background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #edf2f7; margin-bottom: 20px; transition: transform 0.2s; }
        .question-item:hover { border-color: #cbd5e0; }
        .question-text { font-weight: 600; color: #2d3748; margin-bottom: 12px; font-size: 15px; }
        .btn-check:checked + .btn-outline-danger { background-color: #e53e3e; color: white; border-color: #e53e3e; }
        .btn-check:checked + .btn-outline-success { background-color: #48bb78; color: white; border-color: #48bb78; }
        .submit-btn { background-color: #282d32; color: white; padding: 12px; border-radius: 25px; font-weight: 600; width: 100%; border: none; transition: background 0.3s; }
        .submit-btn:hover { background-color: #1a202c; }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #2d3748;">Sağlık Kontrolü</h2>
        <p class="text-muted">Güvenliğiniz için lütfen aşağıdaki 7 soruyu dürüstçe cevaplayınız.</p>
    </div>

    <form action="{{ route('health-screening.storeParq') }}" method="POST">
        @csrf

        <div class="card">
            @foreach([
                1 => 'Doktorunuz hiç kalp rahatsızlığınız olduğunu ve sadece doktor tarafından önerilen fiziksel aktiviteleri yapmanız gerektiğini söyledi mi?',
                2 => 'Fiziksel aktivite sırasında göğsünüzde ağrı hissediyor musunuz?',
                3 => 'Son bir ay içinde fiziksel aktivite yapmadığınız zamanlarda göğüs ağrısı hissettiniz mi?',
                4 => 'Dengenizi kaybetmenize neden olan baş dönmesi hissediyor musunuz veya bilincinizi kaybettiğiniz oldu mu?',
                5 => 'Fiziksel aktivite değişikliği ile kötüleşebilecek bir kemik veya eklem probleminiz var mı?',
                6 => 'Şu anda tansiyon veya kalp rahatsızlığınız için ilaç kullanıyor musunuz?',
                7 => 'Fiziksel aktivite yapmamanız için bildiğiniz başka bir neden var mı?'
            ] as $key => $question)
                <div class="question-item">
                    <p class="question-text">{{ $key }}. {{ $question }}</p>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="answers[q{{ $key }}]" id="q{{ $key }}_yes" value="yes" required>
                        <label class="btn btn-outline-danger" for="q{{ $key }}_yes">Evet</label>

                        <input type="radio" class="btn-check" name="answers[q{{ $key }}]" id="q{{ $key }}_no" value="no" required>
                        <label class="btn btn-outline-success" for="q{{ $key }}_no">Hayır</label>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="submit-btn mt-3">Devam Et</button>
        </div>
    </form>
</div>

</body>
</html>
