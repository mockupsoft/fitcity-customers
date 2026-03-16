<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Grup Dersleri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 15px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 600; margin-bottom: 25px; margin-top: 30px; }
        .group-class-row { display: flex; flex-wrap: wrap; gap: 16px; }
        .group-class-card { flex: 1 1 calc(50% - 8px); min-width: 170px; text-decoration: none; color: inherit; }
        .group-class-card img.class-image { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; }
        .group-class-card .class-title { color: #0a0615; font-size: 15px; font-weight: 500; line-height: 20px; margin-bottom: 4px; }
        .group-class-card .instructor-name { color: #282d32; font-size: 12px; font-weight: 500; line-height: 14px; margin-bottom: 4px; }
        .group-class-card .class-time-info { display: flex; align-items: center; gap: 4px; }
        .group-class-card .class-time-info .dot { width: 4px; height: 4px; background: #404b52; border-radius: 50%; }
        .group-class-card .class-time { color: #404b52; font-size: 12px; font-family: "Open Sans", sans-serif; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="page-title">Grup Dersleri</div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="group-class-row">
            {{-- DİNAMİK VERİ: Grup Dersleri Döngüsü --}}
            @forelse($groupClasses as $class)
                {{-- Kart artık bir link değil, bir div --}}
                <div class="group-class-card d-flex flex-column">
                    {{-- Ders detaylarına gitmek için link (ileride kullanılabilir) --}}
                    <a  style="text-decoration: none; color: inherit;">
                        <img class="class-image" src="{{ asset('img/sayfa21.png') }}" alt="{{ $class->name }}"/>
                        <div class="class-title">{{ $class->name }}</div>
                        <div class="instructor-name">{{ $class->trainer->name ?? 'Eğitmen Belirtilmemiş' }}</div>
                        <div class="class-time-info">
                            <div class="dot"></div>
                            <span class="class-time">
                    {{ $class->class_date->translatedFormat('l') }}:{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                </span>
                        </div>
                    </a>

                    {{-- YENİ: Derse katılmak için form ve buton --}}
                    <form method="POST" action="{{ route('group-classes.join', $class) }}" class="mt-auto pt-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-dark w-100">Derse Katıl</button>
                    </form>
                </div>
            @empty
                <p>Şu anda planlanmış grup dersi bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
