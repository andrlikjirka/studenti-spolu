<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Project;

class MyProjectsController extends Controller
{
    public function index()
    {
        $title = 'Moje projekty';
        $logged_user_id = Auth::id();

        //autorské projekty
        $projects_author = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.name as s_name,
                   u.first_name as u_first_name, u.last_name as u_last_name, p.create_date as create_date
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_user = :id_user
                AND   r.id_role = :id_role;
        ', ['id_user' => $logged_user_id, 'id_role' => 1]);

        //spolupracovnické projekty
        $projects_collab = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.name as s_name,
                   u.first_name as u_first_name, u.last_name as u_last_name, p.create_date as create_date
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_user = :id_user
                AND   r.id_role = :id_role;
        ', ['id_user' => $logged_user_id, 'id_role' => 2]);

        return view('moje-projekty.index')
            ->with('title', $title)
            ->with('projects_author', $projects_author)
            ->with('projects_collab', $projects_collab);
    }

    public function show($id)
    {

        return view('moje-projekty.show');
    }

    public function edit()
    {

    }

    public function store()
    {
        $logged_user_id = Auth::id();

        request()->validate([
            'novy-projekt-nazev' => 'required|string|max:255',
            'novy-projekt-abstrakt' => 'string|max:255',
            'novy-projekt-popis' => 'required',
        ]);

        $name = request('novy-projekt-nazev');
        $abstract = request('novy-projekt-abstract');
        $description = request('novy-projekt-popis');
        $create_date = date("Y-m-d H:i:s");

        // Vložení záznamu o novém týmovém projektu do tabulky Projekt
        DB::insert('
            INSERT INTO project(name, abstract, description, create_date, id_status)
            VALUES (:name, :abstract, :description, :create_date, :id_status)
        ', [
            ':name' => $name,
            ':abstract' => $abstract,
            'description' => $description,
            'create_date' => $create_date,
            'id_status' => 1
        ]);

        $projectID = DB::getPdo()->lastInsertId();

        // Vložení záznamu do tablky Spolupráce (kdo je autorem na nově vytvořeném projektu)
        DB::insert('
            INSERT INTO cooperation(id_user, id_project, id_role)
            VALUES (:id_user, :id_project, :id_role)
        ', [
            ':id_user' => $logged_user_id,
            ':id_project' => $projectID,
            ':id_role' => 1
        ]);

        return redirect()->route('moje-projekty.index')->with('new_project_message', 'Vytvoření a zveřejnění nového projektu proběhlo úspěšně.');
    }

    public function destroy()
    {
        $delete_project_id = request('delete_id_project');

        DB::delete('
            DELETE FROM project WHERE id_project=:id_project
        ', ['id_project' => $delete_project_id]);

        return redirect()->route('moje-projekty.index')->with('delete_project_message', 'Odstranění projektu proběhlo úspěšně.');
    }

}
