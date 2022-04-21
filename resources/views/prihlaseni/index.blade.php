@extends('layouts.layout')

@section('content')

    <!-- Login -->
    <section class="bg-primary bg-gradient" style="padding-top: 70px">
        <div class="container px-5 py-5 ">
            @if(count($errors) > 0)
                <div class="alert alert-danger small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <div class="row justify-content-center py-xxl-5">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header py-3 px-4 text-primary">Přihlásit</div>
                        <div class="card-body py-4 px-4">
                            <form action="{{ route('prihlaseni') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="mb-3">
                                    <label for="login" class="form-label small">Uživatelské jméno</label>
                                    <input type="text" class="form-control" name="login" id="login" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label small">Heslo</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 px-4">Přihlásit se</button>
                                <p class="mt-4 small">
                                    Ještě nemáte vytvořený účet?
                                    <a class="text-primary" href="{{ route('registrace') }}">Registrovat se</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
