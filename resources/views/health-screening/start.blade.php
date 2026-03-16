<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sağlık Taraması - PAR-Q</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
        .question-item { background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 15px; }
        .btn-primary { background-color: #D9376E; border-color: #D9376E; }
        .btn-primary:hover { background-color: #c33164; border-color: #c33164; }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h3 class="text-center mb-4 fw-bold">Fiziksel Aktivite Hazırlık Anketi (PAR-Q)</h3>
        <p class="text-muted text-center mb-4">Antrenmanlara başlamadan önce güvenliğiniz için lütfen aşağıdaki soruları dürüstçe cevaplayınız.</p>

        <form action="{{ route('health-screening.storeParq') }}" method="POST">
            @csrf

            <div class="question-item">
                <p class="mb-2 fw-bold">1. Doktorunuz hiç kalp rahatsızlığınız olduğunu ve sadece doktor tarafından önerilen fiziksel aktiviteleri yapmanız gerektiğini söyledi mi?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q1]" id="q1_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q1_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q1]" id="q1_no" value="no">
                    <label class="btn btn-outline-success" for="q1_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">2. Fiziksel aktivite sırasında göğsünüzde ağrı hissediyor musunuz?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q2]" id="q2_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q2_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q2]" id="q2_no" value="no">
                    <label class="btn btn-outline-success" for="q2_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">3. Son bir ay içinde fiziksel aktivite yapmadığınız zamanlarda göğüs ağrısı hissettiniz mi?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q3]" id="q3_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q3_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q3]" id="q3_no" value="no">
                    <label class="btn btn-outline-success" for="q3_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">4. Dengenizi kaybetmenize neden olan baş dönmesi hissediyor musunuz veya bilincinizi kaybettiğiniz oldu mu?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q4]" id="q4_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q4_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q4]" id="q4_no" value="no">
                    <label class="btn btn-outline-success" for="q4_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">5. Fiziksel aktivite değişikliği ile kötüleşebilecek bir kemik veya eklem probleminiz var mı?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q5]" id="q5_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q5_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q5]" id="q5_no" value="no">
                    <label class="btn btn-outline-success" for="q5_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">6. Şu anda tansiyon veya kalp rahatsızlığınız için ilaç kullanıyor musunuz?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q6]" id="q6_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q6_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q6]" id="q6_no" value="no">
                    <label class="btn btn-outline-success" for="q6_no">Hayır</label>
                </div>
            </div>

            <div class="question-item">
                <p class="mb-2 fw-bold">7. Fiziksel aktivite yapmamanız için bildiğiniz başka bir neden var mı?</p>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="answers[q7]" id="q7_yes" value="yes" required>
                    <label class="btn btn-outline-danger" for="q7_yes">Evet</label>
                    <input type="radio" class="btn-check" name="answers[q7]" id="q7_no" value="no">
                    <label class="btn btn-outline-success" for="q7_no">Hayır</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 mt-3 rounded-pill fw-bold">Devam Et</button>
        </form>
    </div>
</div>

</body>
</html>
