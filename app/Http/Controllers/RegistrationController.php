<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index()
    {
        $fields = DB::select('
            SELECT * FROM field;
        ');
        return view('registrace/index')
                ->with('fields', $fields);
    }

    public function handle(Request $request)
    {
        request()->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'login' => 'required|string|unique:users|max:60',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|confirmed',
        ]);

        $user = User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'login' => request('login'),
            'password' => Hash::make(request('password')),
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
        if (isset($redirectTo)) {
            return redirect($redirectTo);
        } else {
            return redirect()->route('index');
        }
    }
}
