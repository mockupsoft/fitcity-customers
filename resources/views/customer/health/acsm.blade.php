<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACSM Risk Analizi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
        .container { max-width: 600px; margin-top: 40px; padding-bottom: 60px; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; }
        .section-title { color: #282d32; font-weight: 700; font-size: 18px; margin: 20px 0 15px 0; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; }
        .form-check { background: #fff; padding: 12px 12px 12px 40px; border: 1px solid #edf2f7; border-radius: 10px; margin-bottom: 10px; transition: all 0.2s; }
        .form-check:hover { border-color: #cbd5e0; background-color: #f7fafc; }
        .form-check-input { width: 1.3em; height: 1.3em; margin-left: -1.8em; margin-top: 0.1em; cursor: pointer; }
        .form-check-label { cursor: pointer; width: 100%; font-weight: 500; color: #4a5568; font-size: 14px; }
        .form-check-input:checked + .form-check-label { color: #2d3748; font-weight: 600; }
        .submit-btn { background-color: #282d32; color: white; padding: 15px; border-radius: 25px; font-weight: 600; width: 100%; border: none; font-size: 16px; transition: background 0.3s; }
        .submit-btn:hover { background-color: #1a202c; }
        .positive-factor { border-color: #c6f6d5; background-color: #f0fff4; }
        .positive-factor:hover { border-color: #9ae6b4; background-color: #e6fffa; }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #2d3748;">Risk Analizi</h2>
        <p class="text-muted">Size en uygun ve güvenli antrenman programını hazırlamak için bu bilgilere ihtiyacımız var.</p>
    </div>

    <form action="{{ route('health-screening.storeAcsm') }}" method="POST">
        @csrf

        <div class="card">
            <div class="section-title mt-0">1. Kronik Rahatsızlıklar</div>
            <p class="text-muted small mb-3">Aşağıdakilerden herhangi biri sizde var mı?</p>

            @foreach([
                'has_cardiovascular_disease' => 'Kalp ve Damar Hastalıkları',
                'has_metabolic_disease' => 'Metabolik Hastalıklar (Diyabet, Tiroid vb.)',
                'has_renal_disease' => 'Böbrek Hastalıkları',
                'has_respiratory_disease' => 'Solunum Yolu Hastalıkları (Astım, KOAH vb.)',
                'has_neurological_disease' => 'Nörolojik Hastalıklar (Alzheimer, Demans vb.)',
                'has_cancer' => 'Kanser Türleri'
            ] as $name => $label)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1">
                    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
                </div>
            @endforeach

            <div class="section-title">2. Risk Faktörleri</div>
            <p class="text-muted small mb-3">Geçerli olanları işaretleyiniz:</p>

            @foreach([
                'is_smoker' => 'Sigara kullanıyorum veya son 6 ay içinde bıraktım.',
                'is_sedentary' => 'Hareketsizim (Haftada 3 gün, 30 dk\'dan az aktivite).',
                'family_history' => 'Ailemde erken yaşta kalp krizi/ani ölüm öyküsü var.',
                'obesity' => 'Obezite (Vücut Kitle İndeksi > 30).',
                'hypertension' => 'Hipertansiyon (Yüksek Tansiyon).',
                'dyslipidemia' => 'Dislipidemi (Yüksek Kolesterol).',
                'prediabetes' => 'Prediyabet (Gizli Şeker).'
            ] as $name => $label)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1">
                    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
                </div>
            @endforeach

            <div class="section-title text-success" style="border-color: #c6f6d5;">3. Pozitif Faktör (İsteğe Bağlı)</div>
            <div class="form-check positive-factor">
                <input class="form-check-input" type="checkbox" name="high_hdl" id="high_hdl" value="1">
                <label class="form-check-label text-success" for="high_hdl">HDL (İyi) Kolesterolüm 60 mg/dL veya üzerinde.</label>
            </div>

            <button type="submit" class="submit-btn mt-4">Analizi Tamamla ve Başla</button>
        </div>
    </form>
</div>

</body>
</html>
