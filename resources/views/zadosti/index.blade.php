@extends('layouts.layout')

@section('content')
    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">

            @if(session('edit_request_message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('edit_request_message') }} </div>
            @endif
            @if(session('error_edit_request_message'))
                <div class="alert alert-danger small text-center mb-5"> {{ session('error_edit_request_message') }} </div>
            @endif

            @if(session('delete_request_message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('delete_request_message') }} </div>
            @endif
            @if(session('error_delete_request_message'))
                <div class="alert alert-danger small text-center mb-5"> {{ session('error_delete_request_message') }} </div>
            @endif

            <div class="row mb-3 justify-content-center">
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
                    <!-- FILTR (HLEDANI DNE PROJEKTU) -->
                    <div class="mb-4">
                        <form id="hledat-zadosti" action="" method="post" class="">
                            <div class="">
                                <select class="form-select-sm" aria-label="Default select example">
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
                                        <span class="small"><a href=""
                                                               class="text-decoration-none">Karel Nový</a></span>
                                    </div>
                                    <span class="badge rounded-pill bg-secondary">Čeká na vyřízení</span>
                                    <hr class="dropdown-divider">
                                    <p class="card-text">
                                        Lorem ipsum dolor sit amet, <br>consectetuer adipiscing elit. Integer rutrum,
                                        orci
                                        vestibulum ullamcorper ultricies, lacus quam ultricies odio.
                                        <br>Vitae placerat pede sem.
                                    </p>

                                </div>
                                <div class="card-footer py-2 px-4">
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-check-circle me-1"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path
                                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg>
                                            Přijmout žádost
                                        </button>
                                    </form>
                                    <form action="" class="d-inline-block">
                                        <!-- input hidden ID -->
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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
                            @foreach($requests_sent as $request_sent)
                                <div class="card bg-white mb-3">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-8">
                                                <p class="mb-1 small">Nabídka spolupráce:
                                                    <a href="{{ route('nabidky-spoluprace.show', $request_sent->o_id_offer) }}"
                                                       class="text-decoration-none">
                                                        {{ $request_sent->o_name }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="mb-1 col-lg-5">
                                                <span class="small">Obor: </span>
                                                <span
                                                    class="badge rounded-pill bg-light text-dark">{{ $request_sent->f_name }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-2 col-lg-7">
                                                <span class="small">Projekt: </span>
                                                <span class="small"><a
                                                        href="{{ route('projekty.show', $request_sent->p_id_project) }}"
                                                        class="text-decoration-none">
                                                        {{ $request_sent->p_name }}</a>
                                                </span>
                                            </div>
                                            <div class="col-lg-5 col-md-4">
                                                <p class="mb-0 small">Datum
                                                    žádosti: {{ $request_sent->r_create_date }}</p>
                                            </div>
                                        </div>
                                        <span class="badge rounded-pill
                                            @if($request_sent->s_id_status == 1) {{ 'bg-secondary' }}
                                        @elseif($request_sent->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($request_sent->s_id_status == 3) {{ 'bg-danger' }}
                                        @endif">{{ $request_sent->s_name }}</span>
                                        <hr class="dropdown-divider">
                                        <p class="card-text">
                                            {{ $request_sent->r_message }}
                                        </p>

                                    </div>
                                    <div class="card-footer py-2 px-4">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#EditRequestCooperationModal"
                                                onclick="edit_request_cooperation({{ $request_sent->r_id_request }}, '{{ $request_sent->o_name }}', '{{ $request_sent->p_name }}','{{ $request_sent->f_name }}', '{{ $request_sent->r_message }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square me-1"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Upravit žádost
                                        </button>
                                        <form action="{{ route('zadosti-o-spolupraci.handle-forms') }}" method="post"
                                              class="d-inline-block">
                                            @csrf
                                            <input type="hidden" name="delete-request-sent"
                                                   value="{{ $request_sent->r_id_request }}">
                                            <button type="submit" class="btn btn-sm btn-danger" name="action"
                                                    value="delete-request-cooperation">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-x-circle me-1"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                                Zrušit žádost
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal UPRAVA ZADOSTI -->
        <div class="modal fade" id="EditRequestCooperationModal" data-bs-backdrop="static" tabindex="-1"
             aria-labelledby="EditRequestCooperationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upravit žádost o spolupráci</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <form action="{{ route('zadosti-o-spolupraci.handle-forms') }}" method="post"
                              id="edit-request-cooperation">
                            @csrf
                            <div class="mb-3 small">
                                Nabídka: <span id="edit-request-offer" class="fw-bold"></span>
                            </div>
                            <div class="mb-3 small">
                                Projekt: <span id="edit-request-project" class="fw-bold"></span>
                            </div>
                            <div class="mb-3 small">
                                Obor: <span id="edit-request-field" class="badge rounded-pill bg-light text-dark"></span>
                            </div>
                            <div class="mb-3">
                                <label for="edit-request-message" class="form-label">Zpráva žádosti</label>
                                <textarea class="form-control" id="edit-request-message" name="edit-request-message" rows="8" required></textarea>
                            </div>
                            <input type="hidden" id="edit-id-request" name="edit-id-request" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" form="edit-request-cooperation" class="btn btn-warning" name="action"
                                value="edit-request-cooperation">Upravit žádost
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script>
        function edit_request_cooperation(id_request, offer, project, field, message) {
            document.getElementById("edit-id-request").value = id_request;
            document.getElementById('edit-request-offer').textContent = offer;
            document.getElementById('edit-request-project').textContent = project;
            document.getElementById('edit-request-field').textContent = field;
            document.getElementById("edit-request-message").value = message;
        }

        // Vymazání obsahu modal okna při novém zobrazení stránky
        window.onpageshow = function (event) {
            document.getElementById("edit-id-request").value = '';
            document.getElementById("edit-request-offer").textContent = '';
            document.getElementById("edit-request-project").textContent = '';
            document.getElementById("edit-request-field").textContent = '';
            document.getElementById("edit-request-message").value = '';
        };
    </script>

@endsection
