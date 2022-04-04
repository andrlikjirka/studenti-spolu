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
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, DATE(p.create_date) as create_date,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.id_status as u_id_status
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_status = :id_status
                AND   r.id_role = :id_role
            ORDER BY p.create_date DESC;
        ', [':id_status' => 1, ':id_role' => 1]); //ziskat data z DB

        return view('projekty/index')
            ->with('title', $title)
            ->with('projects', $projects);
    }

    public function show($id_project)
    {
        $project = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.id_status as s_id_status,
                   s.name as s_name, u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                AND   c.id_role = :id_role
                AND   u.id_status = :id_status;
        ', [':id_project' => $id_project, ':id_role' => 1, ':id_status' => 1]);

        $team_members = DB::select('
        SELECT u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.login as u_login, r.name as r_name
        FROM users u, cooperation c, project p, role r
            WHERE u.id_user = c.id_user
            AND   c.id_project = p.id_project
            AND   c.id_role = r.id_role
            AND   p.id_project = :id_project
            ORDER BY c.id_role;
        ', ['id_project' => $id_project]);

        $project_offers_cooperation = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
               DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
               s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                AND   p.id_project = :id_project
                ORDER BY o.create_date;
        ', [
            ':id_status' => 1,
            ':id_project' => $id_project,
        ]);

        $files = DB::select('SELECT * FROM file WHERE id_project=:id_project', [':id_project' => $id_project]);

        if(count($project) == 1) {
            return view('projekty.show')
                ->with('project', $project[0]) //$project je pole s jednim prvkem = ziskany projekt => chci primo ziskane pole, proto [0]
                ->with('files', $files)
                ->with('team_members', $team_members)
                ->with('project_offers', $project_offers_cooperation);
        } else {
            return abort(404, 'Projekt nenalezen.'); //404 strana
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
