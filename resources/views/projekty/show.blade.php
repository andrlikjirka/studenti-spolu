@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px;">
        <div class="container px-5 py-5">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <a href="{{ url('/projekty') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Zpět na všechny projekty
                    </a>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <span class="badge rounded-pill bg-warning">Rozpracováno</span>
                    <p class="mt-2 mb-0 small">Autor: <a href="" class="text-decoration-none">Jiří Andrlík</a></p>
                    <p class="mt-1 mb-0 small">Datum zveřejnění: 2022-03-16</p>
                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-lg-10">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class="nav-link active " id="o-projektu-tab" data-bs-toggle="tab"
                                    data-bs-target="#o-projektu"
                                    type="button" role="tab" aria-controls="o-projektu" aria-selected="true">O projektu
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="soubory-tab" data-bs-toggle="tab" data-bs-target="#soubory"
                                    type="button" role="tab" aria-controls="soubory" aria-selected="false">Soubory
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="clenove-tymu-tab" data-bs-toggle="tab" data-bs-target="#clenove-tymu"
                                    type="button" role="tab" aria-controls="clenove-tymu" aria-selected="false">Členové týmu
                            </button>
                        </li>
                        <li class="nav-item " role="presentation">
                            <button class="nav-link" id="nabidky-spoluprace-tab" data-bs-toggle="tab" data-bs-target="#nabidky-spoluprace"
                                    type="button" role="tab" aria-controls="nabidky-spoluprace" aria-selected="false">Nabídky spolupráce
                            </button>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="tab-content" id="myTabContent">
                        <!-- O PROJEKTU TAB -->
                        <div class="tab-pane fade show active" id="o-projektu" role="tabpanel" aria-labelledby="o-projektu-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Popis </div>
                                <div class="card-body py-4 px-4">
                                    <p class="mb-3">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum
                                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                                        enim.
                                        Curabitur vitae diam non enim vestibulum interdum.
                                    </p>
                                    <p class="mb-3">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum
                                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet.</p>
                                    <ul>
                                        <li>Lorem ipsum</li>
                                        <li>Lorem ipsum</li>
                                        <li>Lorem ipsum</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- SOUBORY PROJEKTU TAB -->
                        <div class="tab-pane fade" id="soubory" role="tabpanel" aria-labelledby="soubory-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Soubory projektu</div>
                                <div class="card-body py-4 px-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Název souboru</th>
                                                <th>Typ souboru</th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td><a href="">Dokumentace projektu</a></td>
                                                <td>PDF</td>
                                            </tr>
                                            <tr>
                                                <td><a href="">Uživatelský manuál</a></td>
                                                <td>PDF</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CLENOVE TYMU PROJEKTU TAB -->
                        <div class="tab-pane fade" id="clenove-tymu" role="tabpanel" aria-labelledby="clenove-tymu-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Členové projektového týmu</div>
                                <div class="card-body py-4 px-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Jméno a příjmení</th>
                                                <th>Uživatelské jméno</th>
                                                <th>Role</th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td><a href="uzivatele-detail.php">Jiří Andrlík</a></td>
                                                <td>jandrlik</td>
                                                <td>Autor</td>
                                            </tr>
                                            <tr>
                                                <td><a href="">Karel Pokorný</a></td>
                                                <td>kpokorny</td>
                                                <td>Spolupracovník</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- NABIDKY SPOLUPRACE NA PROJEKTU TAB -->
                        <div class="tab-pane fade" id="nabidky-spoluprace" role="tabpanel" aria-labelledby="nabidky-spoluprace-tab">
                            <div class="card bg-white mt-4">
                                <div class="card-body p-4">
                                    <h5 class="card-title text-primary">Curabitur vitae diam</h5>
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                                        vestibulum
                                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                                        enim.
                                        Curabitur vitae diam non enim vestibulum interdum.
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-5">
                                            <div class="mb-2">
                                                <span class="small">Obor: </span>
                                                <span class="badge rounded-pill bg-light text-dark">Systémové inženýrství a informatika</span>
                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#NovaZadostSpolupraceModal">
                                                Žádost o spolupráci
                                            </button>
                                        </div>
                                        <div class="col-lg-6 col-md-7">
                                            <p class="mt-2 mb-2 small">Projekt:
                                                <a href="projekty-detail.php" class="text-decoration-none">
                                                    Lorem ipsum dolor sit amet
                                                </a>
                                            </p>
                                            <p class="mt-1 mb-0 small">Datum zveřejnění: 2022-03-16</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="NovaZadostSpolupraceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                        <span class="fw-bold">Lorem ipsum dolor sit amet</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <span>Obor: </span>
                                        <span class="badge rounded-pill bg-light text-dark">Systémové inženýrství a informatika</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Zpráva žádosti</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" form="nova-zadostSpoluprace" class="btn btn-primary" name="action"
                                    value="edit-article">Odeslat žádost
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
