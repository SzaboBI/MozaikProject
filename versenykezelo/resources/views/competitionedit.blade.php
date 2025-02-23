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
        @include('parts.nav')
                
        @if(Route::currentRouteName('editcompetition'))
                    <form action="/competition/update/{{ $competition->name }}/{{ $competition->year }}" method="post">
                @else
                    <form action="/competition/store" method="post">
                @endif
                    <h2>Verseny adatainak módosítása</h2>
                    @csrf
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
                        <label for="name">Verseny név:</label>
                        @if(Route::currentRouteName('editcompetition'))
                            <input type="text" name="name" id="name" value="{{ $competition->name }}">
                        @else
                            <input type="text" name="name" id="name">
                        @endif
                    </div>
                    <div class="form-item">
                        <label for="year">Verseny év:</label>
                        @if(Route::currentRouteName('editcompetition'))
                            <input type="number" name="year" id="year" value="{{ $competition->year }}">
                        @else
                            <input type="number" name="year" id="year">
                        @endif
                    </div>
                    <div class="form-item">
                        <label for="goodanswerpoint">Jó válaszért járó pont:</label>
                        @if(Route::currentRouteName('editcompetition'))
                            <input type="number" name="goodanswerpoint" id="goodanswerpoint" value="{{ $competition->pointsForGoodAnswer }}">
                        @else
                            <input type="number" name="goodanswerpoint" id="goodanswerpoint">
                        @endif
                    </div>
                    <div class="form-item">
                        <label for="badanswerpoint">Rossz válaszért járó pont:</label>
                        @if(Route::currentRouteName('editcompetition'))
                            <input type="number" name="badanswerpoint" id="badanswerpoint" value="{{ $competition->pointsForBadAnswer }}">
                        @else
                            <input type="number" name="badanswerpoint" id="badanswerpoint">
                        @endif
                    </div>
                    <div class="form-item">
                        <label for="emptyanswerpoint">Üres válaszért járó pont:</label>
                        @if(Route::currentRouteName('editcompetition'))
                            <input type="number" name="emptyanswerpoint" id="emptyanswerpoint" value="{{ $competition->pointsForEmptyAnswer }}">
                        @else
                            <input type="number" name="emptyanswerpoint" id="emptyanswerpoint">
                        @endif
                    </div>
                    @if(Route::currentRouteName('editcompetition'))
                        <input class="btn btn-primary" type="submit" value="Modosítás">
                    @else
                        <input class="btn btn-primary" type="submit" value="Létrehozás">
                    @endif
                </form>
    </body>
</html>