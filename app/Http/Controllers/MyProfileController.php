<?php

namespace App\Http\Controllers;

use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $users;

    protected $fields;

    protected $user_fields;

    public function __construct(UserRepositoryInterface $users, FieldRepositoryInterface $fields, UserFieldRepositoryInterface $user_fields)
    {
        $this->users = $users;
        $this->fields = $fields;
        $this->user_fields = $user_fields;
    }

    public function index()
    {
        $title = 'Můj profil';
        $id_user = Auth::id();
        $profile = $this->users->getActiveUserById($id_user);
        $fields = $this->fields->getAllFields();
        $user_fields = $this->user_fields->getUserFieldsByUserId($id_user);

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
                    ->with('edit-fields-message', 'Úprava znalostí a dovedností v oborech proběhla úspěšně.');
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
        $id_user = Auth::id();
        $edit_first_name = $request->input('first-name');
        $edit_last_name = $request->input('last-name');
        $edit_email = $request->input('email');
        $edit_description = $request->input('description');

        $this->users->editUserById($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description);

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
        $id_user = Auth::id();
        $fields = $request->input('fields');
        $result = $this->user_fields->editUserFields($id_user, $fields);
        return $result;
    }

}
