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
                @if(session('delete_project_message'))
                    <div class="alert alert-success small text-center mb-5"> {{ session('delete_project_message') }} </div>
                @endif
            </div>

            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Administrace aplikace</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Administrace žádostí o spolupráci</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Tato stránka je věnována administraci projektů. Můžete zde upravovat informace o vytvořených projektech, nebo jednotlivé projekty zcela odstranit.
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
                                        <th class="">Zpráva žádosti</th>
                                        <th class="">Datum odeslání</th>
                                        <th class="">Stav</th>
                                        <th class="">Akce</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($requests as $request)
                                        <tr>
                                            <td class="">{{ $request->r_id_request }}</td>
                                            <td class="">{{ $request->r_message }}</td>
                                            <td class="">{{ $request->r_create_date }}</td>
                                            <td>
                                                <span class="badge rounded-pill
                                                @if($request->s_id_status == 1) {{ 'bg-secondary' }}
                                                @elseif($request->s_id_status == 2) {{ 'bg-success' }}
                                                @elseif($request->s_id_status == 3) {{ 'bg-danger' }}
                                                @endif">{{ $request->s_name }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.zadosti.show', $request->r_id_request) }}"
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
                                                    action="{{ route('admin.zadosti.handle-forms', $request->r_id_request) }}"
                                                    method="post"
                                                    class="d-inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger delete-request-button"
                                                            name="action" value="delete-request">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-x-circle mx-2 mb-1"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path
                                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                        </svg>
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
    </section>

    <script type="text/javascript">
        let delete_request_buttons = document.getElementsByClassName('delete-request-button');
        for (let i = 0; i < delete_request_buttons.length; i++) {
            delete_request_buttons[i].addEventListener("click", removeRequest)
        }

        function removeRequest(event) {
            if (!window.confirm('Opravdu chcete zrušit vybranou žádost o spolupráci?')) {
                event.preventDefault();
            }
        }

    </script>


@endsection
