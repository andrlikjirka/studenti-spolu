<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OffersCooperationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\MyProjectsController;
use App\Http\Controllers\RequestsCooperationController;
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

Route::get('/projekty', [ProjectsController::class, 'index'])
    ->name('projekty.index');

Route::get('/projekty/{id}', [ProjectsController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('projekty.show');

Route::get('/nabidky-spoluprace', [OffersCooperationController::class, 'index'])
    ->middleware('prevent-back-history')
    ->name('nabidky-spoluprace.index');

Route::get('/nabidky-spoluprace/{id}', [OffersCooperationController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('prevent-back-history')
    ->name('nabidky-spoluprace.show');

Route::post('/nabidky-spoluprace/{id}', [OffersCooperationController::class, 'handle'])
    ->where('id', '[0-9]+')
    ->middleware('prevent-back-history')
    ->name('nabidky-spoluprace.handle-forms');

Route::get('/uzivatele', [UsersController::class, 'index'])
    ->name('uzivatele.index');

Route::get('/uzivatele/{id}', [UsersController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('uzivatele.show');

Route::get('/muj-profil', [MyProfileController::class, 'index'])
    ->name('muj-profil.index');

Route::get('/moje-projekty', [MyProjectsController::class, 'index'])
    ->middleware('prevent-back-history')
    ->name('moje-projekty.index');

Route::post('/moje-projekty', [MyProjectsController::class, 'store'])
    ->middleware('prevent-back-history')
    ->name('moje-projekty.store');

Route::delete('/moje-projekty', [MyProjectsController::class, 'destroy'])
    ->middleware('prevent-back-history')
    ->name('moje-projekty.destroy');

Route::get('/moje-projekty/{id}', [MyProjectsController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('prevent-back-history')
    ->name('moje-projekty.show');

Route::put('/moje-projekty/{id}', [MyProjectsController::class, 'update'])
    ->where('id', '[0-9]+')
    ->middleware('prevent-back-history')
    ->name('moje-projekty.update');

Route::post('/moje-projekty/{id}', [MyProjectsController::class, 'handle'])
    ->where('id', '[0-9]+')
    ->middleware('prevent-back-history')
    ->name('moje-projekty.handle-forms');

Route::get('/zadosti-o-spolupraci', [RequestsCooperationController::class, 'index'])
    ->middleware('prevent-back-history')
    ->name('zadosti.index');

Route::post('/zadosti-o-spolupraci', [RequestsCooperationController::class, 'handle'])
    ->middleware('prevent-back-history')
    ->name('zadosti-o-spolupraci.handle-forms');

Route::get('/registrace', [RegistraceController::class, 'show'])
    ->name('registrace');

Route::post('/registrace', [RegistraceController::class, 'handle'])
    ->name('registrace');

Route::get('/prihlaseni', [LoginController::class, 'show'])
    ->name('prihlaseni');

Route::post('/prihlaseni', [LoginController::class, 'handle'])
    ->name('prihlaseni');

Route::post('/odhlaseni', [LogoutController::class, 'handle'])
    ->name('odhlaseni');
