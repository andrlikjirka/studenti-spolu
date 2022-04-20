<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro registraci nového uživatele
 */
class RegistrationController extends Controller
{
    /**
     * Metoda získá data o oborech a předá je šabloně pro registraci
     * @return View View reprezentující šablonu pro stránku registrace
     */
    public function index(): View
    {
        $fields = DB::select('
            SELECT * FROM field;
        ');
        return view('registrace/index')
                ->with('fields', $fields);
    }

    /**
     * Metoda slouží pro zpracování registračního formuláře (tj. registraci nového uživatele)
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'login' => 'required|string|unique:users|max:60',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|confirmed',
            'fields' => 'required'
        ]);

        $user = User::create([
            'first_name' => $this->testStringInput($request->input('first_name')),
            'last_name' => $this->testStringInput($request->input('last_name')),
            'email' => $this->testStringInput($request->input('email')),
            'login' => $this->testStringInput($request->input('login')),
            'password' => Hash::make($this->testStringInput($request->input('password'))),
        ]);

        $fields = $request->input('fields');
        foreach ($fields as $field) {
            DB::insert('
                INSERT INTO users_field(id_user, id_field)
                VALUES (:id_user, :id_field)
            ', [':id_user' => $user->id_user, 'id_field' => $field]);
        }

        if (isset($_COOKIE['url'])) {
            $redirectTo = $_COOKIE['url'];
            setcookie('url', '', time() - 3600);
        }
        $request->session()->regenerate();
        Auth::login($user);
        if (isset($redirectTo)) {
            return redirect($redirectTo);
        } else {
            return redirect()->route('index');
        }
    }
}
