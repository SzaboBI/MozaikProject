<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @if(Session()->has('loginEmail'))
                        <a href="{{ route('competitions') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                        <a href="{{ url('logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log out</a>
                    @else
                        <a href="{{ route('welcome') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif
            @if(!Session()->has('loginEmail'))
            <form action="{{ route('login') }}" method="post">
                <h2>Bejelentkezés</h2>
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <label for="email">E-mail cím:</label>
                <input type="email" name="email" id="email"><br>
                <label for="passwd">Jelszó:</label>
                <input type="password" name="passwd" id="passwd"><br>
                <input type="submit" value="Bejelentkezés">
            </form>
            @else
            <table>
                <thead>
                    <tr>
                        <th id="competition_name">Verseny név</th>
                        <th id="competition_year">Verseny év</th>
                        <th id="details">Részletek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competitions->all() as $competition)  
                        <tr>
                            <td headers="competition_name">{{ $competition->name }}</td>
                            <td headers="competition_year">{{ $competition->year }}</td>
                            <td headers="details">
                                <a href="/competition/show/{{ $competition->name }}/{{ $competition->year }}">Megjelenít</a>
                                @if($isAdmin)
                                    <a href="/competition/edit/{{ $competition->name }}/{{ $competition->year }}">Módosítás</a>
                                    <a href="/competition/delete/{{ $competition->name }}/{{ $competition->year }}">Törlés</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="floating-bottom-right">
                <a class="btn btn-primary" href="/competition/create">Új verseny hozzáadása</a>
            </div>
        @endif
    </body>
</html>
