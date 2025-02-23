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
        <div class="justify-content-center">
        @if(!Session()->has('loginEmail'))
            <form id="login-form" action="{{ route('login') }}" method="post">
                <h2 class="text-center">Bejelentkezés</h2>
                @if ($errors->any())
                    <div class="error-box m-x-auto">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <div class="form-item">
                    <label class="font-weight-bold" for="email">E-mail cím:</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="form-item">
                    <label class="font-weight-bold" for="passwd">Jelszó:</label>
                    <input type="password" name="passwd" id="passwd">
                </div>
                <div>
                    <input type="submit" value="Bejelentkezés">
                </div>
            </form>
        @else
            <table id="competition-table">
                <caption class="font-weight-bold">Versenyek</caption>
                <thead>
                    <tr>
                        <th id="competition_name" class="text-center">Verseny név</th>
                        <th id="competition_year" class="text-center">Verseny év</th>
                        <th id="details" class="text-center">Részletek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competitions->all() as $competition)  
                        <tr>
                            <td headers="competition_name">{{ $competition->name }}</td>
                            <td headers="competition_year">{{ $competition->year }}</td>
                            <td headers="details">
                                <a class="sed-link btn btn-primary" href="/competition/show/{{ $competition->name }}/{{ $competition->year }}">Megjelenít</a>
                                @if($isAdmin)
                                    <a class="sed-link btn btn-primary" href="/competition/edit/{{ $competition->name }}/{{ $competition->year }}">Módosítás</a>
                                    <a class="sed-link btn btn-primary" href="/competition/delete/{{ $competition->name }}/{{ $competition->year }}">Törlés</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($isAdmin)
                <div class="floating-bottom-right">
                    <a class="btn btn-primary" href="/competition/create">Új verseny hozzáadása</a>
                </div>
            @endif
        @endif
        </div>
    </body>
</html>
