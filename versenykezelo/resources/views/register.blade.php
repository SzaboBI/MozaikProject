<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/styles.css'); }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        @include('parts.nav')
        <div>
            <form class="m-x-auto" action="{{route('register')}}" method="post">
            @csrf
            <h2 class="text-center">Regisztráció</h2>
            @if ($errors->any())
                <div class="error-box m-x-auto">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-item">
                <label class="font-weight-bold" for="userType">Felhasználó típusa:</label>
                <select name="userType" id="userType">
                    <option value="basic">Felhasználó</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="email">E-mail cím:</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="name">Teljes név:</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="passwd">Jelszó:</label>
                <input type="password" name="passwd" id="passwd">
            </div>
            <div class="form-item">
                <label for="passwdAgain">Jelszó mégegyszer:</label>
                <input type="password" name="passwdAgain" id="passwdAgain">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="postcode">Irányítószám:</label>
                <input type="number" name="postcode" id="postcode" min="1000" max="9999">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="c">Település:</label>
                <input type="text" name="c" id="c">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="street">Utca:</label>
                <input type="text" name="street" id="street">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="number">Házszám:</label>
                <input type="number" name="house" id="house" min="1">
            </div>
            <div class="form-item">
                <label class="font-weight-bold" for="mobil">Telefon:</label>
                <input type="tel" name="mobil" id="mobil">
            </div>
            <input type="submit" value="Regisztracio">
        </form>
        </div>
    </body>
</html>
