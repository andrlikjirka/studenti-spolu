<?php

namespace App\Http\Controllers;

use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro úpravu uživatelského profilu
 */
class MyProfileController extends Controller
{
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;
    /** @var FieldRepositoryInterface Atribut typu repository pro práci s obory */
    protected $fields;
    /** @var UserFieldRepositoryInterface Atribut typu repository pro práci s obory uživatelů */
    protected $user_fields;

    /**
     * Konstruktor třídy
     * @param UserRepositoryInterface $users Rozhraní třídy pro práci s uživateli
     * @param FieldRepositoryInterface $fields Rozhraní třídy pro práci s obory
     * @param UserFieldRepositoryInterface $user_fields Rozhraní třídy pro práci s obory uživatelů
     */
    public function __construct(UserRepositoryInterface $users, FieldRepositoryInterface $fields, UserFieldRepositoryInterface $user_fields)
    {
        $this->users = $users;
        $this->fields = $fields;
        $this->user_fields = $user_fields;
    }

    /**
     * Metoda získá data o uživatelskem profilu a předá je šabloně
     * @return mixed View reprezentující šablonu pro můj profil | stránka 404
     */
    public function index(): mixed
    {
        $title = 'Můj profil';
        $id_user = Auth::id();
        $profile = $this->users->getActiveUserById($id_user);
        if (count($profile) == 1) {
            $fields = $this->fields->getAllFields();
            $user_fields = $this->user_fields->getUserFieldsByUserId($id_user);

            return view('muj-profil/index')
                ->with('title', $title)
                ->with('profile', $profile[0])
                ->with('fields', $fields)
                ->with('user_fields', $user_fields);
        } else {
            return abort(404, 'Můj profil nenalezen.');
        }
    }

    /**
     * Metoda slouží pro zpracování formulářů na stránce Můj profil
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request): RedirectResponse
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

    /**
     * Metoda slouží pro úpravu uživatelského profilu
     * @param Request $request HTTP požadavek
     */
    private function editProfile(Request $request)
    {
        $request->validate([
            'first-name' => 'required|string|max:45',
            'last-name' => 'required|string|max:45',
            'email' => 'required|email|max:255',
        ]);
        $id_user = Auth::id();
        $edit_first_name = $this->testStringInput($request->input('first-name'));
        $edit_last_name = $this->testStringInput($request->input('last-name'));
        $edit_email = $this->testStringInput($request->input('email'));
        $edit_description = $this->testStringInput($request->input('description'));

        $this->users->editUserById($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description);

    }

    /**
     * Metoda slouží pro úpravu přihlašovacích údajů
     * @param Request $request HTTP požadavek
     */
    private function editPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255|confirmed'
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($this->testStringInput($request->input('password')));
        $user->save();
    }

    /**
     * Metoda slouží pro úpravu oborů znalostí a dovedností uživatele
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek úpravy oborů znalostí a dovedností
     */
    private function editFields(Request $request): mixed
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
