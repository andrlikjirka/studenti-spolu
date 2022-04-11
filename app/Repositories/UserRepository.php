<?php

namespace App\Repositories;

use App\Intefaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
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

}
