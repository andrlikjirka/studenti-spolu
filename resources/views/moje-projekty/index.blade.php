@extends('layouts.layout')

<!-- POTVRZOVACI OKNO PRO SMAZANI PROJEKTU -->

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            @if(count($errors) > 0)
                <div class="alert alert-danger small text-center mb-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            @if(session('new_project_message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('new_project_message') }} </div>
            @endif

            @if(session('delete_project_message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('delete_project_message') }} </div>
            @endif

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
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

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#NovyProjektModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                                Nový projekt
                            </button>

                            @foreach($projects_author as $project_author)

                                <div class="card bg-white mb-3">
                                    <div class="card-body p-4">
                                        <a href="./moje-projekty/{{ $project_author->id_project }}"
                                           class="text-decoration-none">
                                            <h5 class="card-title">{{ $project_author->name }}</h5>
                                        </a>
                                        <p class="card-text">{{ $project_author->abstract }}</p>
                                        <span class="badge rounded-pill bg-warning">{{ $project_author->s_name }}</span>
                                        <!--
                                        <p class="mt-2 mb-0 small">Autor:
                                            <a href="" class="text-decoration-none">
                                                $project_author->u_first_name.' '.$project_author->u_last_name
                                            </a>
                                        </p>
                                        -->
                                        <p class="mt-2 mb-0 small ">Datum
                                            zveřejnění: {{ $project_author->create_date }}</p>
                                    </div>
                                    <div class="card-footer py-2 px-4">
                                        <form action="{{ route('moje-projekty.destroy') }}" method="post"
                                              class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <!-- input hidden ID -->
                                            <input type="hidden" name="delete_id_project"
                                                   value="{{ $project_author->id_project }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-x-circle me-1"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                                Smazat projekt
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <!-- SPOLUPRACOVNICKE PROJEKTY TAB -->
                        <div class="tab-pane fade" id="pills-spolupracovnicke-projekty" role="tabpanel"
                             aria-labelledby="pills-spolupracovnicke-projekty-tab">

                            @foreach($projects_collab as $project_collab)
                                <div class="card bg-white mb-3">
                                    <div class="card-body p-4">
                                        <a href="./moje-projekty/{{ $project_collab->id_project }}"
                                           class="text-decoration-none">
                                            <h5 class="card-title">{{ $project_collab->name }}</h5>
                                        </a>
                                        <p class="card-text">{{ $project_collab->abstract }}</p>
                                        <span class="badge rounded-pill bg-warning">{{ $project_collab->s_name }}</span>

                                        <p class="mt-2 mb-0 small">Autor:
                                            <a href="" class="text-decoration-none">
                                                 {{ $project_collab->u_first_name.' '.$project_collab->u_last_name }}
                                            </a>
                                        </p>

                                        <p class="mt-2 mb-0 small">Datum
                                            zveřejnění: {{ $project_collab->create_date }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="NovyProjektModal" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1"
                 aria-labelledby="NovyProjektLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Nový projekt</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-4">
                            <form id="novy-projekt" action="{{ route('moje-projekty.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="novy-projekt-nazev" class="form-label">
                                        Název projektu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="novy-projekt-nazev" class="form-control"
                                           name="novy-projekt-nazev" required>
                                </div>
                                <div class="mb-3">
                                    <label for="novy-projekt-abstrakt" class="form-label">Abstrakt</label>
                                    <textarea type="text" id="novy-projekt-abstrakt" class="form-control" rows="3"
                                              name="novy-projekt-abstrakt">
                                        </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="novy-projekt-popis" class="form-label">
                                        Popis projektu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea type="text" id="novy-projekt-popis" class="form-control" rows="8"
                                              name="novy-projekt-popis" required>
                                        </textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušit</button>
                            <button type="submit" form="novy-projekt" class="btn btn-secondary" name="action"
                                    value="novy-projekt">Uložit a zveřejnit
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
