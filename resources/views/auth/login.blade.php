<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - FitCity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;900&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <style>
        /* CSS stilleriniz aynı kalır */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        .app-container {
            max-width: 390px;
            width: 100%;
            min-height: 844px;
            background: white;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .content-wrapper {
            width: 100%;
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .app-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 25px;
            font-family: "SF Pro", sans-serif;
            position: absolute;
            top: 0;
            left: 0;
        }
        .app-header .time {
            font-size: 15px;
            font-weight: 590;
        }
        .app-header .icons {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .sign-in-title {
            color: #0A0615;
            font-size: 27px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            line-height: 32px;
            margin-bottom: 30px;
        }
        .input-group-custom {
            width: 100%;
            max-width: 358px;
            margin-bottom: 16px;
        }
        .form-control-custom {
            width: 100%;
            height: 48px;
            background: #F1F4F8;
            border-radius: 24px;
            border: 1px solid transparent; /* Hata durumu için border ekledik */
            padding: 0 24px;
            color: #404B52;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
        }
        .form-control-custom::placeholder {
            color: #404B52;
            opacity: 1;
        }
        .form-control-custom.is-invalid {
            border-color: #dc3545; /* Bootstrap'in hata rengi */
        }
        .sign-in-button {
            width: 100%;
            max-width: 358px;
            height: 48px;
            background: #282D32;
            box-shadow: 0px 6px 10px rgba(40, 45, 50, 0.2);
            border-radius: 25px;
            border: none;
            color: white;
            font-size: 17px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            line-height: 20px;
            margin-top: 16px;
            cursor: pointer;
        }
        .forgot-password {
            color: #404B52;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 24px;
            text-decoration: none;
            margin-top: 10px;
            align-self: flex-start; /* Sağa yaslamak yerine sola yasladık */
            margin-left: 20px; /* Biraz boşluk */
        }
        .signup-section {
            display: flex;
            align-items: center;
            margin-top: 50px; /* Boşluğu artırdık */
        }
        .signup-section .prompt {
            color: #404B52;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
            margin-right: 5px;
        }
        .signup-section .link {
            color: #282D32;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            text-decoration: none;
        }
        .home-indicator {
            width: 134px;
            height: 5px;
            background: black;
            border-radius: 100px;
            margin-bottom: 19px;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
            padding-left: 24px;
        }
        .session-status {
            width: 100%;
            max-width: 358px;
            padding: 10px;
            margin-bottom: 1rem;
            background-color: #d1e7dd; /* Yeşil tonu */
            color: #0f5132;
            border-color: #badbcc;
            border-radius: 0.5rem;
            text-align: center;
        }
        @media (max-width: 400px) {
            .app-container {
                width: 100%;
                min-height: 100vh;
                box-shadow: none;
            }
            .content-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="content-wrapper">
        {{-- DEĞİŞTİ: Sign In -> Giriş Yap --}}
        <h1 class="sign-in-title">Giriş Yap</h1>

        <x-auth-session-status class="session-status" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            @csrf

            <div class="input-group-custom">
                <input
                    id="login"
                    name="login"
                    type="text"
                    class="form-control-custom @error('login') is-invalid @enderror"
                    placeholder="Telefon / Email"
                    value="{{ old('login') }}"
                    required
                    autofocus>
                <x-input-error :messages="$errors->get('login')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control-custom @error('password') is-invalid @enderror"
                    {{-- DEĞİŞTİ: Password -> Parola --}}
                    placeholder="Parola"
                    required
                    autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    {{-- DEĞİŞTİ: Forgot Password? -> Şifreni mi unuttun? --}}
                    Şifreni mi unuttun?
                </a>
            @endif

            <button type="submit" class="sign-in-button">
                {{-- DEĞİŞTİ: Sign In -> Giriş Yap --}}
                Giriş Yap
            </button>
        </form>

        <div class="signup-section">
            {{-- DEĞİŞTİ: Don't have an account? -> Hesabın yok mu? --}}
            <span class="prompt">Hesabın yok mu?</span>
            {{-- DEĞİŞTİ: Sign Up -> Kayıt Ol --}}
            <a href="{{ route('register') }}" class="link">Kayıt Ol</a>
        </div>
    </div>
</div>
</body>
</html>
