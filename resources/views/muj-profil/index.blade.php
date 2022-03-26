@extends('layouts.layout')

@section('content')

    <section class="bg-light" style="padding-top: 70px">
        <div class="container px-5 py-5">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-3">Můj profil</h3>
                    <p class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer rutrum, orci
                        vestibulum
                        ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet
                        enim.
                        Curabitur interdum.

                    </p>
                </div>
            </div>
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-header py-3 px-4 text-primary">Popis uživatele</div>
                        <div class="card-body py-4 px-4">
                            <form action="" autocomplete="off">
                                <!-- Jméno, Uživatelské jméno -->
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="lb_fname" class="form-label small">
                                                Jméno
                                            </label>
                                            <input type="text" class="form-control" id="lb_fname" value="Jiří" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="lb_lname" class="form-label small">
                                                Příjmení
                                            </label>
                                            <input type="text" class="form-control" id="lb_lname" value="Andrlík" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="lb_login" class="form-label small">
                                                Uživatelské jméno
                                            </label>
                                            <input type="text" class="form-control" id="lb_login" value="jandrlik" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="lb_email" class="form-label small">
                                                E-mail
                                            </label>
                                            <input type="text" class="form-control" id="lb_email"
                                                   value="andrlik.jirka@gmail.com" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Heslo, potvrzení hesla -->
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="lb_password" class="form-label small">
                                                Nové heslo
                                            </label>
                                            <input type="password" class="form-control" id="lb_password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label for="lb_confirm_password" class="form-label small">
                                                Potvrzení hesla
                                            </label>
                                            <input type="password" class="form-control" id="lb_confirm_password" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 px-4">Uložit změny</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header py-3 px-4 text-primary">Znalosti a dovednosti v oboru</div>
                        <div class="card-body py-4 px-4">
                            <form action="">
                                <div class="row ">
                                    <div class="col-md-9">
                                        <select class="form-select" aria-label="Default select example" required>
                                            <option selected disabled value="">Vyberte obor</option>
                                            <option value="1">Podniková ekonomika</option>
                                            <option value="2">Projektový management</option>
                                            <option value="3">Marketing</option>
                                            <option value="4">Průmyslový management</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary px-4">Přidat obor</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mt-3">
                                <div class="col-md-9">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-primary small">
                                            <tr>
                                                <th>Obor</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="small">
                                            <tr>
                                                <td>Informační management</td>
                                                <td>
                                                    <form action="" class="m-0 p-0">
                                                        <!-- input hidden -->
                                                        <button type='submit' class='btn btn-sm btn-outline-danger m-0 py-0 px-2'
                                                                onclick='deleteReviewer(event)'>
                                                            Odebrat
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Systémové inženýrství a informatika</td>
                                                <td>
                                                    <form action="" class="m-0 p-0">
                                                        <!-- input hidden -->
                                                        <button type='submit' class='btn btn-sm btn-outline-danger m-0 py-0 px-2'
                                                                onclick='deleteReviewer(event)'>
                                                            Odebrat
                                                        </button>
                                                    </form>
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
            </div>
        </div>
    </section>

@endsection
