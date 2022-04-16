@extends('layouts.layout')

@section('content')
    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">

            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Projekty</li>
                        </ol>
                    </nav>

                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Tato stránka systému obsahuje seznam všech zveřejněných týmových projektů. Výběrem konkrétního projektu si můžete zobrazit podrobné informace.
                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">

                    <!--FILTR (HLEDANI DLE NAZVU)-->
                    <div class="mb-4">
                        <form id="search-project" action="{{ route('projekty.index') }}" method="get">
                            <label>
                                <input class="form-control form-control-sm" type="text" placeholder="Název projektu"
                                       name="project_name" value="{{ request()->input('project_name') }}">
                            </label>
                            <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                    value="search-project">Hledat projekt
                            </button>
                        </form>
                        <hr class="dropdown-divider">
                    </div>

                    @foreach($projects as $project)
                        <div class="card bg-white mb-3">
                            <div class="card-body p-4">
                                <a href="{{ route('projekty.show', $project->id_project) }}"
                                   class="text-decoration-none">
                                    <h5 class="card-title">{{ $project->name }}</h5>
                                </a>
                                <p class="card-text">
                                    {{ $project->abstract }}
                                </p>
                                <span class="badge rounded-pill
                                    @if($project->s_id_status == 1) {{ 'bg-warning' }}
                                @elseif($project->s_id_status == 2) {{ 'bg-success' }}
                                @elseif($project->s_id_status == 3) {{ 'bg-danger' }}
                                @endif">{{ $project->s_name }}</span>
                                <p class="mt-2 mb-0 small">Autor: <a href="{{ route('uzivatele.show', $project->u_id_user) }}"
                                                                     class="text-decoration-none">{{ $project->u_first_name.' '.$project->u_last_name}}</a>
                                </p>
                                <p class="mt-1 mb-0 small">Datum zveřejnění: {{ $project->create_date }}</p>
                            </div>
                        </div>
                @endforeach

                <!--
                    <div class="card bg-white mb-3">
                        <div class="card-body p-4">
                            <a href="./projekty/1" class="text-decoration-none">
                                <h5 class="card-title">Lorem ipsum dolor sit amet</h5>
                            </a>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                                vestibulum
                                ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                                enim.
                                Curabitur vitae diam non enim vestibulum interdum.
                            </p>
                            <span class="badge rounded-pill bg-warning">Rozpracováno</span>
                            <p class="mt-2 mb-0 small">Autor: <a href="" class="text-decoration-none">Jiří Andrlík</a></p>
                            <p class="mt-1 mb-0 small">Datum zveřejnění: 2022-03-16</p>
                        </div>
                    </div>
                    -->

                </div>
            </div>


        </div>
    </section>
@endsection
