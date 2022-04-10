<?php

namespace App\Repositories;

use App\Intefaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllProjects()
    {
        return DB::select('
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
        ', [':id_status' => 1, ':id_role' => 1]);
    }

    public function getSearchProjects($projectName)
    {
        return DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, DATE(p.create_date) as create_date,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.id_status as u_id_status
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_status = :id_status
                AND   r.id_role = :id_role
                AND   p.name LIKE :p_name
            ORDER BY p.create_date DESC;
        ', [':id_status' => 1, ':id_role' => 1, ':p_name' => $projectName]);
    }

    public function getProjectById($id_project)
    {
        return DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.id_status as s_id_status,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                AND   c.id_role = :id_role
                AND   u.id_status = :id_status;
        ', [':id_project' => $id_project, ':id_role' => 1, ':id_status' => 1]);
    }

    public function getTeamMembersByProjectId($id_project)
    {
        return DB::select('
        SELECT u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.login as u_login, r.name as r_name,
               r.id_role as r_id_role
        FROM users u, cooperation c, project p, role r
            WHERE u.id_user = c.id_user
            AND   c.id_project = p.id_project
            AND   c.id_role = r.id_role
            AND   p.id_project = :id_project
            ORDER BY c.id_role;
        ', ['id_project' => $id_project]);
    }

    public function removeTeamMember($id_project, $id_user)
    {
        return DB::delete('
            DELETE FROM cooperation WHERE id_user = :id_user AND id_project = :id_project AND id_role = :id_role
        ', [':id_user' => $id_user, ':id_project' => $id_project, ':id_role' => 2]);
    }

    public function getOffersCooperationByProjectId($id_project)
    {
        return DB::select('
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
    }

    public function getProjectsByUserId($id_user, $id_role)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, p.abstract as p_abstract, s.id_status as s_id_status,
                   s.name as s_name, u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
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
        ', [
            ':id_user' => $id_user,
            ':id_role' => $id_role,
        ]);
    }

    public function editProjectById($id_project, $edit_name, $edit_abstract, $edit_description, $edit_status)
    {
        return DB::update('
            UPDATE project
                SET name = :name, abstract = :abstract,
                    description = :description, id_status = :id_status
                WHERE id_project = :id_project;
        ', [':name' => $edit_name, ':abstract' => $edit_abstract, ':description' => $edit_description,
            ':id_status' => $edit_status, ':id_project' => $id_project]);
    }

    public function createNewProject($logged_user_id, $name, $abstract, $description, $create_date, $status = 1)
    {
        return DB::transaction(function () use ($name, $abstract, $description, $create_date, $logged_user_id) {
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
        });
    }

    public function deleteProjectById($id_project)
    {
        return DB::delete('
            DELETE FROM project WHERE id_project=:id_project
        ', ['id_project' => $id_project]);
    }
}
