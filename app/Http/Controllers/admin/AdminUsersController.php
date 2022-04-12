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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $users;

    protected $projects;

    protected $fields;

    protected $user_fields;

    protected $status_user;

    protected $rights;

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

    public function index(Request $request)
    {
        $title = 'Administrace uživatelů';
        $users = $this->users->getAllUsers();
        return view('admin.uzivatele.index')
            ->with('title', $title)
            ->with('users', $users);
    }

    public function show($id_user)
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

    public function handle(Request $request, $id_user) {
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

    private function editUser(Request $request, $id_user)
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
        $edit_id_status = $request->input('edit_id_status');
        $edit_id_right = $request->input('edit_id_right');
        $this->users->editUserByIdSuperAdmin($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description, $edit_id_status, $edit_id_right);
    }

    private function deleteUser($id_user)
    {
        $author_projects = $this->projects->getProjectsByUserId($id_user, 1);
        $result = $this->users->deleteUserById($id_user, $author_projects, $this->projects);
        return $result;
    }

    private function editPassword(Request $request, $id_user)
    {
        $request->validate([
            'password' => 'required|string|max:255|confirmed'
        ]);
        $user = User::find($id_user);
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

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
