<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ana Sayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Open+Sans:wght@400;800&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz olduğu gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 19px; box-sizing: border-box; }
        .top-bar-content { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .greeting { color: #0a0615; font-size: 19px; font-weight: 600; }
        .header-icons { display: flex; gap: 8px; }
        .header-icon-box { width: 40px; height: 40px; background: white; border-radius: 8px; border: 1px solid #e5e9ef; display: flex; justify-content: center; align-items: center; }
        .header-icon-box img { width: 24px; height: 24px; }
        .subtitle { color: black; font-size: 16px; font-weight: 300; margin-bottom: 20px; }
        .daily-schedule-scroller { display: flex; overflow-x: auto; gap: 4px; padding-bottom: 15px; margin-bottom: 20px; scrollbar-width: none; }
        .daily-schedule-scroller::-webkit-scrollbar { display: none; }
        .date-card { flex-shrink: 0; width: 40px; height: 72px; background: #f1f4f8; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; }
        .date-card.selected { background: #282d32; border-radius: 8px; }
        .date-card .day-letter { color: #282d32; font-size: 20px; font-weight: 500; }
        .date-card.selected .day-letter { color: white; }
        .date-card .day-number { color: #9299a3; font-size: 14px; margin-top: -5px; }
        .date-card.selected .day-number { color: #e5e9ef; }
        .target-level-card { flex-shrink: 0; width: 80px; height: 72px; background: #f1f4f8; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; margin-left: auto; }
        .target-level-card .target-text, .target-level-card .target-value, .target-level-card .level-label, .target-level-card .level-value { color: black; line-height: 1.2; }
        .target-level-card .target-text { font-size: 14px; font-weight: 800; }
        .target-level-card .target-value { font-size: 14px; font-weight: 600; }
        .target-level-card .level-label { font-size: 12px; font-weight: 500; }
        .target-level-card .level-value { font-size: 12px; font-weight: 700; }
        .location-cards-row { display: flex; gap: 12px; margin-bottom: 30px; }
        .location-card { flex: 1; border-radius: 8px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); overflow: hidden; position: relative; display: flex; justify-content: center; align-items: center; color: white; font-size: 24px; font-weight: 800; text-align: center; text-decoration: none;}
        .location-card.club { height: 274px; }
        .location-card.home, .location-card.outside { height: 130px; }
        .location-card img { position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .location-card .overlay-text { position: relative; z-index: 2; text-shadow: 1px 1px 3px rgba(0,0,0,0.5); }
        .categories-section, .featured-section, .trainers-section, .group-classes-section { margin-bottom: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 15px; }
        .section-title { color: #0a0615; font-size: 20px; font-weight: 500; }
        .section-view-all { color: #9299a3; font-size: 15px; font-weight: 500; text-decoration: none; }
        .category-cards, .featured-cards { display: flex; overflow-x: auto; gap: 12px; padding-bottom: 10px; scrollbar-width: none; }
        .category-cards::-webkit-scrollbar, .featured-cards::-webkit-scrollbar { display: none; }
        .category-card { flex-shrink: 0; width: 80px; height: 80px; background: white; border-radius: 8px; border: 1px solid #dae0e8; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; text-decoration: none; }
        .category-card img { width: 24px; height: 24px; margin-bottom: 5px; }
        .category-card .category-name { color: #0a0615; font-size: 14px; font-weight: 500; line-height: 1.2; }
        .featured-card { flex-shrink: 0; width: 240px; height: 216px; border-radius: 8px; position: relative; overflow: hidden; text-decoration: none; }
        .featured-card img { width: 100%; height: 160px; object-fit: cover; }
        .featured-card .featured-text { position: absolute; bottom: 0; left: 0; width: 100%; padding: 8px; background: white; color: black; font-size: 12px; font-weight: 600; height: 56px; display: flex; align-items: center; border-top: 1px solid #eee; }
        .trainers-booking-section { display: flex; gap: 12px; margin-bottom: 30px; }
        .trainers-card, .booking-card { flex: 1; height: 216px; border-radius: 5px; position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center; text-align: center; color: white; font-size: 24px; font-family: "Open Sans", sans-serif; font-weight: 800; line-height: 26px; text-decoration: none; }
        .trainers-card img, .booking-card img { position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .trainers-card .overlay-text, .booking-card .overlay-text { position: relative; z-index: 2; padding: 10px; text-shadow: 1px 1px 3px rgba(0,0,0,0.5); }
        .booking-card .overlay-text { font-size: 19px; }
        .group-classes-card { width: 100%; height: 207px; border-radius: 5px; position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center; text-align: center; color: white; font-size: 25px; font-family: "Open Sans", sans-serif; font-weight: 800; line-height: 26px; text-decoration: none; }
        .group-classes-card img { position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .group-classes-card .overlay-text { position: relative; z-index: 2; text-shadow: 1px 1px 3px rgba(0,0,0,0.5); }
        .notification-bell {
            position: relative;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            color: #404B52;
        }
        .notification-count {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #D9376E; /* Ana renk */
            color: white;
            border-radius: 50%;
            padding: 1px 5px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid white;
        }
        .notifications-dropdown {
            display: none;
            position: absolute;
            top: 50px; /* Header'ın biraz altına */
            right: 0;
            background: white;
            border: 1px solid #e5e9ef;
            border-radius: 8px;
            width: 320px; /* Genişlik ayarlandı */
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f4f8;
            font-size: 14px;
        }
        .notification-item:last-child { border-bottom: none; }
        .notification-item.unread {
            background-color: #f8fafc; /* Hafif vurgu */
        }
        .notification-item strong {
            font-weight: 600;
            color: #0a0615;
            display: block;
            margin-bottom: 2px;
        }
        .notification-item p {
            font-family: 'Open Sans', sans-serif;
            font-size: 13px;
            color: #404B52;
            margin-bottom: 5px;
            line-height: 1.4;
        }
        .notification-item small {
            font-size: 11px;
            color: #9299a3;
        }
        .date-card .dot {
            width: 6px;
            height: 6px;
            background: #fdfd10; /* Sarı veya istediğiniz bir renk */
            border-radius: 50%;
            margin-top: 4px;
        }
        .featured-trainer-slider {
            width: 100%;
            overflow: hidden;
            padding: 20px 0;
            margin-bottom: 20px;
            background-color: #f8fafc;
            border-radius: 12px;
        }
        .slider-wrapper {
            display: flex;
            /* Animasyon: eleman sayısı * 5 saniye */
            animation: slide 15s linear infinite;
        }
        .slide {
            flex-shrink: 0;
            width: 50%; /* Aynı anda 2 kart görünecek */
            padding: 0 10px;
            box-sizing: border-box;
        }
        .slide-content {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .slide img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .slide .info h3 {
            font-size: 12px;
            font-weight: 600;
            color: #0a0615;
            margin: 0;
        }
        .slide .info p {
            font-size: 14px;
            font-weight: 500;
            color: #404b52;
            margin: 0;
        }
        @keyframes slide {
            from { transform: translateX(0%); }
            to { transform: translateX(-100%); }
        }
  </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="top-bar-content">
            <div class="greeting">Merhaba, {{ $userFirstName }}</div>
            <div class="header-icons">
                <a href="{{route('coming-soon')}}" class="header-icon-box"><img src="{{ asset('img/ai.png') }}" alt="AI Icon" /></a>
                <a href="{{route('coming-soon')}}" class="header-icon-box"><img src="{{ asset('img/search.png') }}" alt="Search Icon" /></a>
                <a href="{{route('coming-soon')}}" class="header-icon-box"><img src="{{ asset('img/fav.png') }}" alt="Favorites Icon" /></a>
                <div class="header-icon-box notification-bell">
                    🔔
                    <span id="notification-count" class="notification-count" style="display: none;">0</span>
                    <div id="notifications-dropdown" class="notifications-dropdown">
                        <div class="notification-item">Yükleniyor...</div>
                    </div>
                </div>
            </div>
        </div>

        <p class="subtitle">Spor Yapmak İçin Harika Bir Gün.</p>

        <div class="daily-schedule-scroller">
            @foreach($weekDates as $date)
                <div class="date-card {{ $date['is_today'] ? 'selected' : '' }}">
                    <div class="day-letter">{{ $date['day_letter'] }}</div>
                    <div class="day-number">{{ $date['day_number'] }}</div>

                    {{-- YENİ: Eğer aktivite varsa noktayı göster --}}
                    @if($date['has_activity'])
                        <div class="dot"></div>
                    @endif
                </div>
            @endforeach

            <div class="target-level-card">
                <div class="target-text">Hedef</div>
                <div class="target-value">{{ $completedGoals }}/{{ $totalGoals }}</div>
                <div class="level-label">Seviyeniz</div>
                <div class="level-value">{{ $userLevel }}</div>
            </div>
        </div>

        <div class="featured-trainer-slider">
            <div class="slider-wrapper">
                {{-- Controller'dan gelen verileri iki kez yazdırıyoruz, kesintisiz döngü için --}}
                @foreach($featuredTrainers as $trainer)
                    <div class="slide">
                        <div class="slide-content">
                            <img src="{{ $trainer['image'] }}" alt="{{ $trainer['name'] }}">
                            <div class="info">
                                <h3>{{ $trainer['title'] }}</h3>
                                <p>{{ $trainer['name'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Döngünün kesintisiz olması için slaytları kopyalıyoruz --}}
                @foreach($featuredTrainers as $trainer)
                    <div class="slide">
                        <div class="slide-content">
                            <img src="{{ $trainer['image'] }}" alt="{{ $trainer['name'] }}">
                            <div class="info">
                                <h3>{{ $trainer['title'] }}</h3>
                                <p>{{ $trainer['name'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div style="background-color: #f1f4f8; border-radius:8px; padding:1rem; display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <div>
                {{-- Kullanıcının programı olup olmamasına göre metni değiştiriyoruz --}}
                @if($activeProgram)
                    <strong>Size özel bir program atandı!</strong>
                @else
                    Bugün ne yapmak istersin?
                @endif
            </div>

            {{-- Butonun linki, $activeProgram değişkeninin durumuna göre dinamik olarak değişir --}}
            <a href="{{ $activeProgram ? route('program.show', $activeProgram) : route('workouts.all') }}" style="background-color:#272c31; color:white; padding: 0.75rem 1.5rem; border-radius:25px; text-decoration:none; font-weight:bold;">
                Antrenmana Başla
            </a>
        </div>

        <div class="location-cards-row">
            @php
                $kulupte = $workoutCategories->firstWhere('slug', 'kulupte');
                $evde = $workoutCategories->firstWhere('slug', 'evde');
                $disarida = $workoutCategories->firstWhere('slug', 'disarida');
            @endphp

            @if($kulupte)
                <a href="{{ route('workouts.index', $kulupte) }}" class="location-card club">
                    <img src="{{ asset('img/sayfa15-1.png') }}" alt="Kulüp" />
                    <span class="overlay-text">Kulüpte</span>
                </a>
            @endif

            <div style="flex:1; display:flex; flex-direction:column; gap:12px;">
                @if($evde)
                    <a href="{{ route('workouts.index', $evde) }}" class="location-card home">
                        <img src="{{ asset('img/sayfa15-1.png') }}" alt="Evde" />
                        <span class="overlay-text">Evde</span>
                    </a>
                @endif
                @if($disarida)
                    <a href="{{ route('workouts.index', $disarida) }}" class="location-card outside">
                        <img src="{{ asset('img/sayfa15-1.png') }}" alt="Dışarıda" />
                        <span class="overlay-text">Dışarıda</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="categories-section">
            <div class="section-header">
                <h2 class="section-title">Antrenman Tipleri</h2>
                <a href="{{ route('workouts.all') }}" class="section-view-all">Tümü</a>
            </div>
            <div class="category-cards">
                @forelse($categories as $type)
                    <a href="{{ route('workouts.all', ['type' => $type->slug]) }}" class="category-card">
                        <img src="{{ asset('storage/' . $type->icon) }}" alt="{{ $type->name }} Icon" />
                        <div class="category-name">{{ $type->name }}</div>
                    </a>
                @empty
                    <p class="text-muted">Henüz antrenman tipi eklenmemiş.</p>
                @endforelse
            </div>
        </div>

        <div class="featured-section">
            <div class="section-header">
                <h2 class="section-title">Öne Çıkanlar</h2>
                <a href="{{ route('workouts.all') }}" class="section-view-all">Tümü</a>
            </div>
            <div class="featured-cards">
                @forelse($featuredWorkouts as $workout)
                    {{-- Kart artık bir link değil, modal'ı tetikleyecek bir div --}}
                    <div class="featured-card"
                         style="cursor: pointer;"
                         data-id="{{ $workout->id }}"
                         data-video-url="{{ $workout->video_url }}"
                         data-name="{{ $workout->name }}">
                        <img src="{{ $workout->muscle_group_image_url }}" alt="{{ $workout->name }}" />
                        <div class="featured-text">{!! $workout->name !!}</div>
                    </div>
                @empty
                    <p class="text-muted">Öne çıkan antrenman bulunmamaktadır.</p>
                @endforelse
            </div>
        </div>

        {{-- YENİ EKLENEN BÖLÜMLER --}}
        <div class="trainers-booking-section">
            <a href="{{ route('trainers.index') }}" class="trainers-card">
                <img src="{{asset('img/sayfa15-3.png')}}" alt="Trainers Image" />
                <span class="overlay-text">Eğitmenler</span>
            </a>
            <a href="{{ route('booking.calendar') }}" class="booking-card">
                <img src="{{asset('img/sayfa15-4.png')}}" alt="Booking Image" />
                <span class="overlay-text">Rezervasyon<br />Oluştur</span>
            </a>
        </div>

        <div class="group-classes-section">
            <a href="{{ route('group-classes.index') }}" class="group-classes-card">
                <img src="{{asset('img/sayfa15-5.png')}}" alt="Group Classes Image" />
                <span class="overlay-text">Grup Dersleri</span>
            </a>
        </div>
        {{-- YENİ EKLENEN BÖLÜMLERİN SONU --}}

    </div>

    @include('bottom-nav')
</div>

<script>
    // --- ADIM 1: MOBİL UYGULAMA İLE İLETİŞİM ---
    // Android/iOS uygulamanız, Firebase'den aldığı token'ı bu fonksiyona gönderecek.
    function registerDeviceToken(token) {
        console.log("Cihaz Anahtarı Alındı:", token);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF Token bulunamadı. Cihaz kaydı yapılamadı.');
            return;
        }

        fetch('/api/devices/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ token: token })
        }).then(res => res.json()).then(data => {
            if(data.success) {
                console.log("Cihaz anahtarı sunucuya başarıyla kaydedildi.");
            } else {
                console.error("Cihaz anahtarı kaydedilemedi. Sunucu hatası.");
            }
        }).catch(err => console.error("Cihaz anahtarı kaydedilemedi. Ağ hatası:", err));
    }

    // --- ADIM 2: UYGULAMA İÇİ BİLDİRİM SİSTEMİ ---
    document.addEventListener('DOMContentLoaded', function() {
        const bell = document.querySelector('.notification-bell');
        const countEl = document.getElementById('notification-count');
        const dropdown = document.getElementById('notifications-dropdown');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!bell || !countEl || !dropdown || !csrfToken) {
            console.error("Bildirim sistemi için gerekli HTML elementleri bulunamadı.");
            return;
        }

        function fetchNotifications() {
            fetch('/api/notifications', {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(notifications => {
                    const unreadCount = notifications.filter(n => !n.read_at).length;
                    countEl.textContent = unreadCount;
                    countEl.style.display = unreadCount > 0 ? 'block' : 'none';

                    dropdown.innerHTML = '';
                    if (notifications.length === 0) {
                        dropdown.innerHTML = '<div class="notification-item">Yeni bildirim yok.</div>';
                    } else {
                        notifications.forEach(n => {
                            const item = document.createElement('div');
                            item.className = 'notification-item' + (!n.read_at ? ' unread' : '');
                            item.dataset.id = n.id;

                            const title = document.createElement('strong');
                            title.textContent = n.title;

                            const message = document.createElement('p');
                            message.textContent = n.message;

                            const date = document.createElement('small');
                            date.textContent = new Date(n.created_at).toLocaleString('tr-TR');

                            item.appendChild(title);
                            item.appendChild(message);
                            item.appendChild(date);
                            dropdown.appendChild(item);
                        });
                    }
                })
                .catch(err => console.error("Bildirimler çekilemedi:", err));
        }

        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = dropdown.style.display === 'block';
            dropdown.style.display = isVisible ? 'none' : 'block';

            if (!isVisible) {
                const unreadItems = dropdown.querySelectorAll('.notification-item.unread');
                const unreadIds = Array.from(unreadItems).map(item => item.dataset.id);

                if (unreadIds.length > 0) {
                    fetch('/api/notifications/mark-as-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ ids: unreadIds })
                    }).then(() => {
                        unreadItems.forEach(item => item.classList.remove('unread'));
                        countEl.style.display = 'none';
                    });
                }
            }
        });

        document.addEventListener('click', function(e) {
            if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        fetchNotifications();
        setInterval(fetchNotifications, 60000);
    });
</script>
</body>
</html>
