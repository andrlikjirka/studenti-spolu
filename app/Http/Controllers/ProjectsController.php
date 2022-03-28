<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{

    public function index()
    {
        $title = 'Projekty';
        $projects = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.name as s_name,
                   u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   r.id_role = 1
            ORDER BY p.create_date DESC;
        '); //ziskat data z DB

        return view('projekty/index')
                    ->with('title', $title)
                    ->with('projects', $projects);
    }

    public function show($id)
    {
        $project = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.name as s_name,
                   u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                AND   c.id_role = 1;
        ', [':id_project' => $id]);

        $team_members = DB::select('
        SELECT u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.login as u_login, r.name as r_name
        FROM users u, cooperation c, project p, role r
            WHERE u.id_user = c.id_user
            AND   c.id_project = p.id_project
            AND   c.id_role = r.id_role
            AND   p.id_project = :id_project
            ORDER BY c.id_role;
        ', ['id_project' => $id]);

        return view('projekty.show')
            ->with('project', $project[0]) //$project je pole s jednim prvkem = ziskany projekt => chci primo ziskane pole, proto [0]
            ->with('team_members', $team_members);
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
