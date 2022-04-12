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

            @if(session('edit-user-message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('edit-user-message') }} </div>
            @elseif(session('delete-user-message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('delete-user-message') }} </div>
            @elseif(session('error-delete-user-message'))
                <div class="alert alert-danger small text-center mb-5"> {{ session('error-delete-user-message') }} </div>
            @elseif(session('edit-password-message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('edit-password-message') }} </div>
            @elseif(session('edit-fields-message'))
                <div class="alert alert-success small text-center mb-5"> {{ session('edit-fields-message') }} </div>
            @elseif(session('edit-fields-message'))
                <div class="alert alert-danger small text-center mb-5"> {{ session('error-edit-fields-message') }} </div>
            @endif

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <a href="{{ route('admin.uzivatele.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Zpět na seznam administrace uživatelů</a>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3 mb-1">{{ $user->first_name.' '.$user->last_name }}</h3>
                    <span class="badge bg-primary">Administrace uživatele</span>
                </div>
            </div>
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-header py-3 px-4 text-primary">Popis uživatele</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('admin.uzivatele.handle-forms', $user->id_user) }}" method="post">
                            @csrf
                            <!-- Jméno, Uživatelské jméno -->
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="first-name" class="form-label small">
                                                Jméno
                                            </label>
                                            <input type="text" class="form-control" name="first-name" id="first-name"
                                                   value="{{ $user->first_name }}" placeholder="Zadejte vaše jméno"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="last-name" class="form-label small">
                                                Příjmení
                                            </label>
                                            <input type="text" class="form-control" name="last-name" id="last-name"
                                                   value="{{ $user->last_name }}" placeholder="Zadejte vaše příjmení"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="email" class="form-label small">
                                                E-mail
                                            </label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                   value="{{ $user->email }}" placeholder="Zadejte nový e-mail"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label small">
                                                Popis
                                            </label><br>
                                            <textarea class="form-control" name="description" id="description" rows="6"
                                                      placeholder="Zadejte váš popis">{{ $user->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label small">
                                                Stav uživatele
                                            </label><br>
                                            <select class="form-select" aria-label="status" name="edit_id_status">
                                                @foreach($all_status_user as $status)
                                                    <option value="{{ $status->id_status }}"
                                                    @if($user->id_status == $status->id_status) {{ 'selected' }} @endif
                                                        >{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @can('isSuperAdmin')
                                            <div class="mb-3">
                                                <label for="description" class="form-label small">
                                                    Právo uživatele
                                                </label><br>
                                                <select class="form-select" aria-label="Default select example" name="edit_id_right">
                                                    @foreach($rights as $right)
                                                        <option value="{{ $right->id_right }}"
                                                        @if($user->id_right == $right->id_right) {{ 'selected' }} @endif
                                                        >{{ $right->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" name="edit_id_right" value="{{ $user->id_right }}">
                                        @endcan
                                    </div>

                                </div>
                                <button type="submit" name="action" value="edit-user"
                                        class="btn btn-primary mt-1 px-4 edit-user-button">Uložit změny
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header py-3 px-4 text-primary">Změna přihlašovacích údajů</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('admin.uzivatele.handle-forms', $user->id_user) }}" method="post">
                                @csrf
                                <div class="row align items center">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label small">
                                                Nové heslo
                                            </label>
                                            <input type="password" class="form-control" name="password"
                                                   id="password" placeholder="Zadejte nové heslo" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label small">
                                                Potvrzení hesla
                                            </label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   id="password_confirmation" placeholder="Potvrďte nové heslo"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary px-4 edit-user-button" name="action" value="edit-password">
                                    Uložit změny
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header py-3 px-4 text-primary">Znalosti a dovednosti v oboru</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('admin.uzivatele.handle-forms', $user->id_user) }}" method="post">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-9">
                                        <div class="overflow-auto border rounded-1" style="height: 205px">
                                            <div class="list-group list-group-flush">
                                                @foreach($fields as $field)
                                                    <label class="list-group-item">
                                                        <input class="form-check-input me-1" type="checkbox"
                                                               name="fields[]" value="{{ $field->id_field }}"
                                                               onchange="checkLimit()"
                                                        @foreach($user_fields as $user_field)
                                                            @if($field->id_field == $user_field->id_field)
                                                                {{ 'checked' }}
                                                                @endif
                                                            @endforeach
                                                        >
                                                        {{ $field->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-center">
                                        <button type="submit" class="btn btn-primary mt-sm-3 mt-md-0 edit-user-button"
                                                id="edit-fields" name="action" value="edit-fields">Uložit změny
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <script>
        function checkLimit() {
            var submitButton = document.getElementById('edit-fields');
            var checkboxes = document.getElementsByClassName('form-check-input');
            count = 0;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type === 'checkbox' && checkboxes[i].checked === true) {
                    count++;
                }
            }
            //console.log(count);
            if (count > 0) {
                submitButton.classList.remove('disabled');
            } else {
                submitButton.classList.add('disabled');
            }
        }

        let edit_user_buttons = document.getElementsByClassName('edit-user-button');
        for (let i = 0; i < edit_user_buttons.length; i++) {
            edit_user_buttons[i].addEventListener("click", editProject)
        }

        function editProject(event) {
            if (!window.confirm('Opravdu chcete provést úravu?')) {
                event.preventDefault();
            }
        }

    </script>

@endsection
