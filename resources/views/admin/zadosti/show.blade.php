@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div>
                @if(count($errors) > 0)
                    <div class="alert alert-danger small text-center mb-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                @if(session('edit_request_message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('edit_request_message') }} </div>
                @elseif(session('error_edit_request_message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_edit_request_message') }} </div>
                @elseif(session('delete_request_message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('delete_request_message') }} </div>
                @elseif(session('error_delete_request_message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_delete_request_message') }} </div>
                @elseif(session('accept_request_message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('accept_request_message') }} </div>
                @elseif(session('error_accept_request_message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_accept_request_message') }} </div>
                @elseif(session('reject_request_message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('reject_request_message') }} </div>
                @elseif(session('error_reject_request_message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_reject_request_message') }} </div>
                @elseif(session('waiting_request_message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('waiting_request_message') }} </div>
                @elseif(session('error_waiting_request_message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_waiting_request_message') }} </div>
                @endif
            </div>

            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Administrace aplikace</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.zadosti.index') }}">Administrace
                                    žádostí o spolupráci</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Úprava žádosti</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3 mb-1">Úprava žádosti o spolupráci (ID: {{ $request->r_id_request }})</h3>
                    <span class="badge bg-primary">Administrace žádostí o spolupráci</span>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-9">
                    <!-- Informace o projektu -->
                    <div class="card mt-4">
                        <div class="card-header py-3 px-4 text-primary">Úprava žádosti</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}"
                                  method="post"
                                  id="edit-request-cooperation">
                                @csrf
                                <div class="mb-3 small">
                                    Odesílatel: <span id="edit-request-user"
                                                      class="fw-bold">{{ $request->u_first_name.' '.$request->u_last_name }}</span>
                                </div>
                                <div class="mb-3 small">
                                    Reakce na nabídku: <span id="edit-request-offer"
                                                             class="fw-bold">{{ $request->o_name }}</span>
                                </div>
                                <div class="mb-3 small">
                                    Projekt: <span id="edit-request-project"
                                                   class="fw-bold">{{ $request->p_name }}</span>
                                </div>
                                <div class="mb-3 small">
                                    Obor: <span id="edit-request-field"
                                                class="badge rounded-pill bg-light text-dark"> {{ $request->f_name }}</span>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-request-message" class="form-label">Zpráva žádosti
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="edit-request-message" name="edit-request-message"
                                              rows="8" required>{{ $request->r_message }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning mb-3 edit-request-button" name="action" value="edit-request">
                                    Uložit úpravy
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header py-3 px-4 text-primary">Stav žádosti</div>
                        <div class="card-body px-4 py-4">
                            <div class="mb-3 small">
                                Stav: <span class="badge rounded-pill
                                        @if($request->s_id_status == 1) {{ 'bg-secondary' }}
                                        @elseif($request->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($request->s_id_status == 3) {{ 'bg-danger' }}
                                        @endif">{{ $request->s_name }}</span>
                            </div>
                            @if($request->s_id_status == 1)
                                <form action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}"
                                      method="post" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="accept_id_user"
                                           value="{{ $request->u_id_user }}">
                                    <input type="hidden" name="accept_id_project"
                                           value="{{ $request->p_id_project }}">
                                    <button type="submit" class="btn btn-sm btn-success" name="action" id="accept-request-button"
                                            value="accept-request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-check-circle me-1 mb-1"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path
                                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                        </svg>
                                        Schválit žádost
                                    </button>
                                </form>
                                <form action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}"
                                      method="post" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" name="action" id="reject-request-button"
                                            value="reject-request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-x-circle me-1 mb-1"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path
                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        Zamítnout žádost
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}"
                                      method="post" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="waiting_id_user"
                                           value="{{ $request->u_id_user }}">
                                    <input type="hidden" name="waiting_id_project"
                                           value="{{ $request->p_id_project }}">
                                    <button type="submit" class="btn btn-sm btn-warning " name="action" id="waiting-request-button"
                                            value="waiting-request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-arrow-clockwise me-1 "
                                             viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                            <path
                                                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                        </svg>
                                        Znovu posoudit
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        let edit_request_buttons = document.getElementsByClassName('edit-request-button');
        for (let i = 0; i < edit_request_buttons.length; i++) {
            edit_request_buttons[i].addEventListener("click", editRequest)
        }

        function editRequest(event) {
            if (!window.confirm('Opravdu chcete provést úpravu?')) {
                event.preventDefault();
            }
        }

        let accept_request_button = document.getElementById('accept-request-button');
        accept_request_button.addEventListener("click", function (event){
            if (!window.confirm('Opravdu chcete provést schválení žádosti o spolupráci?')) {
                event.preventDefault();
            }
        })
        let reject_request_button = document.getElementById('reject-request-button');
        reject_request_button.addEventListener("click", function (event){
            if (!window.confirm('Opravdu chcete provést zamítnutí žádosti o spolupráci?')) {
                event.preventDefault();
            }
        })
        let waiting_request_button = document.getElementById('waiting-request-button');
        waiting_request_button.addEventListener("click", function (event){
            if (!window.confirm('Opravdu chcete provést znovuposouzení žádosti o spolupráci?')) {
                event.preventDefault();
            }
        })
    </script>

@endsection
