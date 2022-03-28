@extends('layouts.layout');

@section('content')
    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam feugiat, turpis at pulvinar
                        vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. Etiam quis quam.
                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">

                    @foreach($projects as $project)

                        <div class="card bg-white mb-3">
                            <div class="card-body p-4">
                                <a href="./projekty/{{ $project->id_project }}" class="text-decoration-none">
                                    <h5 class="card-title">{{ $project->name }}</h5>
                                </a>
                                <p class="card-text">
                                    {{ $project->abstract }}
                                </p>
                                <span class="badge rounded-pill bg-warning">{{ $project->s_name }}</span>
                                <p class="mt-2 mb-0 small">Autor: <a href="" class="text-decoration-none">{{ $project->u_first_name.' '.$project->u_last_name}}</a></p>
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
