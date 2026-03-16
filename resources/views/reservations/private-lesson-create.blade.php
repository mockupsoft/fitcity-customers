<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel Ders Rezervasyonu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Özel Ders Rezervasyonu</h2>
    <p>
        <strong>Aktif Paketiniz:</strong>
        {{ $package->total_sessions }} Derslik Paket (Kalan Ders: {{ $package->remaining_sessions }})
    </p>

    <form method="POST" action="{{ route('reservations.private-lesson.store') }}">
        @csrf
        <input type="hidden" name="package_id" value="{{ $package->id }}">

        <div class="mb-3">
            <label for="trainer_id" class="form-label">Eğitmen Seçin</label>
            <select name="trainer_id" id="trainer_id" class="form-select" required>
                <option value="">Lütfen bir eğitmen seçin...</option>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lesson_date" class="form-label">Ders Tarihi</label>
            <input type="date" name="lesson_date" id="lesson_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Ders Saati</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required step="1800">
            <small class="form-text text-muted">Dersler 30 dakikalık aralıklarla seçilebilir.</small>
        </div>

        <button type="submit" class="btn btn-primary">Dersi Rezerve Et</button>
        <a href="{{ route('booking.calendar') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>

</body>
</html>
