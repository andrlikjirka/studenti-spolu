<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function handle()
    {
        setcookie('url', '', time() - 3600*30, '/');
        unset($_COOKIE['url']);
        auth()->logout();
        return redirect('/');
    }
}
