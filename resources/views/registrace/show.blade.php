@extends('layouts.layout')

@section('content')

    <!-- Registrace -->
    <section class="bg-primary bg-gradient" style="padding-top: 70px">
        <div class="container px-5 py-5">
            @if(count($errors) > 0)
                <div class="alert alert-danger small">
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
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label small">
                                                Jméno
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" required>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label small">
                                                Příjmení
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="login" class="form-label small">
                                                Uživatelské jméno
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="login" id="login" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="e-mail" class="form-label small">
                                                E-mail
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="e-mail" id="e-mail" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Heslo, potvrzení hesla -->
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label small">
                                                Heslo
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label small">
                                                Potvrzení hesla
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   id="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 px-4">Registrovat se</button>
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

@endsection
