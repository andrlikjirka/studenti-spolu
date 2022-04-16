@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px;">
        <div class="container px-5 py-5">
            <div>
                @if(session('new-request-cooperation-message'))
                    <div
                        class="alert alert-success small text-center mb-5"> {{ session('new-request-cooperation-message') }} </div>
                @elseif(session('error-new-request-cooperation-message'))
                    <div
                        class="alert alert-danger small text-center mb-5"> {{ session('error-new-request-cooperation-message') }} </div>
                @endif
            </div>

            <div class="row mb-3 justify-content-center small">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Domovská stránka</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('nabidky-spoluprace.index') }}">Nabídky spolupráce</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail nabídky spolupráce</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10 ">
                    <h3>{{ $offer_cooperation->o_name }}</h3>
                    <div class="mb-3 mt-3">
                        <span class="small">Obor: </span>
                        <span class="badge rounded-pill bg-primary">{{ $offer_cooperation->f_name }}</span>
                        <p class="mt-2 mb-2 small">Projekt:
                            <a href="{{ route('projekty.show', $offer_cooperation->p_id_project) }}"
                               class="text-decoration-none">
                                {{ $offer_cooperation->p_name }}
                            </a>
                        </p>
                        <p class="mt-0 mb-0 small">Datum zveřejnění: {{ $offer_cooperation->o_create_date }}</p>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#NewRequestCooperationModal"
                    @if($isUser_TeamMember OR $userAlreadySentWRequest) {{ 'disabled' }} @endif >
                        Žádost o spolupráci
                    </button>
                    @if($isUser_TeamMember)
                    <span class="small ms-1 fst-italic">- Již jste členem projektového týmu.</span>
                    @endif
                    @if($userAlreadySentWRequest)
                        <span class="small ms-1 fst-italic">- Odeslaná žádost čeká na vyřízení.</span>
                    @endif

                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-lg-9">
                    <div class="card mt-2">
                        <div class="card-header py-3 px-4 text-primary">Popis nabídky spolupráce</div>
                        <div class="card-body py-4 px-4">
                            <p class="mb-3">
                                {{ $offer_cooperation->o_description }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>


        </div>


        <!-- Modal  -->
        <div class="modal fade" id="NewRequestCooperationModal" data-bs-backdrop="static" data-bs-keyboard="false"
             tabindex="-1"
             aria-labelledby="NewRequestCooperationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Žádost o spolupráci</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="new-request-cooperation"
                              action="{{ route('nabidky-spoluprace.handle-forms', $offer_cooperation->o_id_offer) }}"
                              method="post">
                            @csrf
                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    <span>Projekt: </span>
                                    <span class="fw-bold">{{ $offer_cooperation->p_name }}</span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    <span>Obor: </span>
                                    <span class="badge rounded-pill bg-primary ">{{ $offer_cooperation->f_name }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message-request-cooperation" class="form-label">Zpráva žádosti
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="message-request-cooperation"
                                          name="request-message" rows="8" required></textarea>
                            </div>
                            <input type="hidden" name="request-id-user"
                                   value="{{ \Illuminate\Support\Facades\Auth::id() }}">
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


    </section>

    <script>
        // Vymazání obsahu modal okna při novém zobrazení stránky
        window.onpageshow = function () {
            //document.getElementById("request-id-user").value = '';
            document.getElementById("message-request-cooperation").value = '';
            //var myModal = document.getElementById('NewOfferCooperationModal');
            //myModal.hide();
        };
    </script>

@endsection
