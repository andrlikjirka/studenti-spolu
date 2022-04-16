@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px;">
        <div class="container px-5 py-5">
            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('uzivatele.index') }}">Uživatelé</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail uživatele</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="">{{ $user->first_name.' '.$user->last_name }}</h3>
                    <a href="mailto:{{ $user->email }}" type="button" class="btn btn-sm btn-outline-secondary mt-2">
                        <i class="bi bi-envelope-fill"></i>
                        Kontaktovat e-mailem
                    </a>
                    <div class="mt-2">
                        <span class="">Znalosti a dovednosti v oborech:&nbsp;</span>
                        @foreach($user_fields as $user_field)
                            <span class="badge bg-white text-dark">{{ $user_field->f_name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-lg-10">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class="nav-link active " id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description"
                                    type="button" role="tab" aria-controls="o-mne" aria-selected="true">O mně
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="projects-tab" data-bs-toggle="tab"
                                    data-bs-target="#author_projects"
                                    type="button" role="tab" aria-controls="projekty" aria-selected="false">Autorské
                                projekty
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="projects-tab" data-bs-toggle="tab"
                                    data-bs-target="#cooperation_projects"
                                    type="button" role="tab" aria-controls="projekty" aria-selected="false">
                                Spolupracovnické projekty
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                             aria-labelledby="o-mne-tab">
                            <div class="card mt-4">
                                <div class="card-header py-3 px-4 text-primary">Popis uživatele</div>
                                <div class="card-body py-4 px-4">
                                    <p class="mb-3">{{ $user->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="author_projects" role="tabpanel" aria-labelledby="projekty-tab">
                            <p class="my-3">Seznam mých autorských projektů:</p>
                            @if(count($user_author_projects) == 0)
                                <p class="my-3 fst-italic">Žádné autorské projekty</p>
                            @endif
                            @foreach($user_author_projects as $project)
                                <div class="card bg-white mb-3">
                                    <div class="card-body p-4">
                                        <a href="{{ route('projekty.show', $project->p_id_project) }}"
                                           class="text-decoration-none">
                                            <h5 class="card-title">{{ $project->p_name }}</h5>
                                        </a>
                                        <p class="card-text">
                                            {{ $project->p_abstract }}
                                        </p>
                                        <span class="badge rounded-pill
                                        @if($project->s_id_status == 1) {{ 'bg-warning' }}
                                        @elseif($project->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($project->s_id_status == 3) {{ 'bg-danger' }}
                                        @endif
                                            ">{{ $project->s_name }}</span>
                                        <p class="mt-2 mb-0 small">Autor: <a href=""
                                                                             class="text-decoration-none">{{ $project->u_first_name.' '.$project->u_last_name}}</a>
                                        </p>
                                        <p class="mt-1 mb-0 small">Datum zveřejnění: {{ $project->create_date }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="tab-pane fade" id="cooperation_projects" role="tabpanel"
                             aria-labelledby="projekty-tab">
                            <p class="my-3">Seznam mých spolupracovnickýh projektů:</p>
                            @if(count($user_cooperation_projects) == 0)
                                <p class="my-3 fst-italic">Žádné spolupracovnické projekty</p>
                            @endif
                            @foreach($user_cooperation_projects as $project)
                                <div class="card bg-white mb-3">
                                    <div class="card-body p-4">
                                        <a href="{{ route('projekty.show', $project->p_id_project) }}"
                                           class="text-decoration-none">
                                            <h5 class="card-title">{{ $project->p_name }}</h5>
                                        </a>
                                        <p class="card-text">
                                            {{ $project->p_abstract }}
                                        </p>
                                        <span class="badge rounded-pill
                                        @if($project->s_id_status == 1) {{ 'bg-warning' }}
                                        @elseif($project->s_id_status == 2) {{ 'bg-success' }}
                                        @elseif($project->s_id_status == 3) {{ 'bg-danger' }}
                                        @endif
                                            ">{{ $project->s_name }}</span>
                                        <p class="mt-2 mb-0 small">Autor: <a href=""
                                                                             class="text-decoration-none">{{ $project->u_first_name.' '.$project->u_last_name}}</a>
                                        </p>
                                        <p class="mt-1 mb-0 small">Datum zveřejnění: {{ $project->create_date }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
