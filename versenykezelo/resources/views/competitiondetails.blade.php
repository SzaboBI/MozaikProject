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
        <div>
            <div id="cd-m" class="d-table full-width">
                @if($isAdmin == 1)
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <a class="text-center btn btn-primary sed-btn" href="/competition/edit/{{ $competition->name }}/{{ $competition->year }}">Módosítás</a>
                        </div>
                        <div class="d-table-cell">
                            <a class="text-center btn btn-primary sed-btn" href="/competition/delete/{{ $competition->name }}/{{ $competition->year }}">Törlés</a>
                        </div>
                    </div>
                @endif
                <div class="d-table-row">
                    <div class="d-table-cell font-weight-bold">Verseny neve:</div>
                    <div class="d-table-cell">{{ $competition->name }}</div>
                </div>
                <div class="d-table-row">
                    <div class="d-table-cell font-weight-bold">Verseny év:</div>
                    <div class="d-table-cell">{{ $competition->year }}</div>
                </div>
            </div>
        </div>
        @if($isAdmin == 1)
            <form action="/rounds/store/{{ $competition->name }}/{{ $competition->year }}" method="post">
                @csrf
                @foreach ($errors->all() as $error)
                    <div class="error-box m-x-auto">
                        <ul>
                            <li>{{ $error }}</li>
                        </ul>
                    </div>
                @endforeach
            @endif
                <table>
                    <caption class="font-weight-bold">Versenyhez tartozó fordulók</caption>
                    <thead>
                        <tr>
                            <th id="roundNumber">Forduló sorszáma</th>
                            <th id="details">Részletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rounds as $round)
                            <tr>
                                <td headers="roundNumber">{{ $round->roundNumber }}</td>
                                @if($isAdmin == 1)
                                    <td headers="details">
                                        <a class="sed-link" href="/round/edit/{{ $round->id }}">Felhasználók hozzáadás/ eltávolítása</a>
                                        <a class="sed-link" href="/rounds/delete/{{ $round->id }}">Törlés</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @if($isAdmin == 1)
                        <tr>
                            <td headers="roundNumber" colspan="2">
                                <div class="form-item">
                                    <label for="rNumber">Forduló sorszáma:</label>
                                    <input type="number" name="rNumber" id="rNumber" min="1">
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            @if($isAdmin == 1)
                <input type="submit" class="btn btn-primary" value="Hozzáadás">
            </form>
            @endif
    </body>
</html>
