<?php

namespace App\Repositories;

use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return DB::select('
                SELECT u.id_user, u.first_name, u.last_name, u.login, u.email, u.id_status, u.id_right, s.name as s_name, r.name as r_name
                FROM users u
                LEFT JOIN status_user s
                ON u.id_status = s.id_status
                LEFT JOIN `right` r
                ON u.id_right = r.id_right;
            ');
    }

    public function getAllActiveUsers()
    {
        return DB::select('
                SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u
                    WHERE id_status = 1;
            ');
    }

    public function getSearchActiveUsers($first_name, $last_name)
    {
        return DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u
                WHERE id_status = 1
                AND   u.first_name LIKE :first_name
                AND   u.last_name LIKE :last_name;
        ', [':first_name' => $first_name, ':last_name' => $last_name]);
    }

    public function getUserById($id_user) {
        return DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.login, u.email, u.description, u.id_status, u.id_right
                FROM users u
                WHERE u.id_user = :id_user
        ', [
            ':id_user' => $id_user,
        ]);
    }

    public function getActiveUserById($id_user)
    {
        return DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.login, u.email, u.description
                FROM users u
                WHERE u.id_user = :id_user
                AND   u.id_status = 1;
        ', [
            ':id_user' => $id_user,
        ]);
    }

    public function getUserFieldsByUserId($id_user)
    {
        return DB::select('
            SELECT f.id_field as f_id_field, f.name as f_name FROM users_field uf, field f
            WHERE uf.id_field = f.id_field
            AND   id_user = :id_user;
        ', [':id_user' => $id_user]);
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

    public function getUserAsTeamMember($id_user, $id_project)
    {
        return DB::select('
            SELECT c.id_role
            FROM project p, cooperation c
            WHERE p.id_project = c.id_project
            AND p.id_project = :id_project
            AND c.id_user = :id_user;
        ', [
            ':id_project' => $id_project,
            ':id_user' => $id_user
        ]);
    }

    public function editUserById($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description)
    {
        $user = User::find($id_user);
        $user->first_name = $edit_first_name;
        $user->last_name = $edit_last_name;
        $user->email = $edit_email;
        $user->description = $edit_description;
        $user->save();
    }

    public function editUserByIdSuperAdmin($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description, $id_status, $id_right)
    {
        $user = User::find($id_user);
        $user->first_name = $edit_first_name;
        $user->last_name = $edit_last_name;
        $user->email = $edit_email;
        $user->description = $edit_description;
        $user->id_status = $id_status;
        $user->id_right = $id_right;
        $user->save();
    }

    public function deleteUserById($id_user, $projects, ProjectRepositoryInterface $projectRepository)
    {
        $result = DB::transaction(function () use ($id_user, $projects, $projectRepository){
            foreach ($projects as $project) {
                $projectRepository->deleteProjectById($project->p_id_project); //smazu autorske projekty, kaskadou se smazou i nabidky
            }
            DB::delete('DELETE FROM users WHERE id_user = :id_user', [':id_user' => $id_user]);
        });
        return $result;
    }


}
