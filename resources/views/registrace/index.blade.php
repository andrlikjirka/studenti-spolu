@extends('layouts.layout')

@section('content')

    <!-- Registrace -->
    <section class="bg-primary bg-gradient" style="padding-top: 70px">
        <div class="container px-5 py-5">
            @if(count($errors) > 0)
                <div class="alert alert-danger small text-center mb-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header py-3 px-4 text-primary">Registrace nového uživatele</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('registrace') }}" method="post" autocomplete="off">
                            @csrf
                            <!-- Jméno, Uživatelské jméno -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="first_name" class="form-label small">
                                            Jméno
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                               required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="last_name" class="form-label small">
                                            Příjmení
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                               required>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="">
                                            <label for="login" class="form-label small">
                                                Uživatelské jméno
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="login" id="login" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="email" class="form-label small">
                                            E-mail
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="email" id="email" required>
                                    </div>
                                </div>
                                <!-- Heslo, potvrzení hesla -->
                                <div class="row align-items-center mb-4">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="password" class="form-label small">
                                            Heslo
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="password" id="password"
                                               required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="">
                                            <label for="password_confirmation" class="form-label small">
                                                Potvrzení hesla
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   id="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                                <hr class="dropdown-divider mb-4">
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label small">
                                            Znalosti a dovednosti v oborech
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="overflow-auto border rounded-1" style="height: 205px">
                                            <div class="list-group list-group-flush">
                                                @foreach($fields as $field)
                                                    <label class="list-group-item">
                                                        <input class="form-check-input me-1" type="checkbox"
                                                               name="fields[]" value="{{ $field->id_field }}"
                                                               onchange="checkLimit()">
                                                        {{ $field->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="registration" class="btn btn-primary mt-1 px-4 disabled">Registrovat se</button>
                                <p class="mt-4 small">
                                    Již máte vytvořený účet?
                                    <a class="text-primary" href="{{ route('prihlaseni') }}">Přihlaste se</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        function checkLimit(){
            var submitButton = document.getElementById('registration');
            var checkboxes = document.getElementsByClassName('form-check-input');
            count = 0;
            for (var i=0; i<checkboxes.length; i++ ) {
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
    </script>

@endsection
