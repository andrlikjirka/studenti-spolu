@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px;">
        <div class="container px-5 py-5">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <a href="{{ url('uzivatele') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Zpět na všechny uživatele</a>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="">Jiří Andrlík</h3>
                    <a href="mailto::andrlik.jirka@gmail.com" type="button" class="btn btn-sm btn-outline-secondary mt-2">
                        <i class="bi bi-envelope-fill"></i>
                        Kontaktovat e-mailem
                    </a>
                    <div class="mt-3">Fakulta ekonomická</div>
                    <div class="">
                        <span class="">Znalosti a dovednosti v oborech:&nbsp;</span>
                        <span class="badge bg-primary">Informační management</span>
                        <span class="badge bg-primary">Systémové inženýrství a informatika</span>
                    </div>
                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-lg-10">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class="nav-link active " id="o-mne-tab" data-bs-toggle="tab"
                                    data-bs-target="#o-mne"
                                    type="button" role="tab" aria-controls="o-mne" aria-selected="true">O mně
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="projekty-tab" data-bs-toggle="tab" data-bs-target="#projekty"
                                    type="button" role="tab" aria-controls="projekty" aria-selected="false">Projekty
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="o-mne" role="tabpanel" aria-labelledby="o-mne-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Popis uživatele</div>
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
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="projekty" role="tabpanel" aria-labelledby="projekty-tab">
                            <p class="my-3">Lorem ipsum dolor sit amet elit:</p>
                            <div class="card bg-white my-3">
                                <div class="card-body p-4">
                                    <a href="./projekty/1" class="text-decoration-none">
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
                                    <p class="mt-2 mb-0">Autor: <a href="" class="text-decoration-none">Jiří Andrlík</a></p>
                                    <p class="mt-1 mb-0 small">Datum zveřejnění: 2022-03-16</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
