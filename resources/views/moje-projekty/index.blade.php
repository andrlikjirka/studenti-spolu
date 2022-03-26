@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Moje projekty</h3>
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

                    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-autorske-projekty-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-autorske-projekty" type="button" role="tab"
                                    aria-controls="pills-autorske-projekty"
                                    aria-selected="true">Autorské projekty
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-spolupracovnicke-projekty-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-spolupracovnicke-projekty" type="button" role="tab"
                                    aria-controls="pills-spolupracovnicke-projekty"
                                    aria-selected="false">Spolupracovnické projekty
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- AUTORSKE PROJEKTY TAB -->
                        <div class="tab-pane fade show active" id="pills-autorske-projekty" role="tabpanel"
                             aria-labelledby="pills-autorske-projekty-tab">

                            <!-- Button trigger modal CHYBI MODAL-->
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#NovyProjektModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                                Nový projekt
                            </button>

                            <div class="card bg-white mb-3">
                                <div class="card-body p-4">
                                    <a href="./moje-projekty/1" class="text-decoration-none">
                                        <h5 class="card-title">Lorem ipsum dolor sit amet</h5>
                                    </a>
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum
                                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                                        enim.
                                        Curabitur vitae diam non enim vestibulum interdum.
                                    </p>
                                    <span class="badge rounded-pill bg-warning">Rozpracováno</span>
                                    <p class="mt-2 mb-0 small">Autor: <a href="" class="text-decoration-none">Jiří Andrlík</a></p>
                                    <p class="mt-1 mb-0 small">Datum zveřejnění: 2022-03-16</p>
                                </div>
                                <div class="card-footer py-2 px-4">
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                            Smazat projekt
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!-- SPOLUPRACOVNICKE PROJEKTY TAB -->
                        <div class="tab-pane fade" id="pills-spolupracovnicke-projekty" role="tabpanel"
                             aria-labelledby="pills-spolupracovnicke-projekty-tab">


                        </div>
                    </div>



                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="NovyProjektModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                 aria-labelledby="NovyProjektLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Nový projekt</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-4">
                            <form id="edit-project" action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="novy-nazev-projekt" class="form-label">Název
                                        projektu</label>
                                    <input type="text" id="novy-nazev-projekt" class="form-control"
                                           name="novy-nazev-projekt" required>
                                </div>
                                <div class="mb-3">
                                    <label for="novy-popis-projekt" class="form-label">Popis projektu</label>
                                    <textarea type="text" id="novy-popis-projekt" class="form-control" rows="8"
                                              name="novy-popis-projekt" required>
                                        </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="novy-stav-projekt" class="form-label">Stav projektu</label>
                                    <select id="novy-stav-projekt" class="form-select" aria-label="Default select example" required>
                                        <option selected disabled value="">Vyberte stav projektu</option>
                                        <option value="1">Dokončený</option>
                                        <option value="2">Rozpracovaný</option>
                                        <option value="3">Nedokončený</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                            <button type="button" class="btn btn-primary">Uložit a zveřejnit</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
