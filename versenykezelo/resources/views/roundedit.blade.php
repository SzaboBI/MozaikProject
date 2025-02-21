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
            <div class="d-table full-width">
                <div class="d-table-row">
                    <div class="d-table-cell font-weight-bold">Forduló száma:</div>
                    <div class="d-table-cell">{{ $round-> roundNumber }}</div>
                </div>
            </div>
            <form action="/round/update/{{ $round->id }}" method="post" class="full-width">
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
                <table>
                    <caption>Fordulóhoz rendelt felhasználók</caption>
                    <thead>
                        <tr>
                            <th id="emailAddress">E-mail cím</th>
                            <th id="name">Név</th>
                            <th id="delete">Törlés</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($c_users as $user)
                            <tr>
                                <td headers="emailAddress">{{ $user->email }}</td>
                                <td headers="name">{{ $user->fullname }}</td>
                                <td headers="delete"><a href="/round/user/delete/{{ $round-> id }}/{{ $user-> email }}">Törlés</a></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <label for="email">Hozzáadandó felhasználó e-mail címe:</label>
                                <input type="email" name="email" id="email" list="emailList">
                                <datalist id="emailList">
                                    @foreach($users as $user)
                                        <option value="{{ $user->email }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </datalist>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Hozzáadás">
            </form>
        </div>
    </body>
</html>