<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function show()
    {
        return view('registrace/show');
    }

    public function handle()
    {

        request()->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'login' => 'required|string|unique:users|max:60',
            'e-mail' => 'required|email|max:255',
            'password' => 'required|string|max:255|confirmed',
        ]);

        $user = User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'e-mail' => request('e-mail'),
            'login' => request('login'),
            'password' => Hash::make(request('password')),
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
