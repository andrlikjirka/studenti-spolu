@extends('layouts.layout')

@section('content')
    <section class="bg-primary bg-gradient" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row gx-5 align-items-center py-xxl-5">
                <div class="col-lg-6 col-md-6 text-white">
                    <h1 class="fw-bold py-3 font-monospace">studenti|spolu<sup class=""></sup></h1>
                    <p class="mt-3 mt-xxl-4 lh-lg">
                        Tento webový informační systém je určený pro vysokoškolské studenty, kteří
                        potřebují pro své autorské projekty získat nové spolupracovníky nebo mají zájem aplikovat
                        své znalosti a dovednosti při práci na týmových projektech ostatních autorů.
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <img style="width: 90%;" class="d-block m-auto" src="{{ asset('./index-img.png') }}"
                         alt="studenti spoluprace">
                </div>
            </div>
        </div>
    </section>

@endsection
