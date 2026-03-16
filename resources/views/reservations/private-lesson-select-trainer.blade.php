<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eğitmen Seçimi - Özel Ders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;800&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 17px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 800; margin-bottom: 10px; margin-top: 30px; }
        .page-subtitle { font-size: 16px; color: #404b52; margin-bottom: 25px;}
        .instructor-card { width: 100%; height: 80px; background: white; border-radius: 8px; border: 1px solid #e5e9ef; display: flex; align-items: center; padding: 8px 15px; margin-bottom: 10px; position: relative; text-decoration: none; cursor: pointer; }
        .instructor-card .profile-image { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; margin-right: 15px; }
        .instructor-card .text-content { flex-grow: 1; }
        .instructor-card .instructor-name { color: #0a0615; font-size: 16px; font-weight: 500; }
        .instructor-card .instructor-title { color: #404b52; font-size: 14px; font-family: "Open Sans", sans-serif; }
        .instructor-card .arrow-icon { color: #a9b2ba; font-size: 20px; font-weight: bold; }
        /* Modal Stilleri */
        .modal { display: none; position: fixed; z-index: 1055; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal.is-active { display: flex; align-items: center; justify-content: center; }
        .modal-content { background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; padding-bottom: 0.5rem; margin-bottom: 1rem;}
        .modal-title { font-size: 1.25rem; font-weight: 600; }
        .close-button { border: none; background: none; font-size: 1.5rem; cursor: pointer; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="page-title">Eğitmen Seçin</div>
        <p class="page-subtitle"><strong>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y, l') }}</strong> tarihi için özel ders eğitmeni seçin.</p>


        <div class="instructor-cards-list">
            @forelse($trainers as $trainer)
                <div class="instructor-card" data-trainer-id="{{ $trainer->id }}" data-trainer-name="{{ $trainer->name }}">
                    <img class="profile-image" src="{{ $trainer->profile_photo ? asset('storage/'.$trainer->profile_photo) : asset('img/sayfa22.png') }}" alt="{{ $trainer->name }} Profil Resmi"/>
                    <div class="text-content">
                        <div class="instructor-name">{{ $trainer->name }}</div>
                        <div class="instructor-title">{{ $trainer->trainerDetails->specialization ?? 'Eğitmen' }}</div>
                    </div>
                    <span class="arrow-icon">&gt;</span>
                </div>
            @empty
                <p>Sistemde kayıtlı eğitmen bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>
    @include('bottom-nav')
</div>

<div id="timeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Saat Seçin</h5>
            <button type="button" class="close-button" id="closeModalBtn">×</button>
        </div>
        <form action="{{ route('reservations.private-lesson.store') }}" method="POST">
            @csrf
            <input type="hidden" name="lesson_date" value="{{ $selectedDate }}">
            <input type="hidden" name="trainer_id" id="modal_trainer_id">


            <div class="mb-3">
                <label for="start_time" class="form-label">Uygun bir saat seçiniz:</label>
                <input type="time" name="start_time" id="start_time" class="form-control" required step="1800">
                <small class="form-text text-muted">Randevular 30 dakikalık aralıklarla seçilebilir.</small>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Randevuyu Onayla</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const trainerCards = document.querySelectorAll('.instructor-card');
        const modal = document.getElementById('timeModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalTrainerIdInput = document.getElementById('modal_trainer_id');
        const modalTitle = document.getElementById('modalTitle');

        function openModal(trainerId, trainerName) {
            modalTrainerIdInput.value = trainerId;
            modalTitle.textContent = trainerName + ' için saat seçin';
            modal.classList.add('is-active');
        }

        function closeModal() {
            modal.classList.remove('is-active');
        }

        trainerCards.forEach(card => {
            card.addEventListener('click', function() {
                const trainerId = this.dataset.trainerId;
                const trainerName = this.dataset.trainerName;
                openModal(trainerId, trainerName);
            });
        });

        closeModalBtn.addEventListener('click', closeModal);
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                closeModal();
            }
        });
    });
</script>
</body>
</html>
