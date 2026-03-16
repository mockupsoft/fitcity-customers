<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kişisel Bilgilerim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #f8fafc; }
        .app-container { max-width: 490px; margin: auto; background: #f8fafc; min-height: 100vh; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="app-container p-4">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH') {{-- BU SATIRI EKLEYİN --}}
        <div class="flex justify-between items-center mb-10">
            <a href="{{ route('profile.show') }}" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Kişisel Bilgiler</h1>
            <button type="submit" class="text-lg font-semibold text-gray-800">Kaydet</button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-center mb-6">
            <div class="relative">
                <img class="h-24 w-24 rounded-full object-cover" src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('img/sayfa27.png') }}" alt="Profil Resmi">
                {{-- TODO: Fotoğraf yükleme butonu eklenebilir --}}
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 space-y-4">
            {{-- Name --}}
            <div class="flex justify-between items-center">
                <label for="name" class="text-gray-700">Ad Soyad</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="text-right border-none focus:ring-0 w-1/2">
            </div>
            <hr>
            {{-- Weight --}}
            <div class="flex justify-between items-center">
                <label for="weight" class="text-gray-700">Kilo (kg)</label>
                <input type="number" step="0.1" id="weight" name="weight" value="{{ old('weight', $user->member?->personal?->weight) }}" class="text-right border-none focus:ring-0 w-1/2">
            </div>
            <hr>
            {{-- Height --}}
            <div class="flex justify-between items-center">
                <label for="height" class="text-gray-700">Boy (cm)</label>
                <input type="number" id="height" name="height" value="{{ old('height', $user->member?->personal?->height) }}" class="text-right border-none focus:ring-0 w-1/2">
            </div>
            <hr>
            {{-- Date of Birth --}}
            <div class="flex justify-between items-center">
                <label for="birth_date" class="text-gray-700">Doğum Tarihi</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->member?->birth_date?->format('Y-m-d')) }}" class="text-right border-none focus:ring-0 w-1/2">
            </div>
            <hr>
            {{-- Email --}}
            <div class="flex justify-between items-center">
                <label for="email" class="text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="text-right border-none focus:ring-0 w-1/2">
            </div>
        </div>
    </form>
</div>
</body>
</html>
