<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @if(Session()->has('loginEmail'))
                        <a href="{{ route('competitions') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                        <a href="{{ url('logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log out</a>
                    @endif
                </div>
            @endif
                @if(Route::currentRouteName('editcompetition'))
                    <form action="/competition/update/{{ $competition->name }}/{{ $competition->year }}" method="post">
                @else
                    <form action="/competition/store" method="post">
                @endif
                    @csrf
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <label for="name">Verseny név:</label>
                    @if(Route::currentRouteName('editcompetition'))
                        <input type="text" name="name" id="name" value="{{ $competition->name }}">
                    @else
                        <input type="text" name="name" id="name">
                    @endif
                    <br>
                    <label for="year">Verseny év:</label>
                    @if(Route::currentRouteName('editcompetition'))
                        <input type="number" name="year" id="year" value="{{ $competition->year }}">
                    @else
                        <input type="number" name="year" id="year">
                    @endif
                    <br>
                    <label for="goodanswerpoint">Jó válaszért járó pont:</label>
                    @if(Route::currentRouteName('editcompetition'))
                        <input type="number" name="goodanswerpoint" id="goodanswerpoint" value="{{ $competition->pointsForGoodAnswer }}">
                    @else
                        <input type="number" name="goodanswerpoint" id="goodanswerpoint">
                    @endif
                    <br>
                    <label for="badanswerpoint">Rossz válaszért járó pont:</label>
                    @if(Route::currentRouteName('editcompetition'))
                        <input type="number" name="badanswerpoint" id="badanswerpoint" value="{{ $competition->pointsForBadAnswer }}">
                    @else
                    <input type="number" name="badanswerpoint" id="badanswerpoint">
                    @endif
                    <br>
                    <label for="emptyanswerpoint">Üres válaszért járó pont:</label>
                    @if(Route::currentRouteName('editcompetition'))
                        <input type="number" name="emptyanswerpoint" id="emptyanswerpoint" value="{{ $competition->pointsForEmptyAnswer }}">
                    @else
                    <input type="number" name="emptyanswerpoint" id="emptyanswerpoint">
                    @endif
                    <br>
                    <input type="submit" value="Modosítás">
                </form>
        </div>
    </body>
</html>