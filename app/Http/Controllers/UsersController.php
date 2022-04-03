<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Uživatelé';
        if ($request->input('action') == 'search-user') {
            $request->validate([
                'last_name' => 'nullable|string',
            ]);
            $first_name = htmlspecialchars($request->input('first_name')).'%';
            $last_name = htmlspecialchars($request->input('last_name')).'%';
            $users = DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u
                WHERE u.first_name LIKE :first_name
                AND   u.last_name LIKE :last_name;
        ', [':first_name' => $first_name, ':last_name' => $last_name]);
        } else {
            $users = DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u;
        ');
        }
        return view('uzivatele/index')
                ->with('title', $title)
                ->with('users', $users);
    }

    public function show($id_user)
    {
        $user_fields = DB::select('
            SELECT f.id_field as f_id_field, f.name as f_name FROM users_field uf, field f
            WHERE uf.id_field = f.id_field
            AND   id_user = :id_user;
        ', [':id_user' => $id_user]);

        $user = DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.description FROM users u
                WHERE u.id_user = :id_user;
        ', [
            ':id_user' => $id_user,
        ]);

        $user_projects = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, p.abstract as p_abstract, DATE(p.create_date) as create_date,
                   s.name as s_name, u.first_name u_first_name, u.last_name as u_last_name
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_user = :id_user
                AND   r.id_role = :id_role
            ORDER BY p.create_date DESC;
        ', [
            ':id_user' => $id_user,
            ':id_role' => 1,
        ]);

        if(count($user) == 1) {
            return view('uzivatele.show')
                ->with('user', $user[0])
                ->with('user_fields', $user_fields)
                ->with('user_projects', $user_projects);
        } else {
            return abort(404, 'Uživatel nenalezen.'); //404 strana
        }

    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function store()
    {

    }

    public function destroy()
    {

    }

}
