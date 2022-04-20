<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro přihlašování
 */
class LoginController extends Controller
{

    /**
     * Metoda zajistí zobrazení přihlašovací stránky
     * @return View Šablona přihlašovací stránky
     */
    public function index()
    {
        return view('prihlaseni/index');
    }

    /**
     * Metoda slouží pro zpracování přihlašovacího formuláře
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na route pro úvodní stránku
     */
    public function handle(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);
        $credentials['id_status'] = 1; //user active?

        if (Auth::attempt($credentials)){
            //in case intended url is available
            if (isset($_COOKIE['url'])) {
                $redirectTo = $_COOKIE['url'];
                setcookie('url', '', time() - 3600, '/');
                unset($_COOKIE['url']);
            }
            $request->session()->regenerate();
            if (isset($redirectTo)) {
                return redirect($redirectTo);
            } else {
                return redirect()->route('index');
            }
        }
        return back()->withErrors([
            'login' => 'Chybně zadané přihlašovací údaje',
        ]);
    }
}
