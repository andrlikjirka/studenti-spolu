@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">

            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Uživatelé</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Tato stránka systému obsahuje seznam všech aktivních uživatelů. Uživatele můžete i vyhledávat podle jména a příjmení.
                    </p>
                </div>
            </div>
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">

                    <!--FILTR (HLEDANI DNE OBORU)-->
                    <div class="mb-4">
                        <form id="search-user" action="{{ route('uzivatele.index') }}" method="get">
                            <label>
                                <input class="form-control form-control-sm" type="text" placeholder="Jméno"
                                       name="first_name" value="{{ request()->input('first_name') }}">
                            </label>
                            <label>
                                <input class="form-control form-control-sm" type="text" placeholder="Příjmení"
                                       name="last_name" value="{{ request()->input('last_name') }}">
                            </label>
                            <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                    value="search-user">Hledat uživatele
                            </button>
                        </form>
                        <hr class="dropdown-divider">
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-body py-4 px-5">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-primary small">
                                            <tr class="">
                                                <th class="">Jméno a příjmení</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                @if($user->id_status == 1)
                                                    <tr>
                                                        <td class=""><a href="{{ route('uzivatele.show', $user->id_user) }}" class="d-block">{{ $user->first_name.' '.$user->last_name }}</a></td>
                                                    </tr>
                                                @endif
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
    </section>

@endsection
