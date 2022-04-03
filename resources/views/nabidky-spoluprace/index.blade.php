@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">{{ $title }}</h3>
                    <p class="text-secondary">
                        Tato stránka systému obsahuje seznam všech aktivních nabídek spolupráce. K dispozici je i
                        možnost zobrazit si jen nabídky spolupráce podle vašich znalostí a dovedností v oboru.
                    </p>
                </div>
            </div>

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <!-- FILTR (HLEDANI DNE OBORU) -->
                    <div class="mb-4">
                        <form id="match_offer_cooperation" action="{{ route('nabidky-spoluprace.index') }}"
                              method="get">
                            <div class="">
                                <input type="checkbox" id="match-checked" name="match-checked"
                                       value="true" @if(session('match') == true) {{ 'checked' }} @else {{ '' }} @endif>
                                <label for="match-checked">Zobrazit nabídky spolupráce podle vašich znalostí a
                                    dovedností v oboru</label>
                                <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                        value="match_offer">Zobrazit
                                </button>
                            </div>
                        </form>
                        <hr class="dropdown-divider">
                    </div>

                    @foreach($offers as $offer)
                        <div class="card bg-white mb-3">
                            <div class="card-body p-4">
                                <a href="{{ route('nabidky-spoluprace.show', $offer->o_id_offer) }}"
                                   class="text-decoration-none">
                                    <h5 class="card-title text-primary">{{ $offer->o_name }}</h5>
                                </a>
                                <hr>
                                <div class="mt-0">
                                    <span class="small">Obor: </span>
                                    <span class="badge rounded-pill bg-primary ">{{ $offer->f_name }}</span>
                                    <p class="mt-2 mb-2 small">Projekt:
                                        <a href="{{ route('projekty.show', $offer->p_id_project) }}"
                                           class="text-decoration-none">
                                            {{ $offer->p_name }}
                                        </a>
                                    </p>
                                    <p class="mt-0 mb-0 small">Datum zveřejnění: {{ $offer->o_create_date }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>


            <!-- Modal
            <div class="modal fade" id="NewRequestCooperationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                 aria-labelledby="NewRequestCooperationLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Žádost o spolupráci</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="new-request-cooperation" action="">
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <span>Projekt: </span>
                                        <span class="fw-bold">Lorem ipsum dolor sit amet</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <span>Obor: </span>
                                        <span class="badge rounded-pill bg-light text-dark">Systémové inženýrství a informatika</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="message-request-cooperation" class="form-label">Zpráva žádosti</label>
                                    <textarea class="form-control" id="message-request-cooperation" name="message-request-cooperation" rows="8" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" form="new-request-cooperation" class="btn btn-primary" name="action"
                                    value="new-request-cooperation">Odeslat žádost
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            -->

        </div>
    </section>

@endsection
