<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eğitmenler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;800&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 17px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 800; margin-bottom: 20px; margin-top: 30px; }
        .search-bar { width: 100%; height: 48px; background: #f1f4f8; border-radius: 8px; display: flex; align-items: center; padding: 0 15px; margin-bottom: 25px; }
        .search-bar .search-icon { font-size: 18px; color: #404b52; margin-right: 10px; }
        .search-bar .search-input { flex-grow: 1; border: none; background: transparent; color: #404b52; font-size: 14px; font-family: "Open Sans", sans-serif; outline: none; }
        .search-bar .search-input::placeholder { color: #404b52; opacity: 1; }
        .instructor-card { width: 100%; height: 80px; background: white; border-radius: 8px; border: 1px solid #e5e9ef; display: flex; align-items: center; padding: 8px 15px; margin-bottom: 10px; position: relative; text-decoration: none; }
        .instructor-card .profile-image { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; margin-right: 15px; }
        .instructor-card .text-content { flex-grow: 1; }
        .instructor-card .instructor-name { color: #0a0615; font-size: 16px; font-weight: 500; }
        .instructor-card .instructor-title { color: #404b52; font-size: 14px; font-family: "Open Sans", sans-serif; }
        .instructor-card .arrow-icon { color: #a9b2ba; font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="page-title">Eğitmenler</div>

        <div class="search-bar">
            <span class="search-icon">&#128269;</span>
            <input type="text" class="search-input" placeholder="Eğitmen Ara" />
        </div>

        <div class="instructor-cards-list">
            {{-- DİNAMİK VERİ: Eğitmenler Döngüsü --}}
            @forelse($trainers as $trainer)
                <a href="{{ route('trainers.show', $trainer) }}" class="instructor-card"> {{-- TODO: Eğitmen detay sayfası için link eklenecek --}}
                    <img class="profile-image" src="{{ $trainer->profile_photo ? asset('storage/'.$trainer->profile_photo) : asset('img/sayfa22.png') }}" alt="{{ $trainer->name }} Profil Resmi"/>
                    <div class="text-content">
                        <div class="instructor-name">{{ $trainer->name }}</div>
                        <div class="instructor-title">{{ $trainer->trainerDetails->specialization ?? 'Eğitmen' }}</div>
                    </div>
                    <span class="arrow-icon">&gt;</span>
                </a>
            @empty
                <p>Sistemde kayıtlı eğitmen bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
