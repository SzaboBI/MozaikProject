<div class="d-table w-100">
    <div class="d-table-row">
        @if(Session()->has('loginEmail'))
            <div class="d-table-cell w-50">
                @if(Route::currentRouteName() != 'competitions')
                    <a href="{{ route('competitions') }}" class="w-100 d-block text-center text-sm text-gray-700 dark:text-gray-500">
                @else
                    <div class="w-100 text-center linkdiv text-sm text-gray-700 dark:text-gray-500">
                @endif
                    Főoldal
                @if(Route::currentRouteName() != 'competitions')
                    </a>
                @else
                    </div>
                @endif
            </div>
            <div class="d-table-cell w-50">
                <a href="{{ url('logout') }}" class="w-100 d-block text-center text-sm text-gray-700 dark:text-gray-500">Kijelentkezés</a>
            </div>
        @else
            <div class="d-table-cell w-50">
                @if(Route::currentRouteName() != 'welcome')
                    <a href="{{ route('welcome') }}" class="w-100 d-block text-center text-sm text-gray-700 dark:text-gray-500">
                @else
                    <div class="w-100 text-center linkdiv text-sm text-gray-700 dark:text-gray-500">
                @endif
                    Bejelentkezés
                @if(Route::currentRouteName() != 'welcome')
                    </a>
                @else
                    </div>
                @endif
            </div>
            <div class="d-table-cell w-50">
                @if(Route::currentRouteName() != 'showRegister')
                    <a href="{{ route('register') }}" class="ml-4 w-100 d-block text-center text-sm text-gray-700 dark:text-gray-500">
                @else
                    <div class="w-100 text-center linkdiv text-sm text-gray-700 dark:text-gray-500">
                @endif
                    Regisztráció
                @if(Route::currentRouteName() != 'showRegister')
                    </a>
                @else
                    </div>
                @endif
            </div> 
        @endif
    </div>
</div>