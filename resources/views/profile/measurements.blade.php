<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ölçümlerim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800;900&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; }
        .app-container { max-width: 490px; margin: auto; background: #f8fafc; min-height: 100vh; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="app-container">
    <div class="p-4">
        <div class="flex justify-between items-center mb-10">
            <a href="{{ route('profile.show') }}" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Ölçümlerim</h1>
            {{-- "Add" butonu ileride yeni ölçüm eklemek için kullanılabilir --}}
            <a href="{{ route('booking.calendar') }}" class="text-lg font-semibold text-gray-800">Ekle</a>
        </div>

        <div class="space-y-4">
            @forelse ($measurements as $measurement)
                <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                    {{-- Sol Taraf: Tarih ve Kilo --}}
                    <div>
                        <div class="text-xs text-gray-500 font-light">
                            {{ \Carbon\Carbon::parse($measurement->reservation_date)->translatedFormat('d F Y') }}
                        </div>
                        <div class="text-lg font-semibold text-gray-900">
                            {{-- Bu bilgi için measurements tablosundan veri çekmek gerekecek, şimdilik statik --}}
                            52.7 kg
                        </div>
                    </div>

                    {{-- Sağ Taraf: Değişim ve Saat --}}
                    <div class="text-right">
                        <div class="text-xs text-gray-500 font-light">
                            {{ \Carbon\Carbon::parse($measurement->reservation_date)->format('H:i') }}
                        </div>
                        {{-- Kilo değişimi hesaplaması için daha karmaşık bir mantık gerekir, şimdilik statik --}}
                        <div class="text-sm font-semibold text-green-500">
                            -0.2 kg
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-10">
                    <p>Henüz kayıtlı bir ölçümünüz bulunmamaktadır.</p>
                    <a href="{{ route('booking.calendar') }}" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">
                        İlk Ölçüm Randevunuzu Alın
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Sayfalama Linkleri --}}
        <div class="mt-6">
            {{ $measurements->links() }}
        </div>
    </div>
</div>
</body>
</html>
