<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aktivite Takvimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet"/>
    <style>
        /* Stilleriniz aynı kalır */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: white; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 19px; }
        .month-selector { color: #0a0615; font-size: 19px; font-weight: 600; margin-bottom: 20px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; text-align: center; margin-bottom: 25px; }
        .day-cell { cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 14px; font-weight: 500; min-width: 32px; height: 45px; }
        .day-cell.selected { background: white; border-radius: 8px; border: 1px solid #dae0e8; }
        .weekly-toggle-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .weekly-toggle-text { font-size: 14px; font-weight: 500; }
        .continue-button { background-color: #272c31; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: bold; display: block; text-align: center; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(69,64,82,0.48); z-index: 1050; display: none; align-items: flex-end; }
        .modal-overlay.active { display: flex; }
        .bottom-sheet { width: 100%; max-width: 490px; height: auto; background: white; border-top-left-radius: 24px; border-top-right-radius: 24px; padding: 20px; box-sizing: border-box; position: relative; display: flex; flex-direction: column; }
        .bottom-sheet-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .bottom-sheet-title { color: #0a0615; font-size: 20px; font-weight: 800; }
        .close-button { width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; cursor: pointer; position: absolute; top: 16px; right: 16px; }
        .close-button .icon-line { width: 18px; height: 2px; background: black; position: absolute; transform: rotate(45deg); }
        .close-button .icon-line:last-child { transform: rotate(-45deg); }
        .options-list { background: white; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; padding: 0; list-style: none; }
        .option-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; color: #0a0615; font-size: 17px; font-weight: 600; cursor: pointer; text-decoration: none; }
        .option-item:hover { background-color: #f8f9fa; }
        .option-item + .option-item { border-top: 1px solid #f1f4f8; }
        .option-item .arrow-icon { width: 8px; height: 14px; background: #a9b2ba; clip-path: polygon(0% 0%, 100% 50%, 0% 100%); }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        {{-- HATA DÜZELTME: $monthName parse etmek yerine doğrudan gösteriyoruz. Controller'dan gelen veri zaten string olmalı. --}}
        <div class="month-selector">{{ $monthName }} ⬇️</div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="calendar-grid">
            @php $daysOfWeek = ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz']; @endphp
            @foreach($daysOfWeek as $day)
                <div class="day-cell" style="font-weight:300;">{{ $day }}</div>
            @endforeach

            @for ($i = 1; $i <= $daysInMonth; $i++)
                @php
                    // HATA DÜZELTME: Tarihi güvenli bir şekilde oluşturuyoruz.
                    // $monthName "Kasım 2025" gibi Türkçe bir string olduğu için doğrudan parse edilemiyor olabilir.
                    // Bunun yerine Controller'dan $year ve $month (sayısal) olarak veri gelmesi daha sağlıklı olurdu.
                    // Ancak mevcut yapıyı korumak için, $monthName içindeki yılı ve ayı ayrıştırıp kullanabiliriz veya
                    // en güvenlisi, o anki döngüdeki günü temsil eden tarihi manuel oluşturmaktır.
                    // Varsayım: Sayfa o anki ayı gösteriyor.
                    try {
                         // Türkçe tarih parse etmeyi dener, başarısız olursa o anki ayı baz alır.
                         $currentDate = \Carbon\Carbon::createFromFormat('d F Y', "$i $monthName", 'Europe/Istanbul')->locale('tr');
                    } catch (\Exception $e) {
                         // Yedek plan: Eğer $monthName parse edilemezse, bugünün ayını ve yılını kullan (veya controllerdan gelen değişkenleri)
                         // Not: Controller'dan $year ve $month değişkenlerini de göndermeniz en doğrusu olacaktır.
                         // Şimdilik hata vermemesi için o anki ayı kullanıyoruz:
                         $currentDate = \Carbon\Carbon::now()->day($i);
                    }
                @endphp
                <div class="day-cell {{ $i == $today ? 'selected' : '' }}" data-day="{{ $i }}" data-date="{{ $currentDate->toDateString() }}">
                    {{ $i }}
                </div>
            @endfor
        </div>

        <div class="weekly-toggle-section">
            <div class="weekly-toggle-text">Haftalık Göster</div>
        </div>
        <div class="todays-activity-section">
            {{-- HATA DÜZELTME: Locale ayarını setLocale ile garantiye alıyoruz --}}
            <div class="activity-header">Bugün - {{ \Carbon\Carbon::now()->locale('tr')->translatedFormat('j F l') }}</div>
        </div>

        <div style="position: absolute; bottom: 100px; left: 19px; right: 19px;">
            <a  id="create-reservation-btn" class="continue-button">Rezerve Oluştur</a>
        </div>
    </div>

    @include('bottom-nav')

    <div id="reservation-modal" class="modal-overlay">
        <div class="bottom-sheet">
            <div class="bottom-sheet-header">
                <div class="bottom-sheet-title">Rezervasyon oluştur</div>
                <div id="close-modal-btn" class="close-button">
                    <div class="icon-line"></div>
                    <div class="icon-line"></div>
                </div>
            </div>
            <ul class="options-list">
                <li id="private-lesson-link" class="option-item" data-url="{{ route('reservations.private-lesson.select-trainer') }}">
                    <span>Özel ders</span>
                    <div class="arrow-icon"></div>
                </li>
                <a href="{{ route('group-classes.index') }}" class="option-item">
                    <span>Grup ders</span>
                    <div class="arrow-icon"></div>
                </a>
                <li id="measurement-link" class="option-item" data-url="{{ route('reservations.measurement.select-trainer') }}">
                    <span>Ölçüm</span>
                    <div class="arrow-icon"></div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById('create-reservation-btn');
        const closeBtn = document.getElementById('close-modal-btn');
        const modal = document.getElementById('reservation-modal');
        const dayCells = document.querySelectorAll('.day-cell[data-day]');
        const olcumLink = document.getElementById('measurement-link');
        const ozelDersLink = document.getElementById('private-lesson-link'); // Yeni seçici

        let selectedDate = '{{ \Carbon\Carbon::today()->toDateString() }}';

        dayCells.forEach(cell => {
            cell.addEventListener('click', function() {
                dayCells.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedDate = this.dataset.date;
            });
        });

        // "Ölçüm" seçeneğine tıklandığında yönlendirmeyi yap
        if (olcumLink) {
            olcumLink.addEventListener('click', function() {
                // Temel URL'yi data-url'den al
                const baseUrl = this.dataset.url;
                // Seçili tarihi ekleyerek tam URL'yi oluştur ve yönlendir
                window.location.href = baseUrl + '?date=' + selectedDate;
            });
        }
        if (ozelDersLink) {
            ozelDersLink.addEventListener('click', function() {
                const baseUrl = this.dataset.url;
                window.location.href = baseUrl + '?date=' + selectedDate;
            });
        }
        // Modal açma/kapama fonksiyonları
        openBtn.addEventListener('click', function (event) {
            event.preventDefault();
            modal.classList.add('active');
        });

        closeBtn.addEventListener('click', function() {
            modal.classList.remove('active');
        });

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    });
</script>
</body>
</html>
