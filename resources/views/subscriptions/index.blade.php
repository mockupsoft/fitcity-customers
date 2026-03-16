<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Üyelik Bilgilerim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: #f8fafc; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px 16px; }
        .page-header { display: flex; align-items: center; justify-content: center; position: relative; margin-top: 45px; margin-bottom: 20px; }
        .back-button { position: absolute; left: 0; top: 50%; transform: translateY(-50%); text-decoration: none; color: #0a0615; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .page-title { font-size: 16px; font-weight: 700; }
        .current-subscription-card { background: white; border-radius: 8px; box-shadow: 0 5px 10px rgba(234,240,246,0.6); padding: 20px; margin-bottom: 25px; }
        .current-subscription-card .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f4f8; padding-bottom: 15px; margin-bottom: 15px; }
        .current-subscription-card .package-name { font-size: 20px; font-weight: 800; }
        .current-subscription-card .status-badge { font-size: 14px; font-weight: 700; padding: 5px 15px; border-radius: 18px; }
        .current-subscription-card .status-badge.active { background-color: #e6f8c8; color: #3a3a3a; }
        .current-subscription-card .details { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .current-subscription-card .detail-item .label { font-size: 14px; color: #9299a3; }
        .current-subscription-card .detail-item .value { font-size: 16px; font-weight: 500; color: #0a0615; }
        .action-buttons { display: flex; gap: 16px; margin-bottom: 30px; }
        .action-buttons .action-btn { flex: 1; background: #282D32; color: white; border-radius: 18px; padding: 15px 0; text-align: center; font-size: 14px; font-weight: 700; text-decoration: none; }
        .section-heading { font-size: 20px; font-weight: 800; margin-bottom: 20px; }
        .package-cards { display: flex; gap: 16px; margin-bottom: 30px; }
        .package-card { flex: 1; background: white; border-radius: 8px; border: 1px solid #e5e9ef; padding: 15px; text-align: center; }
        .package-card.selected { border: 2px solid #282D32; }
        .package-card .package-title { font-size: 16px; font-weight: 500; margin-bottom: 15px; }
        .package-card .features { list-style: none; padding: 0; margin-bottom: 20px; text-align: left; font-size: 10px; font-weight: 300; }
        .package-card .features li { margin-bottom: 10px; display: flex; align-items: center; }
        .package-card .features .icon { color: #282D32; margin-right: 5px; font-weight: 500; }
        .package-card .price { color: #FF0000; font-size: 15px; font-weight: 800; margin-bottom: 15px; }
        .package-card .buy-btn { background: #282D32; color: white; border-radius: 18px; padding: 5px 0; text-align: center; font-size: 12px; font-weight: 700; text-decoration: none; display: block; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <header class="page-header">
            <a href="{{ route('profile.show') }}" class="back-button">
                <div class="icon"></div>
            </a>
            <h1 class="page-title">Üyelik Bilgilerim</h1>
        </header>

        @if($subscription)
            <div class="current-subscription-card">
                <div class="header">
                    <span class="package-name">{{ $subscription->package->name }}</span>
                    <span class="status-badge active">Aktif</span>
                </div>
                <div class="details">
                    <div class="detail-item">
                        <div class="label">Başlangıç Tarihi</div>
                        <div class="value">{{ $subscription->starts_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Yenileme Tarihi</div>
                        <div class="value">{{ $subscription->next_billing_date->format('d.m.Y') }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">Aktif bir üyeliğiniz bulunmamaktadır.</div>
        @endif

{{--        <div class="action-buttons">--}}
{{--            <a href="#" class="action-btn">Üyeliğimi Uzat</a>--}}
{{--            <a href="#" class="action-btn">Üyeliğimi Yenile</a>--}}
{{--        </div>--}}

        <h2 class="section-heading">Kampanyalı Üyelikler</h2>
        <div class="package-cards">
            @forelse($packages as $package)
                <div class="package-card {{ $loop->first ? 'selected' : '' }}">
                    <h3 class="package-title">{{ $package->name }}</h3>
                    <ul class="features">
                        <li><span class="icon">✔️</span> Üyelik Dönemine Göre Dondurma</li>
                        <li><span class="icon">✔️</span> Kişiye Özel Ölçüm ve Program</li>
                        <li><span class="icon">✔️</span> Grup Derslerine Katılım</li>
                        <li><span class="icon">✔️</span> Tesis Kullanımı</li>
                    </ul>
                    <div class="price">₺{{ number_format($package->price, 2, ',', '.') }}</div>
{{--                    <a href="#" class="buy-btn">Satın Al</a>--}}
                </div>
            @empty
                <p>Şu anda kampanyalı bir paket bulunmamaktadır.</p>
            @endforelse
        </div>
    </div>

    @include('bottom-nav')
</div>
</body>
</html>
