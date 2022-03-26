@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-3 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Žádosti o spolupráci</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                        vestibulum
                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                        enim.
                        Curabitur interdum.

                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <!-- FILTR (HLEDANI DNE PROJEKTU) -->
                    <div class="mb-4">
                        <form id="hledat-zadosti" action="" method="post" class="">
                            <div class="">
                                <select class="form-select-sm" aria-label="Default select example" >
                                    <option selected value=""></option>
                                    <option value="1">Lorem ipsum dolor sit amet</option>
                                    <option value="2">Lorem ipsum dolor sit amet 2</option>
                                    <option value="3">Lorem ipsum dolor sit amet 3</option>
                                    <option value="4">Lorem ipsum dolor sit amet 4</option>
                                </select>
                                <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                        value="hledat-uzivatele">Hledat žádosti dle projektu
                                </button>
                            </div>
                        </form>
                        <hr class="dropdown-divider">
                    </div>

                    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-prijate-zadosti-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-prijate-zadosti" type="button" role="tab"
                                    aria-controls="pills-prijate-zadosti"
                                    aria-selected="true">Přijaté žádosti
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-odeslane-zadosti-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-odeslane-zadosti" type="button" role="tab"
                                    aria-controls="pills-odeslane-zadosti"
                                    aria-selected="false">Odeslané žádosti
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- PRIJATE ZADOSTI TAB -->
                        <div class="tab-pane fade show active" id="pills-prijate-zadosti" role="tabpanel"
                             aria-labelledby="pills-prijate-zadosti-tab">
                            <div class="card bg-white mb-3">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-8">
                                            <p class="mb-1 small">Nabídka spolupráce:
                                                <a href="" class="text-decoration-none">
                                                    Curabitur vitae diam
                                                </a>
                                            </p>
                                        </div>
                                        <div class="mb-1 col-lg-5">
                                            <span class="small">Obor: </span>
                                            <span class="badge rounded-pill bg-light text-dark">Systémové inženýrství a informatika</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-lg-7">
                                            <span class="small">Projekt: </span>
                                            <span class="small"><a href="./projekty/1" class="text-decoration-none">Lorem ipsum dolor sit amet</a></span>
                                        </div>
                                        <div class="col-lg-5 col-md-4">
                                            <p class="mb-0 small">Datum žádosti: 2022-03-21</p>
                                        </div>
                                    </div>
                                    <div class="mb-2 col-lg-7">
                                        <span class="small">Uživatel: </span>
                                        <span class="small"><a href="" class="text-decoration-none">Karel Nový</a></span>
                                    </div>
                                    <span class="badge rounded-pill bg-secondary">Čeká na vyřízení</span>
                                    <hr class="dropdown-divider">
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet, <br>consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum ullamcorper ultricies, lacus quam ultricies odio.
                                        <br>Vitae placerat pede sem.
                                    </p>

                                </div>
                                <div class="card-footer py-2 px-4">
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-1" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg>
                                            Přijmout žádost
                                        </button>
                                    </form>
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                            Zamítnout žádost
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ODESLANE ZADOSTI TAB -->
                        <div class="tab-pane fade" id="pills-odeslane-zadosti" role="tabpanel"
                             aria-labelledby="pills-odeslane-zadosti-tab">
                            <div class="card bg-white mb-3">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-8">
                                            <p class="mb-1 small">Nabídka spolupráce:
                                                <a href="nabidky.php" class="text-decoration-none">
                                                    Curabitur vitae diam
                                                </a>
                                            </p>
                                        </div>
                                        <div class="mb-1 col-lg-5">
                                            <span class="small">Obor: </span>
                                            <span class="badge rounded-pill bg-light text-dark">Projektový management</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-lg-7">
                                            <span class="small">Projekt: </span>
                                            <span class="small"><a href="projekty-detail.php" class="text-decoration-none">Lorem ipsum dolor sit amet 2</a></span>
                                        </div>
                                        <div class="col-lg-5 col-md-4">
                                            <p class="mb-0 small">Datum žádosti: 2022-03-21</p>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill bg-secondary">Čeká na vyřízení</span>
                                    <hr class="dropdown-divider">
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet, <br>consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum ullamcorper ultricies, lacus quam ultricies odio.
                                        <br>Vitae placerat pede sem.
                                    </p>

                                </div>
                                <div class="card-footer py-2 px-4">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#UpravitZadostSpolupraceModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                        Upravit žádost
                                    </button>
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                            Zrušit žádost
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="UpravitZadostSpolupraceModal" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Žádost o spolupráci</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="nova-zadostSpoluprace" action="">
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <span>Projekt: </span>
                                        <span class="fw-bold">Lorem ipsum dolor sit amet 2</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <span>Obor: </span>
                                        <span class="badge rounded-pill bg-light text-dark">Projektový management</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Zpráva žádosti</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" required>Lorem ipsum dolor sit amet,
consectetuer adipiscing elit. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio.
Vitae placerat pede sem.</textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" form="nova-zadostSpoluprace" class="btn btn-warning" name="action"
                                    value="edit-article">Upravit žádost
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
