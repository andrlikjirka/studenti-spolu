<?php

namespace App\Http\Controllers;

use App\Models\Uzivatel;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistraceController extends Controller
{
    public function show()
    {
        return view('registrace/show');
    }

    public function handle()
    {

        request()->validate([
            'jmeno' => 'required|string|max:45',
            'prijmeni' => 'required|string|max:45',
            'e-mail' => 'required|email|unique:uzivatel|max:255',
            'login' => 'required|string|unique:uzivatel|max:60',
            'heslo' => 'required|string|max:255|confirmed',
        ]);

        $uzivatel = Uzivatel::create([
            'jmeno' => request('jmeno'),
            'prijmeni' => request('prijmeni'),
            'e-mail' => request('e-mail'),
            'login' => request('login'),
            'heslo' => Hash::make(request('heslo')),
        ]);

        return redirect('/');
    }
}
