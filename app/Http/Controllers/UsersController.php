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
        if ($request->input('action') == 'search-user' AND $request->has('last_name')) {
            $request->validate([
                'last_name' => 'string',
            ]);
            $last_name = htmlspecialchars($request->input('last_name')).'%';
            $users = DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email FROM users u
                WHERE u.last_name LIKE :last_name;
        ', [':last_name' => $last_name]);
        } else {
            $users = DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email FROM users u;
        ');
        }
        return view('uzivatele/index')
                ->with('title', $title)
                ->with('users', $users);
    }

    public function show($id_user)
    {
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

        return view('uzivatele.show')
            ->with('user', $user[0])
            ->with('user_projects', $user_projects);
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
