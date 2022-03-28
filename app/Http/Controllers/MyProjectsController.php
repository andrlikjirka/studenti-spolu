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
                   u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
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
                AND   r.id_role = 1
                AND p.id_project IN (
                    SELECT c.id_project FROM cooperation c
                        WHERE   c.id_user = :id_user
                        AND   c.id_role = :id_role
                );
        ', ['id_user' => $logged_user_id, 'id_role' => 2]);

        return view('moje-projekty.index')
            ->with('title', $title)
            ->with('projects_author', $projects_author)
            ->with('projects_collab', $projects_collab);
    }

    public function show($id)
    {
        $title = 'Úprava projektu';
        $logged_user_id = Auth::id();

        // zpracování formuláře pro odebrání člena týmu
        //$remove_team_member = $this->removeTeamMember($id);

        $my_project = DB::select('
           SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.name as s_name,
                   u.first_name as u_first_name, u.last_name as u_last_name, s.id_status as id_status, DATE(p.create_date) as create_date
           FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   c.id_role = r.id_role
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                -- AND   u.id_user = :id_user
                AND   r.id_role = :id_role;
        ', [':id_project' => $id, 'id_role' => 1]);

        $team_members = DB::select('
        SELECT u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.login as u_login, r.name as r_name
        FROM users u, cooperation c, project p, role r
            WHERE u.id_user = c.id_user
            AND   c.id_project = p.id_project
            AND   c.id_role = r.id_role
            AND   p.id_project = :id_project
            ORDER BY c.id_role;
        ', ['id_project' => $id]);

        return view('moje-projekty.show')
                    ->with('title', $title)
                    ->with('my_project', $my_project[0])
                    ->with('team_members', $team_members);
    }

    public function update($id)
    {
        request()->validate([
            'edit-name-project' => 'required|string|max:255',
            'edit-abstract-project' => 'required|string|max:255',
            'edit-description-project' => 'required',
            'edit-status-project' => 'required|integer|between:1,3',
        ]);

        $edit_name = request('edit-name-project');
        $edit_abstract = request('edit-abstract-project');
        $edit_description = request('edit-description-project');
        $edit_status = request('edit-status-project');

        DB::update('
            UPDATE project
                SET name = :name, abstract = :abstract,
                    description = :description, id_status = :id_status
                WHERE id_project = :id_project;
        ', [':name' => $edit_name, ':abstract' => $edit_abstract, ':description' => $edit_description,
            ':id_status' => $edit_status, ':id_project' => $id]);

        return redirect()->route('moje-projekty.show', $id)->with('edit_project_message', 'Úprava projektu proběhla úspěšně.');
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

    public function remove_team_member($id)
    {
        if (request('action') == 'remove-team-member') {
            $id_user = request('remove_id_user');
            DB::delete('
                DELETE FROM cooperation WHERE id_user = :id_user AND id_project = :id_project AND id_role = :id_role
            ', [':id_user' => $id_user, 'id_project' => $id, 'id_role' => 2]);
        }
        return redirect()->route('moje-projekty.show', $id)->with('remove_team_member_message', 'Odebrání člena týmu proběhlo úspěšně.');
    }

}
