<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $category->name }} Antrenmanları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 15px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 600; margin-bottom: 25px; margin-top: 30px; }
        .workout-row { display: flex; flex-wrap: wrap; gap: 16px; }
        .workout-card { flex: 1 1 calc(50% - 8px); min-width: 170px; text-decoration: none; color: inherit; cursor: pointer; } /* cursor:pointer eklendi */
        .workout-card .workout-image { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; background-color: #f1f4f8; }
        .workout-card .workout-title { color: #0a0615; font-size: 15px; font-weight: 500; line-height: 20px; margin-bottom: 4px; }
        .workout-card .workout-info { display: flex; align-items: center; gap: 4px; }
        .workout-card .workout-info .dot { width: 4px; height: 4px; background: #404b52; border-radius: 50%; }
        .workout-card .workout-duration { color: #404b52; font-size: 12px; font-family: "Open Sans", sans-serif; }

        /* YENİ MODAL STİLLERİ */
        .video-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .video-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .video-modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            position: relative;
        }
        .video-modal-close {
            position: absolute;
            top: -15px;
            right: -15px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .video-modal-content video {
            width: 100%;
            border-radius: 8px;
        }
        .video-modal-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="page-title">{{ $category->name }} Antrenmanları</div>

        <div class="workout-row">
            @forelse($workouts as $workout)
                {{-- Kartlar artık bir link değil, modal'ı tetikleyecek bir div --}}
                <div class="workout-card"
                     data-video-url="{{ $workout->video_url }}"
                     data-name="{{ $workout->name }}">

                    <img class="workout-image"
                         src="{{ $workout->muscle_group_image_url }}"
                         alt="{{ $workout->name }}"/>

                    <div class="workout-title">{{ $workout->name }}</div>

                    <div class="workout-info">
                        <div class="dot"></div>
                        <span class="workout-duration">
                            Süre: {{ $workout->duration_minutes }} dk
                        </span>
                    </div>
                </div>
            @empty
                <p>Bu kategoride henüz antrenman bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>

    @include('bottom-nav')
</div>

<!-- YENİ VİDEO MODAL YAPISI -->
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

<!-- YENİ JAVASCRIPT KODU -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const workoutCards = document.querySelectorAll('.workout-card');
        const modal = document.getElementById('videoModal');
        const modalVideoPlayer = document.getElementById('modalVideoPlayer');
        const modalVideoTitle = document.getElementById('modalVideoTitle');
        const closeModalBtn = document.getElementById('closeVideoModal');

        function openModal(videoUrl, videoName) {
            modalVideoPlayer.querySelector('source').setAttribute('src', videoUrl);
            modalVideoPlayer.load(); // Videoyu yeniden yükle
            modalVideoTitle.textContent = videoName;
            modal.classList.add('active');
            modalVideoPlayer.play(); // Videoyu otomatik başlat
        }

        function closeModal() {
            modal.classList.remove('active');
            modalVideoPlayer.pause(); // Modalı kapatınca videoyu durdur
            modalVideoPlayer.querySelector('source').setAttribute('src', ''); // Kaynağı temizle
        }

        workoutCards.forEach(card => {
            card.addEventListener('click', function () {
                const videoUrl = this.dataset.videoUrl;
                const videoName = this.dataset.name;
                if (videoUrl) {
                    openModal(videoUrl, videoName);
                }
            });
        });

        closeModalBtn.addEventListener('click', closeModal);

        // Modal'ın dışına tıklandığında kapat
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>

</body>
</html>
