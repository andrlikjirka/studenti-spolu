@extends('layouts.layout')

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
            @elseif(session('error_new_project_message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error_new_project_message') }} </div>
            @elseif(session('edit_project_message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('edit_project_message') }} </div>
            @elseif(session('remove_team_member_message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('remove_team_member_message') }} </div>
            @elseif(session('error_remove_team_member_message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error_remove_team_member_message') }} </div>
            @elseif(session('new-offer-cooperation-message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('new-offer-cooperation-message') }} </div>
            @elseif(session('error-new-offer-cooperation-message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error-new-offer-cooperation-message') }} </div>
            @elseif(session('remove-offer-cooperation-message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('remove-offer-cooperation-message') }} </div>
            @elseif(session('error-remove-offer-cooperation-message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error-remove-offer-cooperation-message') }} </div>
            @elseif(session('edit-offer-cooperation-message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('edit-offer-cooperation-message') }} </div>
            @elseif(session('error-edit-offer-cooperation-message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error-edit-offer-cooperation-message') }} </div>
            @elseif(session('file-upload-message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('file-upload-message') }} </div>
            @elseif(session('error-file-upload-message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error-file-upload-message') }} </div>
            @elseif(session('delete-file-message'))
                <div
                    class="alert alert-success small text-center mb-5"> {{ session('delete-file-message') }} </div>
            @elseif(session('error-delete-file-message'))
                <div
                    class="alert alert-danger small text-center mb-5"> {{ session('error-delete-file-message') }} </div>
            @endif

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <a href="{{ route('admin.zadosti.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Zpět na seznam administrace žádostí o spolupráci</a>
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
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="o-projektu" role="tabpanel"
                             aria-labelledby="o-projektu-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Úprava žádosti</div>
                                <div class="card-body py-4 px-4">
                                    <form action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}" method="post"
                                          id="edit-request-cooperation">
                                        @csrf
                                        <div class="mb-3 small">
                                            Odesílatel: <span id="edit-request-user" class="fw-bold">{{ $request->u_first_name.' '.$request->u_last_name }}</span>
                                        </div><div class="mb-3 small">
                                            Reakce na nabídku: <span id="edit-request-offer" class="fw-bold">{{ $request->o_name }}</span>
                                        </div>
                                        <div class="mb-3 small">
                                            Projekt: <span id="edit-request-project" class="fw-bold">{{ $request->p_name }}</span>
                                        </div>
                                        <div class="mb-3 small">
                                            Obor: <span id="edit-request-field"
                                                        class="badge rounded-pill bg-light text-dark"> {{ $request->f_name }}</span>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="edit-status-request" class="form-label">Stav žádosti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select id="edit-status-request" class="form-select"
                                                    name="edit-status-request"
                                                    aria-label="Default select example" required>
                                                <option disabled value="">Vyberte stav žádosti o spolupráci</option>
                                                @foreach($status_request_all as $status)
                                                    <option
                                                        value="{{ $status->id_status }}" @if($request->s_id_status == $status->id_status) {{ 'selected' }} @endif>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-request-message" class="form-label">Zpráva žádosti
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="edit-request-message" name="edit-request-message"
                                                      rows="8" required>{{ $request->r_message }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-warning mb-3" name="action" value="edit-request">Uložit úpravy</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>


    </section>

    <script>



    </script>

@endsection
