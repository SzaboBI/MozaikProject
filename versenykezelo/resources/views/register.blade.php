<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('welcome') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        <form action="{{route('register')}}" method="post">
            @csrf
            <h2>Regisztráció</h2>
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <label for="userType">Felhasználó típusa:</label>
            <select name="userType" id="userType">
                <option value="basic">Felhasználó</option>
                <option value="admin">Admin</option>
            </select><br>
            <label for="email">E-mail cím:</label>
            <input type="email" name="email" id="email"><br>
            <label for="name">Teljes név:</label>
            <input type="text" name="name" id="name"><br>
            <label for="passwd">Jelszó:</label>
            <input type="password" name="passwd" id="passwd"><br>
            <label for="passwdAgain">Jelszó mégegyszer:</label>
            <input type="password" name="passwdAgain" id="passwdAgain"><br>
            <label for="postcode">Irányítószám:</label>
            <input type="number" name="postcode" id="postcode" min="1000" max="9999"><br>
            <label for="c">Település:</label>
            <input type="text" name="c" id="c"><br>
            <label for="street">Utca:</label>
            <input type="text" name="street" id="street"><br>
            <label for="number">Házszám:</label>
            <input type="number" name="house" id="house" min="1"><br>
            <label for="mobil">Telefon:</label>
            <input type="tel" name="mobil" id="mobil"><br>
            <input type="submit" value="Regisztracio">
        </form>
    </body>
</html>
