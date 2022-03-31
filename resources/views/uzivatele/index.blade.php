@extends('layouts.layout')

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

                    <!-- FILTR (HLEDANI DNE OBORU)
                    <div class="mb-4">
                        <form id="hledat-uzivatele" action="" method="get">
                            <label>
                                <input type="text" name="last_name">
                            </label>
                            <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                    value="search-user">Hledat uživatele
                            </button>
                        </form>
                        <hr class="dropdown-divider">
                    </div>
                    -->
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-body py-4 px-5">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-primary small">
                                            <tr class="">
                                                <th class="">Jméno a příjmení</th>
                                                <th class=""></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td class=""><a href="{{ route('uzivatele.show', $user->id_user) }}" class="d-block">{{ $user->first_name.' '.$user->last_name }}</a></td>
                                                    <td class=" ">
                                                        <a href="mailto::{{ $user->email }}" class="d-block btn btn-sm btn-outline-secondary w-50 pt-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-plus" viewBox="0 0 16 16">
                                                                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                                                                <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z"/>
                                                            </svg>
                                                        </a></td>
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
            </div>
        </div>
    </section>

@endsection
