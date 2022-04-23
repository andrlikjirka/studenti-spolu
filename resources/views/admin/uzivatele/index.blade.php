@php $loggedUser = \Illuminate\Support\Facades\Auth::user() @endphp
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
                @if(session('delete-user-message'))
                    <div class="alert alert-success small text-center mb-5"> {{ session('delete_user_message') }} </div>
                @elseif(session('error-delete-user-message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error_delete_user_message') }} </div>
                @endif
            </div>
            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Administrace aplikace</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Administrace uživatelů</li>
                        </ol>
                    </nav>

                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Tato stránka je věnována administraci žádostí o spolupráci. Můžete zde upravovat informace o
                        všech žádostech o spolupráci jednotlivých uživatelů nebo je ze systému zcela odstranit. V případě, že
                        máte právo Super Administrátor, můžete měnit práva ostatních uživatelů (tj. vytvářet administrátory nebo administrátorská práva
                        odebírat).
                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary small">
                                    <tr class="">
                                        <th class="">ID</th>
                                        <th class="">Jméno a příjmení</th>
                                        <th class="">Login</th>
                                        <th class="">Stav</th>
                                        <th class="">Právo</th>
                                        <th class="">Akce</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="">{{ $user->id_user }}</td>
                                            <td class="">{{ $user->first_name.' '.$user->last_name }}</td>
                                            <td class="">{{ $user->login }}</td>
                                            <td class="">
                                                <span class="badge rounded-pill
                                                @if($user->id_status == 1) {{ 'bg-success' }}
                                                @elseif($user->id_status == 2) {{ 'bg-danger' }}
                                                @endif">{{ $user->s_name }}</span>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-secondary">{{ $user->r_name }}</span>
                                            </td>
                                            <td>
                                                @if($user->id_user != $loggedUser->id_user AND $user->id_right > $loggedUser->id_right)
                                                    <a href="{{ route('admin.uzivatele.show', $user->id_user) }}"
                                                       class="btn btn-sm btn-warning" role="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-pencil-square mx-2 mb-1"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd"
                                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.uzivatele.handle-forms', $user->id_user) }}"
                                                        method="post"
                                                        class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="delete_id_user"
                                                               value="{{ $user->id_user }}">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger delete-user-button"
                                                                name="action" value="delete-user">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-x-circle mx-2 mb-1"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path
                                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                            </svg>
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
            </div>

        </div>
    </section>

    <script type="text/javascript">
        let delete_user_buttons = document.getElementsByClassName('delete-user-button');
        for (let i = 0; i < delete_user_buttons.length; i++) {
            delete_user_buttons[i].addEventListener("click", removeUser)
        }

        function removeUser(event) {
            if (!window.confirm('Opravdu chcete smazat uživatele a všechny jeho vytvořené projekty, nabídky spolupráce atd.?')) {
                event.preventDefault();
            }
        }

    </script>

@endsection
