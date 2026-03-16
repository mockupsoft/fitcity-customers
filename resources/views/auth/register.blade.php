<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - FitCity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;900&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <style>
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
            padding-top: 80px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .sign-up-title {
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
            border: 1px solid transparent;
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
            border-color: #dc3545;
        }
        .sign-up-button {
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
        .signin-section {
            display: flex;
            align-items: center;
            margin-top: 50px;
        }
        .signin-section .prompt {
            color: #404B52;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
            margin-right: 5px;
        }
        .signin-section .link {
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
        @media (max-width: 400px) {
            .app-container {
                width: 100%;
                min-height: 100vh;
                box-shadow: none;
            }
            .content-wrapper {
                padding: 15px;
                padding-top: 60px;
            }
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="content-wrapper">
        <h1 class="sign-up-title">Kayıt Ol</h1>

        <form method="POST" action="{{ route('register') }}" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            @csrf

            <div class="input-group-custom">
                <input id="name" name="name" type="text" class="form-control-custom @error('name') is-invalid @enderror"
                       placeholder="Ad Soyad" value="{{ old('name') }}" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input id="email" name="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" placeholder="E-posta" value="{{ old('email') }}" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input id="phone" name="phone" type="tel" class="form-control-custom @error('phone') is-invalid @enderror" placeholder="Telefon" value="{{ old('phone') }}" required autocomplete="tel">
                <x-input-error :messages="$errors->get('phone')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input
                    id="tc_no"
                    name="tc_no"
                    type="text"
                    class="form-control-custom @error('tc_no') is-invalid @enderror"
                    placeholder="TC Kimlik Numarası (İsteğe Bağlı)"
                    value="{{ old('tc_no') }}"
                    autocomplete="off"
                    maxlength="11">
                <x-input-error :messages="$errors->get('tc_no')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input
                    id="birth_date"
                    name="birth_date"
                    type="text"
                    class="form-control-custom @error('birth_date') is-invalid @enderror"
                    placeholder="Doğum Tarihi (İsteğe Bağlı)"
                    value="{{ old('birth_date') }}"
                    autocomplete="bday"
                    onfocus="(this.type='date')"
                    onblur="(this.type='text')">
                <x-input-error :messages="$errors->get('birth_date')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input id="password" name="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" placeholder="Parola" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom">
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control-custom" placeholder="Parolayı Onayla" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback" />
            </div>

            <div class="input-group-custom" style="font-size: 12px; text-align: center; color: #404B52;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label" for="terms">
                        <a href="{{ route('terms.service') }}" class="link">Kullanım Koşulları</a>'nı ve
                        <a href="{{ route('privacy.policy') }}"  class="link">Gizlilik Politikası</a>'nı okudum ve kabul ediyorum.
                    </label>
                </div>
                <x-input-error :messages="$errors->get('terms')" class="invalid-feedback" />
            </div>

            <button type="submit" class="sign-up-button">
                Kayıt Ol
            </button>
        </form>

        <div class="signin-section">
            <span class="prompt">Zaten hesabın var mı?</span>
            <a href="{{ route('login') }}" class="link">Giriş Yap</a>
        </div>
    </div>
</div>
</body>
</html>

