@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Nabídky spolupráce</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam feugiat, turpis at pulvinar
                        vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. Etiam quis quam.
                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <!-- FILTR (HLEDANI DNE OBORU) -->
                    <div class="mb-4">
                        <form id="hledat-uzivatele" action="" method="post" class="">
                            <div class="">
                                <input type="checkbox" id="match" name="match" value="true">
                                <label for="match">Zobrazit jen odpovídající nabídky spolupráce</label>
                                <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                        value="hledat-uzivatele">Zobrazit
                                </button>
                            </div>
                        </form>
                        <hr class="dropdown-divider">
                    </div>

                    <div class="card bg-white mb-3">
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
                                        <a href="./projekty/1" class="text-decoration-none">
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
