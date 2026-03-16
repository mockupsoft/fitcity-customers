<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $trainer->name }} - Eğitmen Detayı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;500;600;700;900&family=Open+Sans:wght@400;800&family=Roboto:wght@400&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: #f8fafc; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 15px; }
        .profile-header { display: flex; flex-direction: column; align-items: center; margin-bottom: 25px; margin-top: 30px; }
        .profile-header .profile-image { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #e5e9ef; }
        .profile-header .instructor-name { color: #0a0615; font-size: 16px; font-weight: 700; }
        .contact-info-card { background: white; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; padding: 0 16px; margin-bottom: 25px; }
        .contact-info-item { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f1f4f8; text-decoration: none;}
        .contact-info-item:last-child { border-bottom: none; }
        .contact-info-item .icon { font-size: 24px; margin-right: 15px; width: 28px; text-align: center;}
        .contact-info-item .text { flex-grow: 1; color: #0a0615; font-size: 16px; font-weight: 400; }
        .contact-info-item .arrow-right { color: #a9b2ba; font-size: 20px; font-weight: bold; }
        .section-title { color: #0a0615; font-size: 16px; font-weight: 700; margin-bottom: 10px; padding-left: 15px; }
        .about-text { color: black; font-size: 13px; font-weight: 400; line-height: 1.5; margin-bottom: 25px; padding: 0 15px; }
        .certificate-title { color: #0a0615; font-size: 16px; font-weight: 900; margin-bottom: 15px; padding-left: 15px; }
        .certificate-list { margin-bottom: 25px; padding-left: 15px; }
        .certificate-item { display: flex; align-items: center; margin-bottom: 10px; }
        .certificate-item .icon { font-size: 23px; margin-right: 10px; }
        .certificate-item .text { color: black; font-size: 16px; font-weight: 600; }
        .section-divider { border-top: 1px solid #cfcfcf; margin: 25px 0; }
        .classes-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 0 15px; }
        .classes-header .section-title { margin: 0; font-size: 20px; font-weight: 700; padding: 0; }
        .classes-header .see-all-btn { color: #9299a3; font-size: 15px; font-weight: 500; text-decoration: none; }
        .classes-carousel { display: flex; overflow-x: auto; gap: 15px; padding: 0 15px 15px 15px; -webkit-overflow-scrolling: touch; scroll-snap-type: x mandatory; }
        .classes-carousel::-webkit-scrollbar { display: none; }
        .class-card { flex-shrink: 0; width: 240px; height: 230px; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); position: relative; scroll-snap-align: start; text-decoration: none;}
        .class-card .class-image { width: 100%; height: 160px; object-fit: cover; }
        .class-card .class-type-badge { position: absolute; bottom: 60px; left: 15px; background: #282d32; color: white; font-size: 9px; font-weight: 800; padding: 3px 8px; border-radius: 5px; z-index: 1; }
        .class-card .class-details { padding: 8px 10px; }
        .class-card .class-name { color: black; font-size: 12px; font-weight: 600; }
        .class-card .instructor-name-small { color: #0a0615; font-size: 11px; font-weight: 275; }
        .class-card .class-day-small, .class-card .class-time-small { color: #8b8888; font-size: 11px; font-weight: 600; }
        .private-lesson-title { color: #0a0615; font-size: 20px; font-weight: 500; margin-bottom: 15px; padding-left: 15px; }
        .private-lesson-card { background: white; border-radius: 8px; border: 1px solid #e5e9ef; padding: 15px; margin: 0 15px 15px 15px; }
        .private-lesson-card .lesson-name { color: black; font-size: 15px; font-family: "Open Sans", sans-serif; }
        .private-lesson-card .lesson-price { color: #ff0000; font-size: 15px; font-family: "Open Sans", sans-serif; font-weight: 800; }
        .private-lesson-card .request-button { background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2) inset; border-radius: 25px; color: white; font-size: 15px; font-weight: 600; padding: 8px 0; text-align: center; display: block; width: 80%; margin: 10px auto 0; text-decoration: none; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="profile-header">
            <img class="profile-image" src="{{ $trainer->profile_photo ? asset('storage/'.$trainer->profile_photo) : asset('img/sayfa22.png') }}" alt="{{ $trainer->name }} Profil Resmi"/>
            <div class="instructor-name">{{ $trainer->name }}</div>
        </div>

        <div class="contact-info-card">
            <a href="mailto:{{ $trainer->email }}" class="contact-info-item">
                <span class="icon mail">✉︎</span>
                <span class="text">{{ $trainer->email }}</span>
                <span class="arrow-right">&gt;</span>
            </a>
            <a href="tel:{{ $trainer->phone }}" class="contact-info-item">
                <span class="icon phone">✆</span>
                <span class="text">{{ $trainer->phone }}</span>
                <span class="arrow-right">&gt;</span>
            </a>
            {{-- Instagram bilgisi için özel bir alan eklemeniz gerekebilir --}}
        </div>

        <div class="section-title">Hakkında</div>
        <p class="about-text">{{ $trainer->trainerDetails->notes ?? 'Eğitmen hakkında bilgi bulunmamaktadır.' }}</p>

        <hr class="section-divider" />

        <div class="certificate-title">Sahip Olduğu Sertifikalar</div>
        <div class="certificate-list">
            @forelse($trainer->trainerDetails->certification ?? [] as $certificate)
                <div class="certificate-item">
                    <span class="icon">🥇</span>
                    <span class="text">{{ $certificate }}</span>
                </div>
            @empty
                <p>Kayıtlı sertifika bulunmamaktadır.</p>
            @endforelse
        </div>

        <hr class="section-divider" />

        <div class="classes-header">
            <div class="section-title">Dersleri</div>

        </div>
        <div class="classes-carousel">
            @forelse($trainer->groupClasses as $class)
                <a  class="class-card">
                    <img class="class-image" src="{{ asset('img/sayfa21.png') }}" alt="{{ $class->name }}"/>
                    <div class="class-type-badge">{{ $class->type }}</div>
                    <div class="class-details">
                        <div class="class-name">{{ $class->name }}</div>
                        <div class="instructor-name-small">{{ $trainer->name }}</div>
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span class="class-day-small">{{ $class->class_date->translatedFormat('l') }}</span>
                            <span class="class-time-small">{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="px-3">Bu eğitmene ait planlanmış grup dersi bulunmamaktadır.</p>
            @endforelse
        </div>

        <hr class="section-divider" />

{{--        <div class="private-lesson-title">Özel Ders Ücretleri</div>--}}
{{--        @forelse($privateLessonPackages as $package)--}}
{{--            <div class="private-lesson-card">--}}
{{--                <div class="d-flex justify-content-between align-items-center">--}}
{{--                    <div class="lesson-name">{{ $package['name'] }}</div>--}}
{{--                    <div class="lesson-price">₺{{ number_format($package['price'], 2, ',', '.') }}</div>--}}
{{--                </div>--}}
{{--                <a href="#" class="request-button">Özel Ders Talebinde Bulun</a>--}}
{{--            </div>--}}
{{--        @empty--}}
{{--            <p class="px-3">Bu eğitmen için özel ders paketi tanımlanmamıştır.</p>--}}
{{--        @endforelse--}}
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
