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

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors([
            'login' => 'Chybně zadané přihlašovací údaje',
        ]);
    }
}
