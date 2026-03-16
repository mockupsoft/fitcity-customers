<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&family=Roboto:wght@400&display=swap" rel="stylesheet"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; width: 100%; min-height: 100vh; background: #f8fafc; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 0 16px 20px 16px; }
        .profile-header { display: flex; flex-direction: column; align-items: center; padding: 30px 0 20px 0; margin-bottom: 20px; }
        .profile-avatar { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin-bottom: 10px; }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-name { color: #0a0615; font-size: 20px; font-weight: 500; }
        .info-cards { display: flex; justify-content: space-between; gap: 16px; margin-bottom: 30px; }
        .info-card { flex: 1; min-width: 108px; height: 80px; background: white; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .info-card .icon { font-size: 22px; margin-bottom: 4px; }
        .info-card .value { color: #0a0615; font-size: 14px; font-weight: 400; }
        .menu-section { background: white; box-shadow: 0px 5px 10px rgba(234, 240, 246, 0.6); border-radius: 8px; margin-bottom: 20px; padding: 0 16px; }
        .menu-item { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f1f4f8; text-decoration: none; cursor: pointer; }
        .menu-item:last-child { border-bottom: none; }
        .menu-item .text { color: #0a0615; font-size: 16px; font-weight: 400; }
        .menu-item .arrow-icon { color: #a9b2ba; font-size: 20px; font-weight: bold; transition: transform 0.3s ease; }
        .menu-item[aria-expanded="true"] .arrow-icon { transform: rotate(90deg); }
        #qr-code-container { display: flex; justify-content: center; align-items: center; padding: 20px 0; }
        .timer { font-size: 18px; font-weight: 600; color: #D9376E; }
        .qr-collapse-body { text-align: center; padding-bottom: 16px; border-bottom: 1px solid #f1f4f8; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="{{ $profilePhotoUrl ?? asset('default-avatar.png') }}" alt="Profile Avatar"/>
            </div>
            <div class="profile-name">{{ $name ?? 'Kullanıcı' }}</div>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <div class="icon">⚖️</div>
                <div class="value">{{ $weight ?? 0 }} kg</div>
            </div>
            <div class="info-card">
                <div class="icon">📏</div>
                <div class="value">{{ $height ?? 0 }} cm</div>
            </div>
            <div class="info-card">
                <div class="icon">🎂</div>
                <div class="value">{{ $age ?? 0 }} Yaş</div>
            </div>
        </div>

        <div class="menu-section">
            <a data-bs-toggle="collapse" href="#qrCollapse" role="button" aria-expanded="false" aria-controls="qrCollapse" class="menu-item text-decoration-none">
                <div class="text">Salona Giriş QR</div>
                <div class="arrow-icon">&rsaquo;</div>
            </a>

            <div class="collapse" id="qrCollapse">
                <div class="qr-collapse-body">
                    <div id="qr-code-container"></div>
                    <p class="mt-2 mb-0">Bu kod <span id="countdown" class="timer">30</span> saniye içinde yenilenecektir.</p>
                    <div id="qr-error" class="alert alert-danger d-none mt-2"></div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="menu-item text-decoration-none">
                <div class="text">Kişisel Bilgilerim</div>
                <div class="arrow-icon">&rsaquo;</div>
            </a>
            <a href="{{ route('subscriptions.index') }}" class="menu-item text-decoration-none">
                <div class="text">Üyelik Bilgilerim</div>
                <div class="arrow-icon">&rsaquo;</div>
            </a>
            <a href="{{ route('profile.measurements') }}" class="menu-item text-decoration-none">
                <div class="text">Ölçümlerim</div>
                <div class="arrow-icon">&rsaquo;</div>
            </a>
        </div>

        <div class="menu-section">
            <form id="delete-account-form" method="POST" action="{{ route('profile.destroy_account') }}">
                @csrf
                @method('DELETE')
                <div class="menu-item" onclick="document.getElementById('delete-account-form').submit();">
                    <div class="text" style="color: red;">Hesabımı Sil</div>
                    <div class="arrow-icon">&rsaquo;</div>
                </div>
            </form>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="menu-item" onclick="document.getElementById('logout-form').submit();">
                    <div class="text" style="color: red;">Çıkış Yap</div>
                    <div class="arrow-icon">&rsaquo;</div>
                </div>
            </form>
        </div>
    </div>

    @include('bottom-nav')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const qrCollapseEl = document.getElementById('qrCollapse');
        const qrCodeContainer = document.getElementById('qr-code-container');
        const countdownEl = document.getElementById('countdown');
        const qrErrorDiv = document.getElementById('qr-error');
        let countdownInterval;
        let qrTimeout;

        qrCollapseEl.addEventListener('show.bs.collapse', function () {
            generateCode();
        });

        qrCollapseEl.addEventListener('hidden.bs.collapse', function () {
            clearInterval(countdownInterval);
            clearTimeout(qrTimeout);
            qrCodeContainer.innerHTML = '';
        });

        function generateCode() {
            qrErrorDiv.classList.add('d-none');
            qrCodeContainer.innerHTML = '';

            const userId = "{{ Auth::id() }}";

            if (!userId) {
                qrErrorDiv.textContent = 'Kullanıcı oturumu bulunamadı.';
                qrErrorDiv.classList.remove('d-none');
                return;
            }

            new QRCode(qrCodeContainer, {
                text: userId,
                width: 200,
                height: 200,
                colorDark : "#0a0615",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            startCountdown(30);
        }

        function startCountdown(seconds) {
            clearInterval(countdownInterval);
            clearTimeout(qrTimeout);

            let remaining = seconds;
            countdownEl.textContent = remaining;

            countdownInterval = setInterval(() => {
                remaining--;
                countdownEl.textContent = remaining;
                if (remaining <= 0) {
                    clearInterval(countdownInterval);
                    qrCodeContainer.innerHTML = '';
                    generateCode();
                }
            }, 1000);
        }
    });
</script>
</body>
</html>
