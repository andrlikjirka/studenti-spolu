<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OffersCooperationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\MyProjectsController;
use App\Http\Controllers\RequestsCooperationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\admin\AdminController;

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
})->middleware('delete-url-cookie')
    ->name('index');

Route::get('/projekty', [ProjectsController::class, 'index'])
    ->middleware('delete-url-cookie')
    ->name('projekty.index');

Route::get('/projekty/{id}', [ProjectsController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('projekty.show');

Route::get('/nabidky-spoluprace', [OffersCooperationController::class, 'index'])
    ->middleware('auth')
    ->name('nabidky-spoluprace.index');

Route::get('/nabidky-spoluprace/{id}', [OffersCooperationController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('nabidky-spoluprace.show');

Route::post('/nabidky-spoluprace/{id}', [OffersCooperationController::class, 'handle'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('nabidky-spoluprace.handle-forms');

Route::get('/uzivatele', [UsersController::class, 'index'])
    ->middleware('auth')
    ->name('uzivatele.index');

Route::get('/uzivatele/{id}', [UsersController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('uzivatele.show');

Route::get('/muj-profil', [MyProfileController::class, 'index'])
    ->middleware('auth')
    ->name('muj-profil.index');

Route::post('/muj-profil', [MyProfileController::class, 'handle'])
    ->middleware('auth')
    ->name('muj-profil.handle-forms');

Route::get('/moje-projekty', [MyProjectsController::class, 'index'])
    ->middleware('auth')
    ->name('moje-projekty.index');

Route::post('/moje-projekty', [MyProjectsController::class, 'store'])
    ->middleware('auth')
    ->name('moje-projekty.store');

Route::delete('/moje-projekty', [MyProjectsController::class, 'destroy'])
    ->middleware('auth')
    ->name('moje-projekty.destroy');

Route::get('/moje-projekty/{id}', [MyProjectsController::class, 'show'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('moje-projekty.show');

Route::put('/moje-projekty/{id}', [MyProjectsController::class, 'update'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('moje-projekty.update');

Route::post('/moje-projekty/{id}', [MyProjectsController::class, 'handle'])
    ->where('id', '[0-9]+')
    ->middleware('auth')
    ->name('moje-projekty.handle-forms');

Route::get('/zadosti-o-spolupraci', [RequestsCooperationController::class, 'index'])
    ->middleware('auth')
    ->name('zadosti-o-spolupraci.index');

Route::post('/zadosti-o-spolupraci', [RequestsCooperationController::class, 'handle'])
    ->middleware('auth')
    ->name('zadosti-o-spolupraci.handle-forms');

Route::get('/registrace', [RegistrationController::class, 'index'])
    ->name('registrace');

Route::post('/registrace', [RegistrationController::class, 'handle'])
    ->name('registrace');

Route::get('/prihlaseni', [LoginController::class, 'index'])
    ->name('prihlaseni');

Route::post('/prihlaseni', [LoginController::class, 'handle'])
    ->name('prihlaseni');

Route::post('/odhlaseni', [LogoutController::class, 'handle'])
    ->name('odhlaseni');

Route::get('/soubory/{id}', [FilesController::class, 'show'])
    ->middleware('auth')
    ->name('soubory');

Route::get('/administrace', [AdminController::class, 'index'])
    ->middleware('auth')
    ->middleware('can:isAdmin')
    ->name('admin.index');
