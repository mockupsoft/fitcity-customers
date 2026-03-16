<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $program->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 15px; }
        .page-header { margin-top: 30px; margin-bottom: 10px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 600; }
        .page-subtitle { color: #9299a3; font-size: 16px; font-weight: 500; margin-bottom: 25px; }
        .day-divider { margin-top: 25px; margin-bottom: 15px; }
        .day-title { color: #0a0615; font-size: 20px; font-weight: 600; }
        .exercise-card { background-color: #f8fafc; border: 1px solid #e5e9ef; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
        .exercise-name { font-size: 1.1rem; font-weight: 600; color: #0a0615; }
        .exercise-details { font-size: 0.9rem; color: #404b52; }
        .video-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; justify-content: center; align-items: center; z-index: 2000; }
        .video-modal-overlay.active { display: flex; }
        .video-modal-content { background: white; padding: 20px; border-radius: 10px; width: 90%; max-width: 800px; position: relative; }
        .video-modal-close { position: absolute; top: -15px; right: -15px; background: white; border: none; border-radius: 50%; width: 30px; height: 30px; font-size: 20px; font-weight: bold; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .video-modal-content video { width: 100%; border-radius: 8px; }
        .video-modal-title { font-size: 1.2rem; font-weight: 600; margin-top: 10px; }

    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="p-3">
        <h1 class="mt-4">{{ $program->title }}</h1>
        <p class="text-muted">{{ $program->duration_weeks }} Haftalık Program</p>
        <hr>

        @forelse($weeklySchedule as $day => $exercises)
            <h3 class="day-header">{{ $day }}</h3>

            @foreach($exercises as $exercise)
                <div class="exercise-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="exercise-name">{{ $exercise['name'] }}</span>
                        {{-- Butona veri nitelikleri eklendi --}}
                        <button class="btn btn-sm btn-dark watch-video-btn"
                                data-video-url="{{ $exercise['video_url'] ?? '' }}"
                                data-name="{{ $exercise['name'] }}">
                            İzle
                        </button>
                    </div>
                    <hr class="my-2">
                    <div class="exercise-details">
                        <span><strong>Set:</strong> {{ $exercise['sets'] }}</span> |
                        <span><strong>Tekrar:</strong> {{ $exercise['reps'] }}</span> |
                        <span><strong>Dinlenme:</strong> {{ $exercise['rest'] }} sn</span>
                    </div>
                </div>
            @endforeach
        @empty
            <div class="text-center p-5">
                <p class="text-muted">Bu program için henüz antrenman eklenmemiş.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="videoModal" class="video-modal-overlay">
    <div class="video-modal-content">
        <button id="closeVideoModal" class="video-modal-close">&times;</button>
        <video id="modalVideoPlayer" controls autoplay>
            <source src="" type="video/mp4">
            Tarayıcınız video etiketini desteklemiyor.
        </video>
        <h3 id="modalVideoTitle" class="video-modal-title"></h3>
    </div>
</div>
    @include('bottom-nav')
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const watchButtons = document.querySelectorAll('.watch-video-btn');
        const modal = document.getElementById('videoModal');
        const modalVideoPlayer = document.getElementById('modalVideoPlayer');
        const modalVideoTitle = document.getElementById('modalVideoTitle');
        const closeModalBtn = document.getElementById('closeVideoModal');

        function openModal(videoUrl, videoName) {
            if (!videoUrl) {
                alert('Bu antrenman için video bulunamadı.');
                return;
            }
            modalVideoPlayer.querySelector('source').setAttribute('src', videoUrl);
            modalVideoPlayer.load();
            modalVideoTitle.textContent = videoName;
            modal.classList.add('active');
            modalVideoPlayer.play();
        }

        function closeModal() {
            modal.classList.remove('active');
            modalVideoPlayer.pause();
            modalVideoPlayer.querySelector('source').setAttribute('src', '');
        }

        watchButtons.forEach(button => {
            button.addEventListener('click', function () {
                const videoUrl = this.dataset.videoUrl;
                const videoName = this.dataset.name;
                openModal(videoUrl, videoName);
            });
        });

        closeModalBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
</body>
</html>
