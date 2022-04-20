<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Třída reprezentující kontroller pro odhlášení uživatele
 */
class LogoutController extends Controller
{
    /**
     * Metoda slouží pro zpracování odhlašovacího formuláře
     * @return RedirectResponse Přesměrování na route pro domovskou stránku
     */
    public function handle()
    {
        setcookie('url', '', time() - 3600*30, '/');
        unset($_COOKIE['url']);
        auth()->logout();
        return redirect('/');
    }
}
