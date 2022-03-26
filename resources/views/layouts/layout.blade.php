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

                <a href="" class="btn btn-primary px-3 py-1 me-2">
                    Přihlásit
                </a>
                <a href="{{ url('./registrace') }}" class="btn btn-outline-primary px-3 py-1">
                    Registrace
                </a>

            <!--
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle px-3 py-1" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Jiří Andrlík
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ url('./muj-profil') }}">Můj profil</a></li>
                        <li><a class="dropdown-item" href="{{ url('./moje-projekty') }}">Moje projekty</a></li>
                        <li><a class="dropdown-item" href="{{ url('./zadosti-o-spolupraci') }}">Žádosti o spolupráci</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="">Administrace aplikace</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">
                                Odhlásit
                                <span class="bi bi-box-arrow-right ms-2"></span>
                            </a></li>
                    </ul>
                </div>
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

