<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function handle()
    {
        auth()->logout();
        return redirect('/');
    }
}
