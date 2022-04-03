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
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, s.name as s_name,
                   u.id_user as u_id_user ,u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_user = :id_user
                AND   r.id_role = :id_role
            ORDER BY p.create_date DESC;
        ', ['id_user' => $logged_user_id, 'id_role' => 1]);

        //spolupracovnické projekty
        $projects_collab = DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, s.name as s_name,
                   u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, p.create_date as create_date
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
                )
            ORDER BY p.create_date DESC;
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

        $my_project = $this->getMyProjectInfo($id);
        $status_project_all = $this->getAllProjectStatus();

        $team_members = $this->getTeamMembers($id);

        $offers_cooperation = $this->getOffersCooperation($id);

        $fields_all = $this->getAllFields();
        $status_offer_all = $this->getAllOfferStatus();

        return view('moje-projekty.show')
            ->with('title', $title)
            ->with('my_project', $my_project[0])
            ->with('status_project_all', $status_project_all)
            ->with('team_members', $team_members)
            ->with('offers_cooperation', $offers_cooperation)
            ->with('fields_all', $fields_all)
            ->with('status_offer_all', $status_offer_all);
    }

    private function getMyProjectInfo($id_project)
    {
        $my_project = DB::select('
           SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.name as s_name, DATE(p.create_date) as create_date,
                  u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, s.id_status as id_status
           FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   c.id_role = r.id_role
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                -- AND   u.id_user = :id_user
                AND   r.id_role = :id_role;
        ', [':id_project' => $id_project, 'id_role' => 1]);
        return $my_project;
    }

    private function getAllProjectStatus()
    {
        $status_project_all = DB::select('
            SELECT * FROM status_project;
        ');
        return $status_project_all;
    }

    private function getTeamMembers($id_project)
    {
        $team_members = DB::select('
        SELECT u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.login as u_login, r.id_role as r_id_role, r.name as r_name
        FROM users u, cooperation c, project p, role r
            WHERE u.id_user = c.id_user
            AND   c.id_project = p.id_project
            AND   c.id_role = r.id_role
            AND   p.id_project = :id_project
            ORDER BY c.id_role;
        ', ['id_project' => $id_project]);

        return $team_members;
    }

    private function getOffersCooperation($id_project)
    {
        $offersCooperation = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer, o.name as o_name, o.description as o_description,
                   DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                   s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   p.id_project = :id_project
                ORDER BY o.create_date;
        ', [
            ':id_project' => $id_project,
        ]);
        return $offersCooperation;
    }

    private function getAllFields()
    {
        $fields_all = DB::select('
            SELECT * FROM field;
        ');
        return $fields_all;
    }

    private function getAllOfferStatus()
    {
        $status_offer_all = DB::select('
            SELECT * FROM status_offer;
        ');
        return $status_offer_all;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'edit-name-project' => 'required|string|max:255',
            'edit-abstract-project' => 'required|string|max:255',
            'edit-description-project' => 'required',
            'edit-status-project' => 'required|integer|between:1,3',
        ]);

        $edit_name = $request->input('edit-name-project');
        $edit_abstract = $request->input('edit-abstract-project');
        $edit_description = $request->input('edit-description-project');
        $edit_status = $request->input('edit-status-project');

        DB::update('
            UPDATE project
                SET name = :name, abstract = :abstract,
                    description = :description, id_status = :id_status
                WHERE id_project = :id_project;
        ', [':name' => $edit_name, ':abstract' => $edit_abstract, ':description' => $edit_description,
            ':id_status' => $edit_status, ':id_project' => $id]);

        return redirect()->route('moje-projekty.show', $id)
            ->with('edit_project_message', 'Úprava projektu proběhla úspěšně.');
    }

    public function store(Request $request)
    {
        $logged_user_id = Auth::id();

        $request->validate([
            'new-name-project' => 'required|string|max:255',
            'new-abstract-project' => 'string|max:255',
            'new-description-project' => 'required',
        ]);

        $name = $request->input('new-name-project');
        $abstract = $request->input('new-abstract-project');
        $description = $request->input('new-description-project');
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

        // Vložení záznamu do tabulky Spolupráce (kdo je autorem na nově vytvořeném projektu)
        DB::insert('
            INSERT INTO cooperation(id_user, id_project, id_role)
            VALUES (:id_user, :id_project, :id_role)
        ', [
            ':id_user' => $logged_user_id,
            ':id_project' => $projectID,
            ':id_role' => 1
        ]);

        return redirect()->route('moje-projekty.show', $projectID)->with('new_project_message', 'Vytvoření a zveřejnění nového projektu proběhlo úspěšně.');
    }

    public function destroy(Request $request)
    {
        $delete_project_id = $request->input('delete_id_project');

        DB::delete('
            DELETE FROM project WHERE id_project=:id_project
        ', ['id_project' => $delete_project_id]);

        return redirect()->route('moje-projekty.index')->with('delete_project_message', 'Odstranění projektu proběhlo úspěšně.');
    }

    // funkce pro zpracovani doplnujicich formularu na strance detailu mého projektu
    public function handle(Request $request, $id_project)
    {
        if ($request->input('action') == 'remove-team-member') {
            $result = $this->remove_team_member($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove_team_member_message', 'Odebrání člena týmu proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error_remove_team_member_message', 'Odebrání člena týmu selhalo.');
            }
        } else if ($request->input('action') == 'new-offer-cooperation') {
            $result = $this->new_cooperation_offer($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('new-offer-cooperation-message', 'Vytvoření a zveřejnění nové nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-new-offer-cooperation-message', 'Vytvoření a zveřejnění nové nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'remove-offer-cooperation') {
            $result = $this->remove_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove-offer-cooperation-message', 'Smazání nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-remove-offer-cooperation-message', 'Smazání nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'edit-offer-cooperation') {
            $result = $this->edit_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('edit-offer-cooperation-message', 'Úprava nabídky spolupráce proběhla úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-edit-offer-cooperation-message', 'Úprava nabídky spolupráce selhala.');
            }
        }
        //default route back
        return redirect()->route('moje-projekty.show', $id_project);
    }

    private function remove_team_member(Request $request, $id_project)
    {
        $id_user = $request->input('remove_id_user');
        $result = DB::delete('
            DELETE FROM cooperation WHERE id_user = :id_user AND id_project = :id_project AND id_role = :id_role
        ', [':id_user' => $id_user, ':id_project' => $id_project, ':id_role' => 2]);
        return $result;
    }

    private function new_cooperation_offer(Request $request, $id_project)
    {
        $request->validate([
            'name-offer-cooperation' => 'required|string|max:255',
            'field-offer-cooperation' => 'required|integer',
            'description-offer-cooperation' => 'required',
        ]);

        $name = $request->input('name-offer-cooperation');
        $id_field = $request->input('field-offer-cooperation');
        $description = $request->input('description-offer-cooperation');
        $create_date = date("Y-m-d H:i:s");

        $result = DB::insert('
            INSERT INTO offer_cooperation(name, description, create_date, id_field, id_project, id_status)
            VALUES (:name, :description, :create_date, :id_field, :id_project, :id_status)
        ', [
            ':name' => $name,
            ':description' => $description,
            ':create_date' => $create_date,
            ':id_field' => $id_field,
            ':id_project' => $id_project,
            ':id_status' => 1,
        ]);

        return $result;
    }

    private function edit_offer_cooperation(Request $request, $id_project)
    {
        $request->validate([
            'edit-id-offer' => 'required|integer',
            'edit-name-offer-cooperation' => 'required|string|max:255',
            'edit-field-offer-cooperation' => 'required|integer',
            'edit-description-offer-cooperation' => 'required',
            'edit-status-offer-cooperation' => 'required|integer'
        ]);

        $edit_id_offer = $request->input('edit-id-offer');
        $edit_name_offer = $request->input('edit-name-offer-cooperation');
        $edit_description_offer = $request->input('edit-description-offer-cooperation');
        $edit_id_status_offer = $request->input('edit-status-offer-cooperation');
        $edit_id_field_offer = $request->input('edit-field-offer-cooperation');

        $result = DB::update('
            UPDATE offer_cooperation
            SET name = :name, description = :description, id_field = :id_field, id_status = :id_status
            WHERE id_offer = :id_offer;
        ', [
            ':name' => $edit_name_offer,
            ':description' => $edit_description_offer,
            ':id_field' => $edit_id_field_offer,
            ':id_status' => $edit_id_status_offer,
            ':id_offer' => $edit_id_offer
        ]);

        return $result;
    }

    private function remove_offer_cooperation(Request $request, $id_project)
    {
        $request->validate([
            'remove_id_offer' => 'required|integer',
        ]);

        $remove_id_offer = $request->input('remove_id_offer');

        $result = DB::delete('
            DELETE FROM offer_cooperation WHERE id_offer = :id_offer;
        ', [
            ':id_offer' => $remove_id_offer,
        ]);

        return $result;
    }


}
