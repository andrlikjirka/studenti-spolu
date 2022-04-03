<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="jandrlik">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>studenti.spolu</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon-32x32.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

@php
    $loggedUser = \Illuminate\Support\Facades\Auth::user();
    echo $loggedUser;
@endphp

<!-- Navbar-->
<header>
    <nav id="" class="navbar navbar-expand-lg navbar-light bg-white fixed-top py-3 shadow-sm">
        <div class="container px-5">
            <a href="{{ url('/') }}" class="navbar-brand text-primary fw-bold font-monospace">studenti|spolu</a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav m-auto ">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ url('./projekty') }}">Projekty</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ url('./nabidky-spoluprace') }}">Nabídky spolupráce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('./uzivatele') }}">Uživatelé</a>
                    </li>
                </ul>

                @if(\Illuminate\Support\Facades\Auth::check())
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle px-3 py-1" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $loggedUser->first_name.' '.$loggedUser->last_name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('./muj-profil') }}">Můj profil</a></li>
                            <li><a class="dropdown-item" href="{{ url('./moje-projekty') }}">Moje projekty</a></li>
                            <li><a class="dropdown-item" href="{{ url('./zadosti-o-spolupraci') }}">Žádosti o
                                    spolupráci</a></li>
                            @if($loggedUser->id_right == 1)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="">Administrace aplikace</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('odhlaseni') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Odhlásit
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right ms-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('prihlaseni') }}" class="btn btn-primary px-3 py-1 me-2">
                        Přihlásit
                    </a>
                    <a href="{{ route('registrace') }}" class="btn btn-outline-primary px-3 py-1">
                        Registrace
                    </a>
            @endif

            <!--

                -->


            </div>
        </div>
    </nav>
</header>

@yield('content')

<!-- Paticka -->
<footer class="pt-4 pb-2 bg-white bg-gradient">
    <div class="container px-5 text-center">

        <div class="small text-secondary">
            <p>&copy; 2022, Jiří Andrlík</p>
        </div>
    </div>
</footer>


<!-- Javascripty -->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>

