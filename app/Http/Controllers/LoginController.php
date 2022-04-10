<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('prihlaseni/index');
    }

    public function handle(Request $request)
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
