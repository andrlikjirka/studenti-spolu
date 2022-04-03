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
                        Tato stránka systému je věnována všem vašim projektům. Můžete zde najít jak svoje autorské
                        projekty, tak i projekty ostatních autorů, na kterých spolupracujete. Zároveň lze na této
                        stránce vytvářet nové týmové projekty a upravovat ty existující.
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
                                    data-bs-target="#NewProjectModal">
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
                                        <!--
                                        <a href=" route('moje-projekty.show', $project_author->id_project) "
                                           class="text-decoration-none">

                                        </a>
                                        -->
                                        <h5 class="card-title text-primary">{{ $project_author->name }}</h5>
                                        <p class="card-text">{{ $project_author->abstract }}</p>
                                        <span class="badge rounded-pill
                                            @if($project_author->s_id_status == 1) {{ 'bg-warning' }}
                                        @elseif($project_author->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($project_author->s_id_status == 3) {{ 'bg-danger' }}
                                        @endif">
                                            {{ $project_author->s_name }}
                                        </span>
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
                                        <a href="{{ route('moje-projekty.show', $project_author->id_project) }}"
                                           class="btn btn-sm btn-warning" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square me-1"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Upravit projekt
                                        </a>
                                        <form action="{{ route('moje-projekty.destroy') }}" method="post"
                                              class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
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
                                        <h5 class="card-title text-primary">{{ $project_collab->name }}</h5>
                                        <p class="card-text">{{ $project_collab->abstract }}</p>
                                        <span class="badge rounded-pill
                                            @if($project_collab->s_id_status == 1) {{ 'bg-warning' }}
                                        @elseif($project_collab->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($project_collab->s_id_status == 3) {{ 'bg-danger' }} @endif">
                                            {{ $project_collab->s_name }}
                                        </span>

                                        <p class="mt-2 mb-0 small">Autor:
                                            <a href="" class="text-decoration-none">
                                                {{ $project_collab->u_first_name.' '.$project_collab->u_last_name }}
                                            </a>
                                        </p>

                                        <p class="mt-2 mb-0 small">Datum
                                            zveřejnění: {{ $project_collab->create_date }}</p>
                                    </div>
                                    <div class="card-footer py-2 px-4">
                                        <a href="{{ route('moje-projekty.show', $project_collab->id_project) }}"
                                           class="btn btn-sm btn-warning" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square me-1"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Upravit projekt
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="NewProjectModal" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1"
                 aria-labelledby="NewProjectLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Nový projekt</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-4">
                            <form id="new-project" action="{{ route('moje-projekty.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="new-name-project" class="form-label">
                                        Název projektu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="new-name-project" class="form-control"
                                           name="new-name-project" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new-abstract-project" class="form-label">Abstrakt</label>
                                    <textarea type="text" id="new-abstract-project" class="form-control" rows="3"
                                              name="new-abstract-project"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="new-description-project" class="form-label">
                                        Popis projektu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea type="text" id="new-description-project" class="form-control" rows="8"
                                              name="new-description-project" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušit
                            </button>
                            <button type="submit" form="new-project" class="btn btn-secondary" name="action"
                                    value="new-project">Uložit a zveřejnit
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <script type="text/javascript">
        // Vymazání obsahu modal okna při novém zobrazení stránky
        window.onpageshow = function (event) {
            document.getElementById("new-name-project").value = '';
            document.getElementById("new-abstract-project").value = '';
            document.getElementById("new-description-project").value = '';
            //var myModal = document.getElementById('NewProjectModal');
            //myModal.hide();
        };

    </script>

@endsection
