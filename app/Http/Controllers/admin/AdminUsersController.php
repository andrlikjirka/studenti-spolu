<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\RightRepositoryInterface;
use App\Intefaces\StatusUserRepositoryInterface;
use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro administraci uživatelů
 */
class AdminUsersController extends Controller
{
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;
    /** @var ProjectRepositoryInterface Atribut typu repository pro práci s projekty */
    protected $projects;
    /** @var FieldRepositoryInterface Atribut typu repository pro práci s obory */
    protected $fields;
    /** @var UserFieldRepositoryInterface Atribut typu repository pro práci s obory uživatelů */
    protected $user_fields;
    /** @var StatusUserRepositoryInterface Atribut typu repository pro práci se stavy uživatelů */
    protected $status_user;
    /** @var RightRepositoryInterface Atribut typu repository pro práci s právy uživatelů */
    protected $rights;

    /**
     * Konstruktor třídy
     * @param UserRepositoryInterface $users Rozhraní třídy pro práci s uživateli
     * @param StatusUserRepositoryInterface $status_user Rozhraní třídy pro práci se stavy uživatelů
     * @param FieldRepositoryInterface $fields Rozhraní třídy pro práci s obory
     * @param UserFieldRepositoryInterface $user_fields Rozhraní třídy pro práci s obory uživatelů
     * @param RightRepositoryInterface $rights Rozhraní třídy pro práci s právy uživatelů
     * @param ProjectRepositoryInterface $projects Rozhraní třídy pro práci s projekty
     */
    public function __construct(UserRepositoryInterface $users, StatusUserRepositoryInterface $status_user, FieldRepositoryInterface $fields,
                                UserFieldRepositoryInterface $user_fields, RightRepositoryInterface $rights, ProjectRepositoryInterface $projects)
    {
        $this->users = $users;
        $this->fields = $fields;
        $this->user_fields = $user_fields;
        $this->status_user = $status_user;
        $this->rights = $rights;
        $this->projects = $projects;
    }

    /**
     * Metoda získá data všech uživatelů a předá je šabloně pro administraci uživatelů
     * @return View Šablona pro administraci uživatelů
     */
    public function index(): View
    {
        $title = 'Administrace uživatelů';
        $users = $this->users->getAllUsers();
        return view('admin.uzivatele.index')
            ->with('title', $title)
            ->with('users', $users);
    }

    /**
     * Metoda získá příslušná data o vybraném uživateli a předá je šabloně pro úpravu vybraného uživatele
     * @param $id_user int ID uživatele
     * @return mixed View reprezentující šablonu pro administraci uživatelů | stránka 404
     */
    public function show($id_user):mixed
    {
        $user = $this->users->getUserById($id_user);
        if (count($user) == 1) {
            $fields = $this->fields->getAllFields();
            $user_fields = $this->user_fields->getUserFieldsByUserId($id_user);
            $all_status_user = $this->status_user->getAllStatusUser();
            $rights = $this->rights->getAllRights();
            return view('admin.uzivatele.show')
                ->with('user', $user[0])
                ->with('fields', $fields)
                ->with('user_fields', $user_fields)
                ->with('all_status_user', $all_status_user)
                ->with('rights', $rights);
        } else {
            return abort(404, 'Uživatel nenalezen.'); //404 strana
        }
    }

    /**
     * Metoda slouží pro zpracování formulářů na stránkách pro administraci uživatelů
     * @param Request $request HTTP požadavek
     * @param $id_user int ID uživatele
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request, $id_user):RedirectResponse {
        if ($request->input('action') == 'edit-user') {
            $this->editUser($request, $id_user);
            return redirect()->route('admin.uzivatele.show', $id_user)
                ->with('edit-user-message', 'Úprava uživatele proběhla úspešně.');
        } elseif ($request->input('action') == 'delete-user') {
            $result = $this->deleteUser($id_user);
            if ($result == null) {
                return redirect()->route('admin.uzivatele.index')
                    ->with('delete-user-message', 'Smazání uživatele a všech jeho podřízených objektů proběhlo úspešně.');
            } else {
                return redirect()->route('admin.uzivatele.index')
                    ->with('error-delete-user-message', 'Smazání uživatele a všech jeho podřízených objektů selhalo.');
            }
        } elseif ($request->input('action') == 'edit-password') {
            $this->editPassword($request, $id_user);
            return redirect()->route('admin.uzivatele.show', $id_user)
                ->with('edit-password-message', 'Úprava hesla proběhla úspěšně.');
        } elseif ($request->input('action') == 'edit-fields') {
            $result = $this->editFields($request, $id_user);
            if ($result == null) {
                return redirect()->route('admin.uzivatele.show', $id_user)
                    ->with('edit-fields-message', 'Úprava znalostí a dovedností v oborech proběhla úspěšně.');
            } else {
                return redirect()->route('admin.uzivatele.show', $id_user)
                    ->with('error-edit-fields-message', 'Úprava znalostí a dovedností v oborech selhala.');
            }
        }
        // defalt route back
        return redirect()->route('admin.uzivatele.show', $id_user);
    }

    /**
     * Metoda slouží pro úpravu vybraného uživatele
     * @param Request $request HTTP požadavek
     * @param $id_user int ID uživatele
     */
    private function editUser(Request $request, $id_user)
    {
        $request->validate([
            'first-name' => 'required|string|max:45',
            'last-name' => 'required|string|max:45',
            'email' => 'required|email|max:255',
        ]);
        $edit_first_name = $this->testStringInput($request->input('first-name'));
        $edit_last_name = $this->testStringInput($request->input('last-name'));
        $edit_email = $this->testStringInput($request->input('email'));
        $edit_description = $this->testStringInput($request->input('description'));
        $edit_id_status = $this->testIntegerInput($request->input('edit_id_status'));
        $edit_id_right = $this->testIntegerInput($request->input('edit_id_right'));
        $this->users->editUserByIdSuperAdmin($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description, $edit_id_status, $edit_id_right);
    }

    /**
     * Metoda slouží pro odstranění vybraného uživatele
     * @param $id_user int ID uživatele
     * @return mixed Výsledek odstranění uživatele
     */
    private function deleteUser($id_user)
    {
        $author_projects = $this->projects->getProjectsByUserId($id_user, 1);
        $result = $this->users->deleteUserById($id_user, $author_projects, $this->projects);
        return $result;
    }

    /**
     * Metoda slouží pro úpravu přihlašovacích údajů uživatele
     * @param Request $request HTTP požadavek
     * @param $id_user int ID uživatele
     */
    private function editPassword(Request $request, $id_user)
    {
        $request->validate([
            'password' => 'required|string|max:255|confirmed'
        ]);
        $user = User::find($id_user);
        $user->password = Hash::make($this->testStringInput($request->input('password')));
        $user->save();
    }

    /**
     * Metoda slouží pro úpravu oborů znalostí a dovedností vybraného uživatele
     * @param Request $request HTTP požadavek
     * @param $id_user int ID uživatele
     * @return mixed Výsledek úpravy výběru oborů znalostí a dovedností uživatele
     */
    private function editFields(Request $request, $id_user)
    {
        $request->validate([
            'fields' => 'required'
        ]);
        $fields = $request->input('fields');
        $result = $this->user_fields->editUserFields($id_user, $fields);
        return $result;
    }


}
