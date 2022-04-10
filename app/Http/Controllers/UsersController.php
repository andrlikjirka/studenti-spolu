<?php

namespace App\Http\Controllers;

use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $users;

    protected $projects;

    public function __construct(UserRepositoryInterface $users, ProjectRepositoryInterface $projects)
    {
        $this->users = $users;
        $this->projects = $projects;
    }


    public function index(Request $request)
    {
        $title = 'Uživatelé';
        if ($request->input('action') == 'search-user') {
            $request->validate([
                'first_name' => 'nullable|string',
                'last_name' => 'nullable|string',
            ]);
            $first_name = htmlspecialchars($request->input('first_name')).'%';
            $last_name = htmlspecialchars($request->input('last_name')).'%';
            $users = $this->users->getSearchActiveUsers($first_name, $last_name);
        } else {
            $users = $this->users->getAllActiveUsers();
        }
        return view('uzivatele/index')
                ->with('title', $title)
                ->with('users', $users);
    }

    public function show($id_user)
    {
        $user = $this->users->getActiveUserById($id_user);
        if(count($user) == 1) {
            $user_fields = $this->users->getUserFieldsByUserId($id_user);
            $user_author_projects = $this->projects->getProjectsByUserId($id_user, 1);
            $user_cooperation_projects = $this->projects->getProjectsByUserId($id_user, 2);

            return view('uzivatele.show')
                ->with('user', $user[0])
                ->with('user_fields', $user_fields)
                ->with('user_author_projects', $user_author_projects)
                ->with('user_cooperation_projects', $user_cooperation_projects);
        } else {
            return abort(404, 'Uživatel nenalezen.'); //404 strana
        }

    }

}
