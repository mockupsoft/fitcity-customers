<style>
    /* Stillerde bir değişiklik yapmaya gerek yok, mevcut yapı yeni tasarıma uygun */
    .bottom-nav {
        position: fixed;
        bottom: 5%;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 490px;
        height: 80px;
        background: white;
        box-shadow: 0px -2px 10px #f2f6f9;
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
    }
    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #9299a3; /* Pasif renk */
        font-size: 10px;
        font-weight: 400;
        text-decoration: none;
        flex: 1;
    }
    .nav-item img {
        width: 24px;
        height: 24px;
        margin-bottom: 4px;
    }
    .home-indicator-bottom {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 134px;
        height: 5px;
        background: black;
        border-radius: 100px;
        z-index: 1001;
    }
    .nav-item.active {
        color: #282d32; /* Aktif renk */
        font-weight: 600;
    }
</style>

<div class="bottom-nav">
    {{-- 1. Ana Sayfa --}}
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <img src="{{ asset('img/home.png') }}" alt="Ana Sayfa" />
        <span>Ana Sayfa</span>
    </a>

    {{-- 2. Antrenman --}}
    <a href="{{ route('workouts.all') }}" class="nav-item {{ request()->routeIs('group-classes.*') ? 'active' : '' }}">
        <img src="{{ asset('img/training.png') }}" alt="Antrenman" /> {{-- Yeni ikon dosyası: dumbbell.png --}}
        <span>Antrenman</span>
    </a>

    {{-- 3. QR --}}
    <a href="{{ route('qr.index') }}" class="nav-item {{ request()->routeIs('qr.index') ? 'active' : '' }}">
        <img src="{{ asset('img/qr.png') }}" alt="QR Kod" />
        <span>QR</span>
    </a>

    {{-- 4. Takvim --}}
    <a href="{{ route('booking.calendar') }}" class="nav-item {{ request()->routeIs('booking.calendar') ? 'active' : '' }}">
        <img src="{{ asset('img/calendar.png') }}" alt="Takvim" /> {{-- Yeni ikon dosyası: calendar.png --}}
        <span>Takvim</span>
    </a>

    {{-- 5. Ürünler --}}
    <a href="{{ route('coming-soon') }}" class="nav-item"> {{-- TODO: Ürünler sayfası için rota eklenecek --}}
        <img src="{{ asset('img/bag.png') }}" alt="Ürünler" /> {{-- Yeni ikon dosyası: bag.png --}}
        <span>Ürünler</span>
    </a>

    {{-- 6. Profil --}}
    <a href="{{ route('profile.show') }}" class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
        <img src="{{ asset('img/user.png') }}" alt="Profil" />
        <span>Profil</span>
    </a>
</div>

