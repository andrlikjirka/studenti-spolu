@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Uživatelé</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam feugiat, turpis at pulvinar
                        vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. Etiam quis quam.
                    </p>
                </div>
            </div>
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">

                    <!-- FILTR (HLEDANI DNE OBORU) -->
                    <div class="mb-4">
                        <form id="hledat-uzivatele" action="" method="post" class="">
                            <div class="">
                                <select class="form-select-sm" aria-label="Default select example">
                                    <option selected value=""></option>
                                    <option value="1">Informační management</option>
                                    <option value="2">Informatika</option>
                                    <option value="3">Marketing</option>
                                    <option value="4">Podniková ekonomika</option>
                                    <option value="5">Projektový management</option>
                                    <option value="6">Průmyslový management</option>
                                    <option value="7">Systémové inženýrství a informatika</option>
                                </select>
                                <button type="submit" class="mb-1 ms-2 btn btn-sm btn-outline-primary" name="action"
                                        value="hledat-uzivatele">Hledat uživatele dle oboru
                                </button>
                            </div>
                        </form>
                        <hr class="dropdown-divider">
                    </div>
                    <div class="card">
                        <div class="card-body py-4 px-4">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary small">
                                    <tr>
                                        <th>Jméno a příjmení</th>
                                        <th>Obor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="./uzivatele/1" class="d-block">Jiří Andrlík</a></td>
                                        <td>
                                            <span class="badge bg-light text-dark">Informační management</span>
                                            <span class="badge bg-light text-dark">Systémové inženýrství a informatika</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="" class="d-block">Jana Novotná</a></td>
                                        <td>
                                            <span class="badge bg-light text-dark">Průmyslové inženýrství</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="" class="d-block">Petra Stará</a></td>
                                        <td>
                                            <span class="badge bg-light text-dark">Informatika</span>
                                            <span class="badge bg-light text-dark">Výpočetní technika</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="" class="d-block">Karel Nový</a></td>
                                        <td>
                                            <span class="badge bg-light text-dark">Podniková ekonomika</span>
                                            <span class="badge bg-light text-dark">Projektový management</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </section>

@endsection
