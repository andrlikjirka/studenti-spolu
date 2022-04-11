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
                    <a href="{{ route('admin.projekty.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Zpět na seznam administrace projektů</a>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3 mb-1">{{ $project->name }}</h3>
                    <span class="badge bg-primary">Administrace projektu</span>

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
                                    type="button" role="tab" aria-controls="clenove-tymu" aria-selected="false">Členové
                                týmu
                            </button>
                        </li>
                        <li class="nav-item " role="presentation">
                            <button class="nav-link" id="nabidky-spoluprace-tab" data-bs-toggle="tab"
                                    data-bs-target="#nabidky-spoluprace"
                                    type="button" role="tab" aria-controls="nabidky-spoluprace" aria-selected="false">
                                Správa nabídek
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
                                    <form id="edit-project"
                                          action="{{ route('admin.projekty.handle-forms', $project->id_project) }}"
                                          method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="edit-name-project" class="form-label">Název
                                                projektu</label>
                                            <input type="text" id="edit-name-project" class="form-control"
                                                   name="edit-name-project" value="{{ $project->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-abstract-project" class="form-label">Abstrakt</label>
                                            <textarea type="text" id="edit-abstract-project" class="form-control"
                                                      rows="3"
                                                      name="edit-abstract-project" required
                                            >{{ $project->abstract }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-description-project" class="form-label">Popis
                                                projektu</label>
                                            <textarea type="text" id="edit-description-project" class="form-control"
                                                      rows="8"
                                                      name="edit-description-project" required
                                            >{{ $project->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-status-project" class="form-label">Stav projektu</label>
                                            <select id="edit-status-project" class="form-select"
                                                    name="edit-status-project"
                                                    aria-label="Default select example" required>
                                                <option disabled value="">Vyberte stav projektu</option>
                                                @foreach($status_project_all as $status)
                                                    <option
                                                        value="{{ $status->id_status }}" @if($project->s_id_status == $status->id_status) {{ 'selected' }} @endif>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning edit-project-button" name="action"
                                                value="edit-project">
                                            Upravit informace o projektu
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
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Název souboru</th>
                                                <th>Typ souboru</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            @foreach($files as $file)
                                                <tr>
                                                    <td><a href="{{ route('soubory', $file->id_file) }}"
                                                           target="_blank">{{ $file->name }}</a></td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">{{ $file->type }}</span>
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('admin.projekty.handle-forms', $project->id_project) }}"
                                                            method="post" class="m-0 p-0">
                                                            @csrf
                                                            <input type="hidden" name="delete_id_file"
                                                                   value="{{ $file->id_file }}">
                                                            <button type='submit' name="action" value="delete-file"
                                                                    class='btn btn-sm btn-outline-danger m-0 py-0 px-2 delete-file-button'>
                                                                Odebrat
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach

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
                                                <th>Role</th>
                                                <th style="width: 5%"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">

                                            @foreach($team_members as $member)
                                                <tr>
                                                    <td>
                                                        {{ $member->u_first_name.' '.$member->u_last_name }}
                                                    </td>
                                                    <td>{{ $member->r_name }}</td>
                                                    <td>
                                                        @if($member->r_id_role != 1)
                                                            <form
                                                                action="{{ route('admin.projekty.handle-forms',  $project->id_project) }}"
                                                                class="m-0 p-0" method="post">
                                                                @csrf
                                                                <input type="hidden" name="remove_id_user"
                                                                       value="{{ $member->u_id_user }}">
                                                                <button type='submit' name="action"
                                                                        value="remove-team-member"
                                                                        class='btn btn-sm btn-outline-danger m-0 py-0 px-2 remove-member-button'>
                                                                    Odebrat
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
                                <div class="card-header py-3 px-4 text-primary">Správa nabídek spolupráce na projektu
                                </div>
                                <div class="card-body py-4 px-4">
                                    <!-- Button trigger modal
                                    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
                                            data-bs-target="#NewOfferCooperationModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                        Nová nabídka spolupráce
                                    </button>
                                    -->
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Název nabídky</th>
                                                <th>Obor</th>
                                                <th>Stav</th>
                                                <th>Akce</th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            @foreach($offers_cooperation as $offer)
                                                <tr>
                                                    <td>{{ $offer->o_name }}</td>
                                                    <td><span
                                                            class="badge rounded-pill bg-light text-dark">{{ $offer->f_name }}</span>
                                                    </td>
                                                    <td><span class="badge rounded-pill
                                                        @if($offer->s_id_status == 1) {{ 'bg-success' }} @elseif($offer->s_id_status == 2) {{ 'bg-danger' }} @endif">
                                                            {{ $offer->s_name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <!--Button trigger modal -->
                                                        <button
                                                            onclick="edit_offer_cooperation({{ $offer->o_id_offer }},'{{ $offer->o_name }}', '{{ $offer->o_description }}', {{ $offer->s_id_status }}, {{ $offer->f_id_field }})"
                                                            type="button"
                                                            class="btn btn-warning btn-sm d-inline-block"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#EditOfferCooperationModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor"
                                                                 class="bi bi-pencil-square me-1"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd"
                                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                            </svg>
                                                            Upravit
                                                        </button>
                                                        <form
                                                            action="{{ route('moje-projekty.handle-forms', $project->id_project) }}"
                                                            method="post" class="m-0 p-0 d-inline-block">
                                                            @csrf
                                                            <input type="hidden" name="remove_id_offer"
                                                                   value="{{ $offer->o_id_offer }}">
                                                            <button type='submit' name="action"
                                                                    value="remove-offer-cooperation"
                                                                    class='btn btn-sm btn-danger remove-offer-button'>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-x-circle me-1"
                                                                     viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                    <path
                                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                </svg>
                                                                Smazat
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
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
        <div class="modal fade" id="NewOfferCooperationModal" data-bs-backdrop="static" tabindex="-1"
             aria-labelledby="NewOfferCooperationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nová nabídka spolupráce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <form action="{{ route('admin.projekty.handle-forms', $project->id_project) }}"
                              method="post"
                              id="new-offer-cooperation">
                            @csrf
                            <div class="mb-3">
                                <label for="name-offer-cooperation" class="form-label">Název nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name-offer-cooperation"
                                       name="name-offer-cooperation"
                                       placeholder="Zadejte název nabídky spolupráce (např. Vývojář mobilních aplikací)"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label for="field-offer-cooperation" class="form-label">Obor nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="field-offer-cooperation" class="form-select"
                                        aria-label="Obor spolupráce"
                                        name="field-offer-cooperation" required>
                                    <option selected disabled value="">Vyberte obor spolupráce</option>
                                    @foreach($fields_all as $field)
                                        <option value="{{ $field->id_field }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description-offer-cooperation" class="form-label">Popis nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="description-offer-cooperation" rows="6"
                                          name="description-offer-cooperation" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušit
                        </button>
                        <button type="submit" form="new-offer-cooperation" class="btn btn-secondary" name="action"
                                value="new-offer-cooperation">Vytvořit a zveřejnit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal UPRAVA NABIDKY -->
        <div class="modal fade" id="EditOfferCooperationModal" data-bs-backdrop="static" tabindex="-1"
             aria-labelledby="EditOfferCooperationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upravit nabídku spolupráce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <form action="{{ route('admin.projekty.handle-forms',  $project->id_project) }}"
                              method="post"
                              id="edit-offer-cooperation">
                            @csrf
                            <div class="mb-3">
                                <label for="edit-name-offer-cooperation" class="form-label">Název nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit-name-offer-cooperation"
                                       name="edit-name-offer-cooperation"
                                       placeholder="Zadejte název nabídky spolupráce (např. Vývojář mobilních aplikací)"
                                       value="" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-status-offer-cooperation" class="form-label">Stav nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="edit-status-offer-cooperation" class="form-select"
                                        name="edit-status-offer-cooperation"
                                        aria-label="Stav nabídky spolupráce"
                                        required>
                                    <option selected disabled value="">Vyberte stav nabídky spolupráce</option>
                                    @foreach($status_offer_all as $status)
                                        <option value="{{ $status->id_status }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit-field-offer-cooperation" class="form-label">Obor nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="edit-field-offer-cooperation" class="form-select"
                                        aria-label="Obor spolupráce" name="edit-field-offer-cooperation"
                                        required>
                                    <option selected disabled value="">Vyberte obor spolupráce</option>
                                    @foreach($fields_all as $field)
                                        <option value="{{ $field->id_field }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit-description-offer-cooperation" class="form-label">Popis nabídky
                                    spolupráce
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="edit-description-offer-cooperation"
                                          name="edit-description-offer-cooperation" rows="6" required></textarea>
                            </div>
                            <input type="hidden" id="edit-id-offer" name="edit-id-offer" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" form="edit-offer-cooperation" class="btn btn-warning" name="action"
                                value="edit-offer-cooperation">Uložit úpravy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function edit_offer_cooperation(id, name, description, id_status, id_field) {
            document.getElementById("edit-id-offer").value = id;
            document.getElementById("edit-name-offer-cooperation").value = name;
            document.getElementById("edit-description-offer-cooperation").value = description;
            var statusSelect = document.getElementById("edit-status-offer-cooperation");
            statusSelect[id_status].selected = true;
            var fieldSelect = document.getElementById("edit-field-offer-cooperation");
            fieldSelect[id_field].selected = true;
        }

        // Vymazání obsahu modal okna při novém zobrazení stránky
        window.onpageshow = function (event) {
            document.getElementById("name-offer-cooperation").value = '';
            document.getElementById("field-offer-cooperation").value = '';
            document.getElementById("description-offer-cooperation").value = '';
        };

        let remove_member_buttons = document.getElementsByClassName('remove-member-button');
        for (let i = 0; i < remove_member_buttons.length; i++) {
            remove_member_buttons[i].addEventListener("click", removeMember)
        }

        function removeMember(event) {
            if (!window.confirm('Opravdu chcete smazat vybraného člena týmu?')) {
                event.preventDefault();
            }
        }

        let remove_offer_buttons = document.getElementsByClassName('remove-offer-button');
        for (let i = 0; i < remove_offer_buttons.length; i++) {
            remove_offer_buttons[i].addEventListener("click", removeOffer)
        }

        function removeOffer(event) {
            if (!window.confirm('Opravdu chcete smazat vybranou nabídku spolupráce?')) {
                event.preventDefault();
            }
        }

        let delete_file_buttons = document.getElementsByClassName('delete-file-button');
        for (let i = 0; i < delete_file_buttons.length; i++) {
            delete_file_buttons[i].addEventListener("click", deleteFile)
        }

        function deleteFile(event) {
            if (!window.confirm('Opravdu chcete smazat vybraný soubor?')) {
                event.preventDefault();
            }
        }

        let edit_project_buttons = document.getElementsByClassName('edit-project-button');
        for (let i = 0; i < edit_project_buttons.length; i++) {
            edit_project_buttons[i].addEventListener("click", editProject)
        }

        function editProject(event) {
            if (!window.confirm('Opravdu chcete upravit projekt?')) {
                event.preventDefault();
            }
        }

    </script>

@endsection
