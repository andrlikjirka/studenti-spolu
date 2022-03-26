@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <a href="./moje-projekty"><i class="bi bi-arrow-left me-3 "></i>Zpět na moje projekty</a>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Úprava projektu</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                        vestibulum
                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                        enim.
                        Curabitur interdum.
                    </p>
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
                            <button class="nav-link" id="clenove-tymu-tab" data-bs-toggle="tab"
                                    data-bs-target="#clenove-tymu"
                                    type="button" role="tab" aria-controls="clenove-tymu" aria-selected="false">Členové týmu
                            </button>
                        </li>
                        <li class="nav-item " role="presentation">
                            <button class="nav-link" id="nabidky-spoluprace-tab" data-bs-toggle="tab"
                                    data-bs-target="#nabidky-spoluprace"
                                    type="button" role="tab" aria-controls="nabidky-spoluprace" aria-selected="false">
                                Nabídky
                                spolupráce
                            </button>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-9">
                    <!-- Informace o projektu -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="o-projektu" role="tabpanel"
                             aria-labelledby="o-projektu-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Informace o projektu</div>
                                <div class="card-body py-4 px-4">
                                    <form id="upravit-projekt" action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="upravit-nazev-projekt" class="form-label">Název
                                                projektu</label>
                                            <input type="text" id="upravit-nazev-projekt" class="form-control"
                                                   name="upravit-nazev-projekt" value="Lorem ipsum dolor sit amet" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="upravit-popis-projekt" class="form-label">Popis projektu</label>
                                            <textarea type="text" id="upravit-popis-projekt" class="form-control" rows="8"
                                                      name="upravit-popis-projekt" required>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Curabitur vitae diam non enim vestibulum interdum.
                                        </textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="upravit-stav-projek" class="form-label">Stav projektu</label>
                                            <select id="upravit-stav-projekt" class="form-select"
                                                    aria-label="Default select example" required>
                                                <option disabled value="">Vyberte stav projektu</option>
                                                <option value="1">Dokončený</option>
                                                <option value="2" selected>Rozpracovaný</option>
                                                <option value="3">Nedokončený</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning" name="action"
                                                value="upravit-projekt">Upravit informace o projektu
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Soubory projektu -->
                        <div class="tab-pane fade" id="soubory" role="tabpanel" aria-labelledby="soubory-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Soubory projektu</div>
                                <div class="card-body py-4 px-4">
                                    <form id="soubory-projekt" action="" method="post" enctype="multipart/form-data">
                                        <label for="formFileMultiple" class="form-label">Výběr souborů</label>
                                        <div class="row">
                                            <div class="col-lg-9 col-md-8">
                                                <div class="mb-3">
                                                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <button type="submit" class="btn btn-primary" name="action"
                                                        value="upravit-projekt">Nahrát soubory
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr class="dropdown-divider">
                                    <div class="table-responsive mt-4">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Název souboru</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td><a href="">Dokumentace projektu</a></td>
                                                <td>
                                                    <form action="" class="m-0 p-0">
                                                        <!-- input hidden -->
                                                        <button type='submit'
                                                                class='btn btn-sm btn-outline-danger m-0 py-1 px-2'
                                                                onclick='deleteReviewer(event)'>
                                                            Odebrat
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><a href="">Uživatelský manuál</a></td>
                                                <td>
                                                    <form action="" class="m-0 p-0">
                                                        <!-- input hidden -->
                                                        <button type='submit'
                                                                class='btn btn-sm btn-outline-danger m-0 py-1 px-2'
                                                                onclick='deleteReviewer(event)'>
                                                            Odebrat
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Clenove tymu -->
                        <div class="tab-pane fade" id="clenove-tymu" role="tabpanel" aria-labelledby="clenove-tymu-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Správa členů týmu</div>
                                <div class="card-body py-4 px-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Jméno a příjmení</th>
                                                <th>Uživatelské jméno</th>
                                                <th>Role</th>
                                                <th style="width: 5%"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td>Jiří Andrlík</td>
                                                <td>jandrlik</td>
                                                <td>Autor</td>
                                                <td>
                                                    <!--
                                                    <form action="" class="m-0 p-0">
                                                        input hidden
                                                    <button type='submit'
                                                            class='btn btn-sm btn-outline-danger m-0 p-0'
                                                            onclick='deleteReviewer(event)'>
                                                        <i class='bi bi-x-circle p-1 m-0'></i>
                                                    </button>
                                                    </form>
                                                    -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Karel Pokorný</td>
                                                <td>kpokorny</td>
                                                <td>Spolupracovník</td>
                                                <td>
                                                    <form action="" class="m-0 p-0">
                                                        <!-- input hidden -->
                                                        <button type='submit'
                                                                class='btn btn-sm btn-outline-danger m-0 py-1 px-2'
                                                                onclick='deleteReviewer(event)'>
                                                            Odebrat
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nabidky spoluprace -->
                        <div class="tab-pane fade" id="nabidky-spoluprace" role="tabpanel"
                             aria-labelledby="nabidky-spoluprace-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Správa nabídek spolupráce na projektu</div>
                                <div class="card-body py-4 px-4">
                                    <!-- Button trigger modal CHYBI MODAL-->
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target="#NovaNabidkaSpolupraceModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                        Nová nabídka spolupráce
                                    </button>
                                    <div class="table-responsive">
                                        <table class="table table-sm mt-4">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Název nabídky</th>
                                                <th>Obor</th>
                                                <th>Stav</th>
                                                <th>Akce</th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td>Curabitur vitae diam diam</td>
                                                <td><span class="badge rounded-pill bg-light text-dark">Systémové inženýrství a informatika</span>
                                                </td>
                                                <td><span class="badge rounded-pill bg-success">Aktivní</span></td>
                                                <td>
                                                    <!--Button trigger modal -->
                                                    <button type="button" class="btn btn-warning btn-sm d-inline-block"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#UpravitNabidkaSpolupraceModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                        Upravit
                                                    </button>
                                                    <form action="" class="m-0 p-0 d-inline-block">
                                                        <!-- input hidden -->
                                                        <button type='submit'
                                                                class='btn btn-sm btn-danger'
                                                                onclick='deleteReviewer(event)'>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                            </svg>
                                                            Smazat
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal NOVA NABIDKA -->
        <div class="modal fade" id="NovaNabidkaSpolupraceModal" data-bs-backdrop="static" tabindex="-1"
             aria-labelledby="NovaNabidkaSpolupraceLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nová nabídka spolupráce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <form action="" id="nova-nabidkaSpoluprace">
                            <div class="mb-3">
                                <label for="nazev-nabidkaSpoluprace" class="form-label">Název nabídky spolupráce</label>
                                <input type="text" class="form-control" id="nazev-nabidkaSpoluprace"
                                       placeholder="Zadejte název nabídky spolupráce (např. Vývojář mobilních aplikací)"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label for="obor-nabidkaSpoluprace" class="form-label">Obor nabídky spolupráce</label>
                                <select id="obor-nabidkaSpoluprace" class="form-select" aria-label="Obor spolupráce"
                                        required>
                                    <option selected disabled value="">Vyberte obor spolupráce</option>
                                    <option value="1">Informační management</option>
                                    <option value="2">Informatika</option>
                                    <option value="3">Podniková ekonomika</option>
                                    <option value="4">Projektový management</option>
                                    <option value="5">Systémové inženýrství a informatika</option>
                                    <option value="6">Výpočetní technika</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="popis-nabidkaSpoluprace" class="form-label">Popis nabídky spolupráce</label>
                                <textarea class="form-control" id="popis-nabidkaSpoluprace" rows="6" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" form="nova-nabidkaSpoluprace" class="btn btn-primary" name="action"
                                value="nova-nabidkaSpoluprace">Uložit a zveřejnit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal UPRAVA NABIDKY -->
        <div class="modal fade" id="UpravitNabidkaSpolupraceModal" data-bs-backdrop="static" tabindex="-1"
             aria-labelledby="UpravitNabidkaSpolupraceLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upravit nabídku spolupráce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <form action="" id="upravit-nabidkaSpoluprace">
                            <div class="mb-3">
                                <label for="nazev-nabidkaSpoluprace" class="form-label">Název nabídky spolupráce</label>
                                <input type="text" class="form-control" id="nazev-nabidkaSpoluprace"
                                       placeholder="Zadejte název nabídky spolupráce (např. Vývojář mobilních aplikací)"
                                       value="Curabitur vitae diam diam" required>
                            </div>
                            <div class="mb-3">
                                <label for="stav-nabidkaSpoluprace" class="form-label">Stav nabídky spolupráce</label>
                                <select id="stav-nabidkaSpoluprace" class="form-select" aria-label="Stav nabídky spolupráce"
                                        required>
                                    <option selected disabled value="">Vyberte stav nabídky spolupráce</option>
                                    <option value="1">Aktivní</option>
                                    <option value="2">Neaktivní</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="obor-nabidkaSpoluprace" class="form-label">Obor nabídky spolupráce</label>
                                <select id="obor-nabidkaSpoluprace" class="form-select" aria-label="Obor spolupráce"
                                        required>
                                    <option selected disabled value="">Vyberte obor spolupráce</option>
                                    <option value="1">Informační management</option>
                                    <option value="2">Informatika</option>
                                    <option value="3">Podniková ekonomika</option>
                                    <option value="4">Projektový management</option>
                                    <option value="5" selected>Systémové inženýrství a informatika</option>
                                    <option value="6">Výpočetní technika</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="popis-nabidkaSpoluprace" class="form-label">Popis nabídky spolupráce</label>
                                <textarea class="form-control" id="popis-nabidkaSpoluprace" rows="6" required>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Curabitur vitae diam non enim vestibulum interdum.
                            </textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" form="upravit-nabidkaSpoluprace" class="btn btn-warning" name="action"
                                value="upravit-nabidkaSpoluprace">Uložit úpravy
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
