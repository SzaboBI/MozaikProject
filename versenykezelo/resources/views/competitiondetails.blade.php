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
            <a href="/edit/{{ $competition->name }}/{{ $competition->year }}">Módosítás</a>
            <div>
                <div class="d-table full-width">
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
            <table>
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
                            <td headers="details"><a href="/edit/{{ $round->id }}"></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
