<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjektyController;
use App\Http\Controllers\NabidkaSpolupraceController;
use App\Http\Controllers\UzivateleController;
use App\Http\Controllers\MujProfilController;
use App\Http\Controllers\MojeProjektyController;
use App\Http\Controllers\ZadostiController;
use App\Http\Controllers\RegistraceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

/*
|--------------------------------------------------------------------------
| Web Routess
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/projekty', [ProjektyController::class, 'index'])->name('projekty.index');

Route::get('/projekty/{id}', [ProjektyController::class, 'show'])->where('id', '[0-9]+')->name('projekty.show');

Route::get('/nabidky-spoluprace', [NabidkaSpolupraceController::class, 'index'])->name('nabidky-spoluprace.index');

Route::get('/uzivatele', [UzivateleController::class, 'index'])->name('uzivatele.index');

Route::get('/uzivatele/{id}', [UzivateleController::class, 'show'])->where('id', '[0-9]+')->name('uzivatele.show');

Route::get('/muj-profil', [MujProfilController::class, 'index'])->name('muj-profil.index');

Route::get('/moje-projekty', [MojeProjektyController::class, 'index'])->name('moje-projekty.index');

Route::get('/moje-projekty/{id}', [MojeProjektyController::class, 'show'])->where('id', '[0-9]+')->name('moje-projekty.show');

Route::get('/zadosti-o-spolupraci', [ZadostiController::class, 'index'])->name('zadosti.index');

Route::get('/registrace', [RegistraceController::class, 'show'])->name('registrace');
Route::post('/registrace', [RegistraceController::class, 'handle'] )->name('registrace');

Route::get('/prihlaseni', [LoginController::class, 'show'])->name('prihlaseni');
Route::post('/prihlaseni', [LoginController::class, 'handle'])->name('prihlaseni');

Route::post('/odhlaseni', [LogoutController::class, 'handle'])->name('odhlaseni');
