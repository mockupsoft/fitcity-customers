{{-- reservations/measurement-create.blade.php --}}
<div class="container mt-5">
    <h2>Ölçüm Rezervasyonu Oluştur</h2>
    <p><strong>Ölçüm Hakkı:</strong> {{ $assignment->measurement->name }} (Son Tarih: {{ $assignment->expiration_date->format('d.m.Y') }})</p>

    <form method="POST" action="{{ route('reservations.measurement.store') }}">
        @csrf
        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

        <div class="mb-3">
            <label for="trainer_id" class="form-label">Eğitmen Seçin</label>
            <select name="trainer_id" id="trainer_id" class="form-select" required>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="reservation_date" class="form-label">Randevu Tarihi ve Saati</label>
            <input type="datetime-local" name="reservation_date" id="reservation_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Randevu Talebi Oluştur</button>
    </form>
</div>
