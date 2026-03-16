<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF token'ı JavaScript için ekliyoruz --}}
    <title>İndirim Kodu Al</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; margin: 0; }
        .app-container { max-width: 490px; min-height: 100vh; background: #f8fafc; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 0; overflow: hidden; }
        .scrollable-content { height: calc(100vh - 80px); overflow-y: auto; padding: 20px; }
        .page-title { color: #0a0615; font-size: 27px; font-weight: 700; text-align: center; margin-top: 50px; }
        .page-description { color: #404b52; font-size: 16px; text-align: center; margin-top: 15px; margin-bottom: 30px; }
        .main-button { background: #282D32; color: white; border-radius: 25px; padding: 15px; text-align: center; font-size: 18px; font-weight: 700; text-decoration: none; display: block; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050; display: none; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 20px; width: 90%; max-width: 400px; max-height: 80vh; display: flex; flex-direction: column; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-title { font-size: 20px; font-weight: 700; }
        .close-button { border: none; background: none; font-size: 24px; cursor: pointer; }
        .modal-body { overflow-y: auto; }
        .package-item { border: 1px solid #e5e9ef; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
        .package-item h5 { font-size: 16px; font-weight: 600; }
        .package-item .price { font-size: 14px; color: #404b52; }
        .package-item .create-code-btn { width: 100%; background: #282D32; color: white; border: none; border-radius: 20px; padding: 10px; margin-top: 10px; font-weight: 600; }
        .generated-code-box { background: #f1f4f8; border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 20px; }
        #generated-code { font-size: 18px; font-weight: 700; color: #0a0615; word-break: break-all; }
        .copy-code-btn { width: 100%; border: 1px solid #282D32; color: #282D32; background: transparent; }
        .btn-block { width: 100%; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <div class="scrollable-content">
        <h1 class="page-title">Abonelik Paketleri</h1>
        <p class="page-description">
            Size özel abonelik paketlerimizden birini seçerek avantajlardan yararlanın.
            Hemen bir kod oluşturun!
        </p>
        <button id="open-packages-modal-btn" class="main-button btn-block">Kod Al</button>
    </div>

</div>

<div id="packagesModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Bir Paket Seçin</h5>
            <button class="close-button" data-close-modal="packagesModal">&times;</button>
        </div>
        <div class="modal-body" id="packagesList">
            @foreach($packages as $package)
                <div class="package-item">
                    <h5>{{ $package->name }}</h5>
                    <button class="create-code-btn"
                            data-package-id="{{ $package->id }}">
                        Kod Oluştur
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="generatedCodeModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kodunuz Oluşturuldu</h5>
            <button class="close-button" data-close-modal="generatedCodeModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="generated-code-box">
                <span id="generated-code"></span>
            </div>
            {{-- Butonlar birleştirildi --}}
            <a href="{{ route('dashboard') }}" id="copy-and-continue-btn" class="main-button">Kopyala ve Devam Et</a>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openPackagesModalBtn = document.getElementById('open-packages-modal-btn');
        const packagesModal = document.getElementById('packagesModal');
        const generatedCodeModal = document.getElementById('generatedCodeModal');
        const packagesList = document.getElementById('packagesList');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        openPackagesModalBtn.addEventListener('click', () => packagesModal.classList.add('active'));

        document.querySelectorAll('[data-close-modal]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.dataset.closeModal;
                document.getElementById(modalId).classList.remove('active');
            });
        });

        // KOD OLUŞTURMA MANTIĞI GÜNCELLENDİ
        packagesList.addEventListener('click', async function(event) {
            if (event.target.classList.contains('create-code-btn')) {
                const button = event.target;
                button.textContent = "Oluşturuluyor...";
                button.disabled = true;

                const packageId = button.dataset.packageId;

                try {
                    // Sunucuya istek atıp kodu alıyoruz
                    const response = await fetch("{{ route('code.generate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ package_id: packageId })
                    });

                    if (!response.ok) {
                        throw new Error('Kod oluşturulurken bir hata oluştu.');
                    }

                    const data = await response.json();

                    // Gelen kodu modal'a yaz ve modal'ı göster
                    document.getElementById('generated-code').textContent = data.code;
                    packagesModal.classList.remove('active');
                    generatedCodeModal.classList.add('active');

                } catch (error) {
                    alert(error.message);
                } finally {
                    button.textContent = "Kod Oluştur";
                    button.disabled = false;
                }
            }
        });

        // KOPYALA VE DEVAM ET BUTONU MANTIĞI
        const copyAndContinueBtn = document.getElementById('copy-and-continue-btn');
        copyAndContinueBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Sayfanın hemen yönlenmesini engelle

            const code = document.getElementById('generated-code').textContent;
            navigator.clipboard.writeText(code).then(() => {
                copyAndContinueBtn.textContent = 'Kopyalandı!';

                // 1 saniye sonra yönlendirmeyi yap
                setTimeout(() => {
                    window.location.href = this.href;
                }, 1000);

            }).catch(err => {
                alert('Kod kopyalanamadı!');
                // Kopyalama başarısız olsa bile yönlendir
                window.location.href = this.href;
            });
        });
    });
</script>
</body>
</html>
