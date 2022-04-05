<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    public function index()
    {
        $title = 'Můj profil';
        $profile = DB::select('
            SELECT first_name, last_name, login, email, description
            FROM users
            WHERE id_user = :id_user;
        ', [':id_user' => Auth::id()]);

        $fields = DB::select('
            SELECT * FROM field;
        ');

        $user_fields = DB::select('
            SELECT id_field FROM users_field WHERE id_user=:id_user;
        ', [':id_user' => Auth::id()]);

        return view('muj-profil/index')
                ->with('title', $title)
                ->with('profile', $profile[0])
                ->with('fields', $fields)
                ->with('user_fields', $user_fields);
    }

    public function handle(Request $request)
    {
        if ($request->input('action') == 'edit-profile') {
            $this->editProfile($request);
            return redirect()->route('muj-profil.index')
                    ->with('edit-profile-message', 'Úprava profilu proběhla úspešně.');
        } else if ($request->input('action') == 'edit-password') {
            $this->editPassword($request);
            return redirect()->route('muj-profil.index')
                    ->with('edit-password-message', 'Úprava hesla proběhla úspěšně.');
        } else if ($request->input('action') == 'edit-fields') {
            $result = $this->editFields($request);
            if ($result == null) {
                return redirect()->route('muj-profil.index')
                    ->with('edit-fields-message', 'Úprava znalostní a dovedností v oborech proběhla úspěšně.');
            }
        }
        //default route
        return redirect()->route('muj-profil.index')
            ->with('edit-profile-message', 'bla');
    }

    private function editProfile(Request $request)
    {
        $request->validate([
            'first-name' => 'required|string|max:45',
            'last-name' => 'required|string|max:45',
            'email' => 'required|email|max:255',
        ]);

        $edit_first_name = $request->input('first-name');
        $edit_last_name = $request->input('last-name');
        $edit_email = $request->input('email');
        $edit_description = $request->input('description');

        $user = User::find(Auth::id());
        $user->first_name = $edit_first_name;
        $user->last_name = $edit_last_name;
        $user->email = $edit_email;
        $user->description = $edit_description;
        $user->save();
    }

    private function editPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255|confirmed'
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

    private function editFields(Request $request)
    {
        $request->validate([
           'fields' => 'required'
        ]);

        $fields = $request->input('fields');
        $result = DB::transaction(function () use ($fields){
            DB::delete('DELETE FROM users_field WHERE id_user = :id_user', [':id_user' => Auth::id()]);
            foreach ($fields as $field) {
                DB::insert('
                INSERT INTO users_field(id_user, id_field)
                VALUES (:id_user, :id_field)
            ', [':id_user' => Auth::id(), 'id_field' => $field]);
            }
        });
        return $result;
    }

}
